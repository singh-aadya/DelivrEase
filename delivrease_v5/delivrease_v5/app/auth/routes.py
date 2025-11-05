from flask import Blueprint, render_template, request, redirect, url_for, session, flash
from ..models import User

auth_bp = Blueprint("auth", __name__, template_folder="templates")

@auth_bp.route("/login", methods=["GET","POST"])
def login():
    if request.method == "POST":
        username = request.form.get("username","").strip()
        password = request.form.get("password","").strip()
        role = request.form.get("role","").strip()
        user = User.query.filter_by(username=username, role=role).first()
        if user and user.check_password(password):
            session["user_id"] = user.id
            session["role"] = user.role
            flash("Welcome back!", "success")
            if role == "admin":
                return redirect(url_for("admin.dashboard"))
            else:
                return redirect(url_for("delivery.dashboard"))
        flash("Invalid credentials", "danger")
    return render_template("auth/login.html")

@auth_bp.route("/logout")
def logout():
    session.clear()
    flash("Logged out", "info")
    return redirect(url_for("main.index"))
