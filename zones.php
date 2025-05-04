<?php require 'session.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zones - DelivrEase</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f6f8fa; }
        .container { max-width: 600px; margin: 2rem auto; background: #fff; border-radius: 1.5rem; box-shadow: 0 2px 12px 0 rgba(16,30,54,0.08); padding: 2rem; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 2rem; }
        th, td { padding: 0.7rem 1rem; text-align: left; }
        th { background: #f1f5f9; }
        tr:nth-child(even) { background: #f9fafb; }
        .success { color: #22c55e; }
        .error { color: #ef4444; }
        .form-row { display: flex; gap: 1rem; margin-bottom: 1rem; }
        .form-row input { flex: 1; padding: 0.5rem; border-radius: 0.5rem; border: 1px solid #e5e7eb; }
        .form-row button { padding: 0.5rem 1.5rem; border-radius: 0.5rem; border: none; background: #5AC994; color: #fff; font-weight: 600; cursor: pointer; }
        .form-row button:hover { background: #4F46E5; }
        .delete-btn { color: #ef4444; cursor: pointer; border: none; background: none; }
    </style>
</head>
<body>
<?php include 'components/sidebar.php'; ?>
<div class="main">
    <div class="card" style="margin:2rem auto;max-width:700px;">
        <div class="section-title" style="font-size:2rem;margin-bottom:2rem;">Zones</div>
        <form id="addZoneForm" class="form-row" style="margin-bottom:2rem;gap:1rem;align-items:flex-end;">
            <input class="form-input" type="text" name="name" placeholder="Zone Name" required>
            <button class="btn btn-primary" type="submit">Add Zone</button>
        </form>
        <div id="zoneResult" style="margin-bottom:1.5rem;"></div>
        <table class="styled-table" style="width:100%;border-collapse:separate;border-spacing:0 0.5rem;">
            <thead>
                <tr class="table-header" style="text-align:left;font-size:1.05rem;">
                    <th>Zone Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="zones-table-body" style="font-size:1.08rem;"></tbody>
        </table>
    </div>
</div>
<script>
function loadZones() {
    fetch('api/zones.php')
      .then(res => res.json())
      .then(data => {
        let html = '';
        data.forEach(zone => {
          html += `<tr class="table-row">
            <td>${zone.name}</td>
            <td><button class="btn btn-secondary delete-btn" onclick="deleteZone(${zone.id})">Delete</button></td>
          </tr>`;
        });
        document.getElementById('zones-table-body').innerHTML = html;
      });
}
document.getElementById('addZoneForm').onsubmit = function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch('api/add_zone.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById('zoneResult').innerHTML = '<span class="success">Zone added!</span>';
            loadZones();
            this.reset();
        } else {
            document.getElementById('zoneResult').innerHTML = '<span class="error">Error adding zone.</span>';
        }
    });
};
function deleteZone(id) {
    if (!confirm('Delete this zone?')) return;
    fetch('api/delete_zone.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'id=' + encodeURIComponent(id)
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            loadZones();
        }
    });
}
loadZones();
</script>
</body>
</html>