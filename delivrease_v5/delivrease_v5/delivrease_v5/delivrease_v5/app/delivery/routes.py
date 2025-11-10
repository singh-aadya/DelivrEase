from flask import Blueprint, render_template, request, redirect, url_for, session, flash
from datetime import datetime
from ..models import db, User, Order, LeaveRequest, fatigue_score, fatigue_history

delivery_bp = Blueprint("delivery", __name__, template_folder="templates")

def require_agent(fn):
    from functools import wraps
    @wraps(fn)
    def wrap(*a, **k):
        if not session.get("user_id") or session.get("role") != "agent":
            flash("Agent login required", "warning"); return redirect(url_for("auth.login"))
        return fn(*a, **k)
    return wrap

@delivery_bp.route("/dashboard")
@require_agent
def dashboard():
    uid = session["user_id"]
    orders = Order.query.filter_by(assigned_to_id=uid).order_by(Order.created_at.desc()).all()
    fatigue = fatigue_score(uid)
    leaves = LeaveRequest.query.filter_by(user_id=uid).order_by(LeaveRequest.created_at.desc()).all()
    
    # Count pending leaves for quick summary
    pending_count = LeaveRequest.query.filter_by(user_id=uid, status="pending").count()

    return render_template(
        "delivery/dashboard.html",
        orders=orders,
        fatigue=fatigue,
        leaves=leaves,
        pending_count=pending_count
    )
@delivery_bp.route("/orders/<int:order_id>/delivered", methods=["POST"])
@require_agent
def mark_delivered(order_id):
    uid = session["user_id"]
    o = Order.query.get(order_id)
    if o and o.assigned_to_id == uid:
        o.status = "delivered"; db.session.commit(); flash("Marked delivered", "success")
    return redirect(url_for("delivery.dashboard"))

# @delivery_bp.route("/leave", methods=["GET","POST"])
# @require_agent
# def leave():
#     if request.method=="POST":
#         uid = session["user_id"]
#         df = datetime.fromisoformat(request.form["date_from"]).date()
#         dt = datetime.fromisoformat(request.form["date_to"]).date()
#         reason = request.form.get("reason","")
#         lr = LeaveRequest(user_id=uid, date_from=df, date_to=dt, reason=reason)
#         db.session.add(lr); db.session.commit(); flash("Leave request submitted", "success")
#         return redirect(url_for("delivery.leave"))
#     return render_template("delivery/leave.html")

# from datetime import datetime
# from flask import flash, redirect, render_template, request, url_for, session
# from app.models import LeaveRequest, db

# @delivery_bp.route("/leave", methods=["GET", "POST"])
# @require_agent
# def leave():
#     if request.method == "POST":
#         uid = session["user_id"]
#         date_from = request.form["date_from"]
#         date_to = request.form["date_to"]
#         reason = request.form["reason"].strip() or None

#         try:
#             start = datetime.strptime(date_from, "%Y-%m-%d").date()
#             end = datetime.strptime(date_to, "%Y-%m-%d").date()

#             # Validation check — end must be after or same as start
#             if end < start:
#                 flash("Invalid date range. 'To' date cannot be earlier than 'From' date.", "danger")
#                 return redirect(url_for("delivery.leave"))
#         except ValueError:
#             flash("Invalid date format.", "danger")
#             return redirect(url_for("delivery.leave"))

#         leave = LeaveRequest(user_id=uid, date_from=start, date_to=end, reason=reason, status="pending")
#         db.session.add(leave)
#         db.session.commit()
#         flash("Leave request submitted successfully.", "success")
#         return redirect(url_for("delivery.dashboard"))

#     return render_template("delivery/leave.html")
from datetime import datetime, date
from flask import flash, redirect, render_template, request, url_for, session
from app.models import LeaveRequest, db

@delivery_bp.route("/leave", methods=["GET", "POST"])
@require_agent
def leave():
    if request.method == "POST":
        uid = session["user_id"]
        date_from = request.form["date_from"]
        date_to = request.form["date_to"]
        reason = request.form["reason"].strip() or None

        try:
            start = datetime.strptime(date_from, "%Y-%m-%d").date()
            end = datetime.strptime(date_to, "%Y-%m-%d").date()
            today = date.today()

            # ✅ Validation 1: Cannot apply for leave in the past
            if start < today:
                flash("You cannot apply for leave starting in the past.", "danger")
                return redirect(url_for("delivery.leave"))

            # ✅ Validation 2: 'To' date must not be earlier than 'From' date
            if end < start:
                flash("Invalid date range. 'To' date cannot be earlier than 'From' date.", "danger")
                return redirect(url_for("delivery.leave"))

        except ValueError:
            flash("Invalid date format.", "danger")
            return redirect(url_for("delivery.leave"))

        leave = LeaveRequest(user_id=uid, date_from=start, date_to=end, reason=reason, status="pending")
        db.session.add(leave)
        db.session.commit()
        flash("Leave request submitted successfully.", "success")
        return redirect(url_for("delivery.dashboard"))

    return render_template("delivery/leave.html")


@delivery_bp.route("/history")
@require_agent
def history():
    uid = session["user_id"]
    orders = Order.query.filter_by(assigned_to_id=uid).order_by(Order.created_at.desc()).all()
    leaves = LeaveRequest.query.filter_by(user_id=uid).order_by(LeaveRequest.created_at.desc()).all()
    return render_template("delivery/history.html", orders=orders, leaves=leaves)

# @delivery_bp.route("/analytics")
# @require_agent
# def analytics():
#     return render_template("delivery/analytics.html")

# @delivery_bp.route("/api/stats")
# @require_agent
# def api_stats():
#     uid = session["user_id"]
#     hist = fatigue_history(uid, days=7)
#     total = Order.query.filter_by(assigned_to_id=uid, status="delivered").count()
#     leaves = LeaveRequest.query.filter_by(user_id=uid).count()
#     avg = round(sum(h['fatigue'] for h in hist)/len(hist), 2) if hist else 0
#     return {"history": hist, "summary": {"total_deliveries": total, "leaves_count": leaves, "avg_fatigue": avg}}
