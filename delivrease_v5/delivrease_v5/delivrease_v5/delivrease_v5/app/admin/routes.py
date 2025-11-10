from flask import Blueprint, render_template, request, redirect, url_for, session, flash, Response
from ..models import db, User, Order, LeaveRequest, fatigue_score, assignment_score
from datetime import datetime, timedelta, date

admin_bp = Blueprint("admin", __name__, template_folder="templates")

def require_admin(fn):
    from functools import wraps
    @wraps(fn)
    def wrap(*a, **k):
        if not session.get("user_id") or session.get("role") != "admin":
            flash("Admin login required", "warning"); return redirect(url_for("auth.login"))
        return fn(*a, **k)
    return wrap

@admin_bp.route("/dashboard")
@require_admin
def dashboard():
    q = request.args.get('q', '').strip()
    status = request.args.get('status', '').strip()

    agents = User.query.filter_by(role='agent', active=True).all()
    orders_q = Order.query
    if q:
        orders_q = orders_q.filter(Order.title.contains(q))
    if status:
        orders_q = orders_q.filter(Order.status == status)
    orders = orders_q.order_by(Order.created_at.desc()).all()

    # Prepare agent fatigue data
    data = []
    for a in agents:
        assigned = Order.query.filter_by(assigned_to_id=a.id, status='assigned').count()
        fatigue = fatigue_score(a.id)
        data.append({
            "username": a.username,
            "assigned": assigned,
            "fatigue": fatigue
        })

    return render_template("admin/dashboard.html", agents=agents, orders=orders, data=data)

@admin_bp.route("/orders/new", methods=["GET","POST"])
@require_admin
def new_order():
    if request.method == "POST":
        title = request.form.get("title","Order").strip()
        pickup = request.form.get("pickup","Unknown").strip()
        dropoff = request.form.get("dropoff","Unknown").strip()
        try:
            distance_km = float(request.form.get("distance_km","0") or 0)
        except:
            distance_km = 0.0
        o = Order(title=title, pickup=pickup, dropoff=dropoff, distance_km=distance_km, status="pending")
        db.session.add(o); db.session.commit()
        flash("Order created", "success")
        return redirect(url_for("admin.dashboard"))
    return render_template("admin/new_order.html")

@admin_bp.route("/assign", methods=["GET", "POST"])
@require_admin
def assign():
    agents = User.query.filter_by(role="agent", active=True).all()
    orders = Order.query.filter(Order.status != "delivered").all()

    selected_order = None
    ranked_agents = []

    # When opening from dashboard
    order_id = request.args.get("order_id", type=int)
    if order_id:
        selected_order = Order.query.get(order_id)
        if selected_order:
            ranked_agents = sorted(
                [
                    {"agent": a, "score": assignment_score(a.id, selected_order.distance_km)}
                    for a in agents
                ],
                key=lambda x: x["score"]
            )

    # Handle form submission
    if request.method == "POST":
        order_id = int(request.form["order_id"])
        agent_id = int(request.form["agent_id"])
        order = Order.query.get(order_id)
        agent = User.query.get(agent_id)
        if not order or not agent:
            flash("Invalid order or agent.", "danger")
            return redirect(url_for("admin.dashboard"))
        order.assigned_to_id = agent.id
        order.status = "assigned"
        db.session.commit()
        flash(f"Assigned {order.title} to {agent.username}", "success")
        return redirect(url_for("admin.dashboard"))

    return render_template(
        "admin/assign.html",
        agents=agents,
        orders=orders,
        selected_order=selected_order,
        ranked_agents=ranked_agents
    )


@admin_bp.route("/orders/<int:order_id>/status", methods=["POST"])
@require_admin
def set_status(order_id):
    status = request.form.get("status")
    o = Order.query.get(order_id)
    if o and status in ["pending","assigned","delivered"]:
        o.status = status
        if status == "pending":
            o.assigned_to_id = None
        db.session.commit()
        flash("Status updated", "success")
    return redirect(url_for("admin.dashboard"))

@admin_bp.route("/leaves", methods=["GET","POST"])
@require_admin
def leaves():
    reqs = LeaveRequest.query.order_by(LeaveRequest.created_at.desc()).all()
    if request.method=="POST":
        rid = int(request.form["req_id"]); action = request.form["action"]
        lr = LeaveRequest.query.get(rid)
        if lr and action in ["approved","declined"]:
            lr.status = action; db.session.commit(); flash(f"Leave {action}", "success")
        return redirect(url_for("admin.leaves"))
    return render_template("admin/leaves.html", requests=reqs)

@admin_bp.route("/performance")
@require_admin
def performance():
    agents = User.query.filter_by(role="agent", active=True).all()
    board = []
    for a in agents:
        delivered = Order.query.filter_by(assigned_to_id=a.id, status="delivered").count()
        leaves = LeaveRequest.query.filter_by(user_id=a.id, status="approved").count()
        board.append({"username": a.username, "delivered": delivered, "leaves": leaves, "fatigue": fatigue_score(a.id)})
    return render_template("admin/performance.html", board=board)



@admin_bp.route("/export/orders.csv")
@require_admin
def export_orders():
    rows = ["id,title,pickup,dropoff,distance_km,status,assigned_to,created_at"]
    for o in Order.query.order_by(Order.created_at.desc()).all():
        rows.append(f"{o.id},{o.title},{o.pickup},{o.dropoff},{o.distance_km},{o.status},{o.agent.username if o.agent else ''},{o.created_at.isoformat()}")
    return Response("\n".join(rows), mimetype="text/csv", headers={"Content-Disposition":"attachment; filename=orders.csv"})

@admin_bp.route("/export/leaves.csv")
@require_admin
def export_leaves():
    rows = ["id,user,from,to,reason,status,created_at"]
    for r in LeaveRequest.query.order_by(LeaveRequest.created_at.desc()).all():
        reason = (r.reason or '').replace(',', ' ')
        rows.append(f"{r.id},{r.user.username},{r.date_from},{r.date_to},{reason},{r.status},{r.created_at.isoformat()}")
    return Response("\n".join(rows), mimetype="text/csv", headers={"Content-Disposition":"attachment; filename=leaves.csv"})
