from functools import wraps
from flask import session, redirect, url_for, flash

def require_admin(fn):
    @wraps(fn)
    def wrapper(*a, **k):
        if session.get("role") != "admin":
            flash("Admin login required", "danger")
            return redirect(url_for("auth.login"))
        return fn(*a, **k)
    return wrapper

def require_agent(fn):
    @wraps(fn)
    def wrapper(*a, **k):
        if session.get("role") != "agent":
            flash("Agent login required", "danger")
            return redirect(url_for("auth.login"))
        return fn(*a, **k)
    return wrapper
