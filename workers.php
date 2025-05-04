<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workers - DelivrEase</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<?php include 'components/sidebar.php'; ?>
<div class="main">
    <div class="card" style="margin:2rem auto;max-width:1100px;">
        <div class="section-title" style="font-size:2rem;margin-bottom:2rem;">Workers</div>
        <button class="btn btn-primary" id="addWorkerBtn" style="height:44px;align-self:flex-start;margin-bottom:1.5rem;"><i class="fas fa-user-plus"></i> Add Worker</button>
        <table class="styled-table" style="width:100%;border-collapse:separate;border-spacing:0 0.5rem;">
            <thead>
                <tr class="table-header" style="text-align:left;font-size:1.05rem;">
                    <th>Worker ID</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Zones</th>
                    <th>Fatigue Level</th>
                    <th>Deliveries Today</th>
                    <th>Contact</th>
                </tr>
            </thead>
            <tbody id="workers-table-body" style="font-size:1.08rem;"></tbody>
        </table>
    </div>
    <!-- Add Worker Modal -->
    <div class="modal" id="addWorkerModal" style="display: none;">
        <div class="modal-content card">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold">Add New Worker</h3>
                <button class="modal-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="addWorkerForm" class="form-row space-y-4">
                <input class="form-input" type="text" name="name" placeholder="Enter worker's full name" required>
                <input class="form-input" type="email" name="email" placeholder="Enter worker's email" required>
                <select class="form-input" name="zone_ids[]" id="zoneSelect" multiple required></select>
                <input class="form-input" type="tel" name="contact_number" placeholder="Enter contact number" required>
                <div class="flex justify-end space-x-4">
                    <button type="button" class="btn btn-secondary modal-close">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Worker</button>
                </div>
            </form>
            <div style="font-size:0.9em;color:#888;margin-bottom:1em;">Hold Ctrl (Windows) or Cmd (Mac) to select multiple zones.</div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const addWorkerBtn = document.getElementById('addWorkerBtn');
    const addWorkerModal = document.getElementById('addWorkerModal');
    const modalCloseButtons = document.querySelectorAll('.modal-close');

    addWorkerBtn.addEventListener('click', () => {
        addWorkerModal.style.display = 'flex';
    });

    modalCloseButtons.forEach(button => {
        button.addEventListener('click', () => {
            addWorkerModal.style.display = 'none';
        });
    });

    // Close modal when clicking outside
    window.addEventListener('click', (e) => {
        if (e.target === addWorkerModal) {
            addWorkerModal.style.display = 'none';
        }
    });

    function loadZones() {
        fetch('api/zones.php')
          .then(res => res.json())
          .then(data => {
            let html = '';
            data.forEach(zone => {
              html += `<option value="${zone.id}">${zone.name}</option>`;
            });
            document.getElementById('zoneSelect').innerHTML = html;
          });
    }

    function loadWorkers() {
        fetch('api/workers.php')
          .then(res => res.json())
          .then(data => {
            let html = '';
            data.forEach(worker => {
              html += `<tr class="table-row">
                <td><b>WRK-${worker.id.toString().padStart(4, '0')}</b></td>
                <td>${worker.name}</td>
                <td><span class="status ${worker.on_leave ? 'status-leave' : 'status-available'}">${worker.on_leave ? 'On Leave' : 'Active'}</span></td>
                <td>${worker.zones.map(z => z.name).join(', ')}</td>
                <td><span class="status ${worker.fatigue_score > 70 ? 'status-leave' : worker.fatigue_score > 40 ? 'status-fatigued' : 'status-available'}">${worker.fatigue_score > 70 ? 'High' : worker.fatigue_score > 40 ? 'Medium' : 'Low'}</span></td>
                <td>${worker.deliveries_today ?? 0}</td>
                <td>${worker.contact_number ?? ''}</td>
              </tr>`;
            });
            document.getElementById('workers-table-body').innerHTML = html;
          });
    }

    document.getElementById('addWorkerForm').onsubmit = function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        fetch('api/add_worker.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById('workerResult').innerHTML = '<span class="success">Worker added!</span>';
                loadWorkers();
                this.reset();
            } else {
                document.getElementById('workerResult').innerHTML = '<span class="error">Error adding worker.</span>';
            }
        });
    };

    loadZones();
    loadWorkers();
});
</script>
</body>
</html>

<?php include 'db.php'; ?>
<div class="workers-page" style="margin:2rem 2.5rem 0 2.5rem;">
    <div style="display:flex;justify-content:space-between;align-items:center;">
        <div>
            <h1 class="header-title" style="font-size:2.3rem;">Workers</h1>
            <div class="header-desc" style="margin-bottom:2.5rem;">Monitor and manage delivery personnel</div>
        </div>
        <button class="btn btn-primary" id="addWorkerBtn" style="height:44px;align-self:flex-start;"><i class="fas fa-user-plus"></i> Add Worker</button>
    </div>
    <div class="card">
        <div class="section-title" style="display:flex;align-items:center;gap:0.7rem;font-size:1.4rem;margin-bottom:1.5rem;"><i class="fa-solid fa-users"></i> Active Workers</div>
        <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:separate;border-spacing:0 0.5rem;">
            <thead>
                <tr class="table-header" style="text-align:left;font-size:1.05rem;">
                    <th>Worker ID</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Zone</th>
                    <th>Fatigue Level</th>
                    <th>Deliveries Today</th>
                    <th>Contact</th>
                </tr>
            </thead>
            <tbody id="workers-table-body" style="font-size:1.08rem;"></tbody>
        </table>
        </div>
    </div>
</div>

<!-- Add Worker Modal -->
<div class="modal" id="addWorkerModal" style="display: none;">
    <div class="modal-content card">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold">Add New Worker</h3>
            <button class="modal-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="addWorkerForm" class="space-y-4">
            <div class="form-group">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" placeholder="Enter worker's full name" required>
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" placeholder="Enter worker's email" required>
            </div>
            <div class="form-group">
                <label class="form-label">Zone Assignment</label>
                <select name="zone_ids[]" id="zoneSelect" multiple required>
                    <!-- Populated by JS -->
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Contact Number</label>
                <input type="tel" name="contact_number" placeholder="Enter contact number" required>
            </div>
            <div class="flex justify-end space-x-4">
                <button type="button" class="btn btn-secondary modal-close">Cancel</button>
                <button type="submit" class="btn btn-primary">Add Worker</button>
            </div>
        </form>
        <div style="font-size:0.9em;color:#888;margin-bottom:1em;">Hold Ctrl (Windows) or Cmd (Mac) to select multiple zones.</div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const addWorkerBtn = document.getElementById('addWorkerBtn');
    const addWorkerModal = document.getElementById('addWorkerModal');
    const modalCloseButtons = document.querySelectorAll('.modal-close');

    addWorkerBtn.addEventListener('click', () => {
        addWorkerModal.style.display = 'flex';
    });

    modalCloseButtons.forEach(button => {
        button.addEventListener('click', () => {
            addWorkerModal.style.display = 'none';
        });
    });

    // Close modal when clicking outside
    window.addEventListener('click', (e) => {
        if (e.target === addWorkerModal) {
            addWorkerModal.style.display = 'none';
        }
    });

    function loadZones() {
        fetch('api/zones.php')
          .then(res => res.json())
          .then(data => {
            let html = '';
            data.forEach(zone => {
              html += `<option value="${zone.id}">${zone.name}</option>`;
            });
            document.getElementById('zoneSelect').innerHTML = html;
          });
    }

    function loadWorkers() {
        fetch('api/workers.php')
          .then(res => res.json())
          .then(data => {
            let html = '';
            data.forEach(worker => {
              html += `<tr class="table-row">
                <td><b>WRK-${worker.id.toString().padStart(4, '0')}</b></td>
                <td>${worker.name}</td>
                <td><span class="status ${worker.on_leave ? 'status-leave' : 'status-available'}">${worker.on_leave ? 'On Leave' : 'Active'}</span></td>
                <td>${worker.zones.map(z => z.name).join(', ')}</td>
                <td><span class="status ${worker.fatigue_score > 70 ? 'status-leave' : worker.fatigue_score > 40 ? 'status-fatigued' : 'status-available'}">${worker.fatigue_score > 70 ? 'High' : worker.fatigue_score > 40 ? 'Medium' : 'Low'}</span></td>
                <td>${worker.deliveries_today ?? 0}</td>
                <td>${worker.contact_number ?? ''}</td>
              </tr>`;
            });
            document.getElementById('workers-table-body').innerHTML = html;
          });
    }

    document.getElementById('addWorkerForm').onsubmit = function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        fetch('api/add_worker.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById('workerResult').innerHTML = '<span class="success">Worker added!</span>';
                loadWorkers();
                this.reset();
            } else {
                document.getElementById('workerResult').innerHTML = '<span class="error">Error adding worker.</span>';
            }
        });
    };

    loadZones();
    loadWorkers();
});
</script>

<?php
require '../db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $stmt = $pdo->prepare("DELETE FROM workers WHERE id = ?");
    $stmt->execute([$id]);
    echo json_encode(['success' => true]);
}
?>

<?php
require '../db.php';
header('Content-Type: application/json');
$stmt = $pdo->query("SELECT * FROM deliveries");
echo json_encode($stmt->fetchAll());
?>

<?php
require '../db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_code = $_POST['order_code'];
    $address = $_POST['address'];
    $zone_id = $_POST['zone_id'];
    // Find available worker in the zone with lowest fatigue
    $stmt = $pdo->prepare("SELECT * FROM workers WHERE zone_id = ? AND status = 'Available' ORDER BY fatigue_score ASC LIMIT 1");
    $stmt->execute([$zone_id]);
    $worker = $stmt->fetch();
    $assigned_worker_id = $worker ? $worker['id'] : null;
    $stmt = $pdo->prepare("INSERT INTO deliveries (order_code, address, assigned_worker_id, eta) VALUES (?, ?, ?, ?)");
    $stmt->execute([$order_code, $address, $assigned_worker_id, $_POST['eta']]);
    echo json_encode(['success' => true, 'assigned_worker_id' => $assigned_worker_id]);
}
?>

<?php
require '../db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $stmt = $pdo->prepare("DELETE FROM deliveries WHERE id = ?");
    $stmt->execute([$id]);
    echo json_encode(['success' => true]);
}
?>

<?php
require '../db.php';
header('Content-Type: application/json');
$stmt = $pdo->query("SELECT * FROM zones");
echo json_encode($stmt->fetchAll());
?>

<?php
require '../db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $stmt = $pdo->prepare("INSERT INTO zones (name) VALUES (?)");
    $stmt->execute([$name]);
    echo json_encode(['success' => true]);
}
?>

<?php
require '../db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $stmt = $pdo->prepare("DELETE FROM zones WHERE id = ?");
    $stmt->execute([$id]);
    echo json_encode(['success' => true]);
}
?>

<?php
require '../db.php';
header('Content-Type: application/json');
$stmt = $pdo->query("SELECT * FROM leaves");
echo json_encode($stmt->fetchAll());
?>

<?php
require '../db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $worker_id = $_POST['worker_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $stmt = $pdo->prepare("INSERT INTO leaves (worker_id, start_date, end_date) VALUES (?, ?, ?)");
    $stmt->execute([$worker_id, $start_date, $end_date]);
    echo json_encode(['success' => true]);
}
?> 