from datetime import datetime, date, timedelta
from flask_sqlalchemy import SQLAlchemy
from werkzeug.security import generate_password_hash, check_password_hash
from app import db


class User(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    username = db.Column(db.String(64), unique=True, nullable=False)
    password_hash = db.Column(db.String(255), nullable=False)
    role = db.Column(db.String(16), nullable=False)  # admin | agent
    active = db.Column(db.Boolean, default=True)

    orders = db.relationship("Order", backref="agent", lazy=True, foreign_keys="Order.assigned_to_id")
    leave_requests = db.relationship("LeaveRequest", backref="user", lazy=True)

    def set_password(self, pw):
        self.password_hash = generate_password_hash(pw)

    def check_password(self, pw):
        return check_password_hash(self.password_hash, pw)

class Order(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    title = db.Column(db.String(120), nullable=False)
    pickup = db.Column(db.String(120), nullable=False)
    dropoff = db.Column(db.String(120), nullable=False)
    distance_km = db.Column(db.Float, default=2.0)
    status = db.Column(db.String(32), default="pending")  # pending | assigned | delivered
    assigned_to_id = db.Column(db.Integer, db.ForeignKey("user.id"))
    created_at = db.Column(db.DateTime, default=datetime.utcnow)

class LeaveRequest(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    user_id = db.Column(db.Integer, db.ForeignKey("user.id"), nullable=False)
    date_from = db.Column(db.Date, nullable=False)
    date_to = db.Column(db.Date, nullable=False)
    reason = db.Column(db.String(255))
    status = db.Column(db.String(16), default="pending")  # pending | approved | declined
    created_at = db.Column(db.DateTime, default=datetime.utcnow)

# Fatigue constants
F_ORDERS = 0.6
F_KM = 0.08

def orders_and_km_by_day(user_id, day):
    s = datetime.combine(day, datetime.min.time())
    e = datetime.combine(day, datetime.max.time())
    q = Order.query.filter(Order.assigned_to_id == user_id, Order.created_at >= s, Order.created_at <= e).all()
    return len(q), sum(o.distance_km for o in q)

def fatigue_score(user_id):
    today = date.today()
    n, km = orders_and_km_by_day(user_id, today)
    return round(F_ORDERS*n + F_KM*km, 2)

def fatigue_history(user_id, days=7):
    out = []
    today = date.today()
    for i in range(days-1, -1, -1):
        d = today - timedelta(days=i)
        n, km = orders_and_km_by_day(user_id, d)
        out.append({"date": d.isoformat(), "orders": n, "km": km, "fatigue": round(F_ORDERS*n + F_KM*km, 2)})
    return out

def assignment_score(user_id, order_distance_km):
    return round(fatigue_score(user_id) + (order_distance_km / 12.0), 2)

def seed_data():
    if not User.query.first():
        admin = User(username="admin", role="admin"); admin.set_password("admin123")
        a1 = User(username="agent1", role="agent"); a1.set_password("agent123")
        a2 = User(username="agent2", role="agent"); a2.set_password("agent123")
        db.session.add_all([admin, a1, a2]); db.session.commit()
    if not Order.query.first():
        db.session.add_all([
            Order(title="Order #3001", pickup="Warehouse A", dropoff="Sector 12", distance_km=3.2),
            Order(title="Order #3002", pickup="Warehouse A", dropoff="River Park", distance_km=7.9),
            Order(title="Order #3003", pickup="Hub B", dropoff="Old Town", distance_km=5.4),
        ])
        db.session.commit()
