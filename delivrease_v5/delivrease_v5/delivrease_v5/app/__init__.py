from flask import Flask
from flask_sqlalchemy import SQLAlchemy

db = SQLAlchemy()

def create_app():
    app = Flask(__name__)
    app.config["SECRET_KEY"] = "your_secret_key"
    app.config["SQLALCHEMY_DATABASE_URI"] = "sqlite:///delivrease.sqlite"
    db.init_app(app)

    # Import and register Blueprints
    from app.main.routes import main_bp
    from app.admin.routes import admin_bp
    from app.delivery.routes import delivery_bp
    from app.auth.routes import auth_bp

    app.register_blueprint(main_bp)
    app.register_blueprint(admin_bp)
    app.register_blueprint(delivery_bp)
    app.register_blueprint(auth_bp)

    return app
