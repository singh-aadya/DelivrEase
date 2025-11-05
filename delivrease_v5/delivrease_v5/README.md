# Delivrease v5 (Flask, SQLite)
Complete, ready-to-run delivery management system with Admin & Agent roles.

## Demo Logins
- Admin: admin / admin123
- Agent: agent1 / agent123  (also agent2 / agent123)

## Run
```bash
python -m venv .venv
# Windows: .venv\Scripts\activate
# macOS/Linux:
source .venv/bin/activate
pip install -r requirements.txt
python run.py
```
Go to http://127.0.0.1:5000/

## Features
- Landing → Login → Dashboards
- Admin: create orders, assign (with ranking page), leaves, performance, analytics, exports, change status
- Agent: dashboard, mark delivered, request leave, history, analytics
- Fatigue formula: 0.6*orders_today + 0.08*km_today; assignment = fatigue + (distance/12) (edit in app/models.py)
