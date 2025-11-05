from flask import Flask
from .models import db, seed_data

def create_app():
    app = Flask(__name__, instance_relative_config=False)
    app.config.from_object("config.Config")
    db.init_app(app)

    from .main.routes import main_bp
    from .auth.routes import auth_bp
    from .admin.routes import admin_bp
    from .delivery.routes import delivery_bp

    app.register_blueprint(main_bp)
    app.register_blueprint(auth_bp, url_prefix="/auth")
    app.register_blueprint(admin_bp, url_prefix="/admin")
    app.register_blueprint(delivery_bp, url_prefix="/delivery")

    with app.app_context():
        db.create_all()
        seed_data()
    return app
