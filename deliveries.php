<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deliveries - DelivrEase</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<?php include 'components/sidebar.php'; ?>
<div class="main">
    <div class="card" style="margin:2rem auto;max-width:1100px;">
        <div class="section-title" style="font-size:2rem;margin-bottom:2rem;">Deliveries</div>
        <div id="analytics" style="display:flex;gap:2rem;margin-bottom:2rem;"></div>
        <form id="addDeliveryForm" class="form-row" style="margin-bottom:2rem;gap:1rem;align-items:flex-end;">
            <input class="form-input" type="text" name="order_code" placeholder="Order Code" required>
            <input class="form-input" type="text" name="pickup_location" placeholder="Pickup Location" required>
            <input class="form-input" type="text" name="delivery_location" placeholder="Delivery Location" required>
            <select class="form-input" name="zone_id" required id="zoneSelect">
                <option value="">Select Zone</option>
            </select>
            <input class="form-input" type="datetime-local" name="eta" placeholder="ETA" required>
            <button class="btn btn-primary" type="submit">Add Delivery</button>
        </form>
        <div id="deliveryResult" style="margin-bottom:1.5rem;"></div>
        <table class="styled-table" style="width:100%;border-collapse:separate;border-spacing:0 0.5rem;">
            <thead>
                <tr class="table-header" style="text-align:left;font-size:1.05rem;">
                    <th>Order Code</th>
                    <th>Pickup Location</th>
                    <th>Delivery Location</th>
                    <th>Zone</th>
                    <th>Assigned Worker</th>
                    <th>Status</th>
                    <th>ETA</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="deliveries-table-body" style="font-size:1.08rem;"></tbody>
        </table>
    </div>
</div>
<script>
function loadAnalytics() {
    fetch('api/deliveries.php')
      .then(res => res.json())
      .then(data => {
        let total = data.length;
        let completed = data.filter(d => d.status === 'Completed').length;
        let pending = data.filter(d => d.status === 'Pending').length;
        let avgTime = 0;
        let completedDeliveries = data.filter(d => d.status === 'Completed' && d.eta && d.created_at);
        if (completedDeliveries.length > 0) {
          let totalTime = completedDeliveries.reduce((sum, d) => sum + (new Date(d.eta) - new Date(d.created_at)), 0);
          avgTime = Math.round(totalTime / completedDeliveries.length / 60000); // in minutes
        }
        document.getElementById('analytics').innerHTML = `
          <div><b>Total Deliveries:</b> ${total}</div>
          <div><b>Completed:</b> ${completed}</div>
          <div><b>Pending:</b> ${pending}</div>
          <div><b>Avg. Delivery Time:</b> ${avgTime} min</div>
        `;
      });
}
function loadZones() {
    fetch('api/zones.php')
      .then(res => res.json())
      .then(data => {
        let html = '<option value="">Select Zone</option>';
        data.forEach(zone => {
          html += `<option value="${zone.id}">${zone.name}</option>`;
        });
        document.getElementById('zoneSelect').innerHTML = html;
      });
}
function loadDeliveries() {
    fetch('api/deliveries.php')
      .then(res => res.json())
      .then(data => {
        let html = '';
        data.forEach(delivery => {
          html += `<tr class="table-row">
            <td>${delivery.order_code}</td>
            <td>${delivery.pickup_location ?? ''}</td>
            <td>${delivery.delivery_location ?? ''}</td>
            <td>${delivery.zone_name ?? ''}</td>
            <td>${delivery.worker_name ?? 'Unassigned'}</td>
            <td>${delivery.status}</td>
            <td>${delivery.eta ? new Date(delivery.eta).toLocaleString() : ''}</td>
            <td><button class="btn btn-secondary delete-btn" onclick="deleteDelivery(${delivery.id})">Delete</button></td>
          </tr>`;
        });
        document.getElementById('deliveries-table-body').innerHTML = html;
      });
}
document.getElementById('addDeliveryForm').onsubmit = function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    
    // Prepare data for new API
    const deliveryData = {
        order_code: formData.get('order_code'),
        address: formData.get('delivery_location'),
        zone: document.querySelector('#zoneSelect option:checked').text,
        order_weight: 1, // Default weight, can be modified later
        eta: formData.get('eta')
    };

    // Log the data being sent
    console.log('Sending delivery data:', deliveryData);

    const urlEncodedData = Object.keys(deliveryData).map(key => 
        encodeURIComponent(key) + '=' + encodeURIComponent(deliveryData[key])
    ).join('&');

    fetch('api/add_delivery.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: urlEncodedData
    })
    .then(res => {
        // Log the raw response
        console.log('Raw response:', res);
        return res.json();
    })
    .then(data => {
        console.log('Parsed response:', data);
        if (data.success) {
            document.getElementById('deliveryResult').innerHTML = `<span class='success'>Delivery added and assigned to ${data.worker_name}!</span>`;
            loadDeliveries();
            loadAnalytics();
            this.reset();
        } else {
            document.getElementById('deliveryResult').innerHTML = `<span class='error'>${data.message || 'Failed to add delivery.'}</span>`;
        }
    })
    .catch(error => {
        console.error('Full error:', error);
        document.getElementById('deliveryResult').innerHTML = `<span class='error'>Error: ${error.message}</span>`;
    });
};
loadZones();
loadDeliveries();
loadAnalytics();
</script>
</body>
</html>
