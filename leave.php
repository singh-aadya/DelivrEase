<?php
$activePage = 'leave';
$pageTitle = 'Leave Management';
$pageSubtitle = 'Process and track worker leave requests';
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Management - DelivrEase</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
<?php include 'components/sidebar.php'; ?>
<div class="main">
    <?php include 'components/header.php'; ?>
    <div style="margin:2rem 2.5rem 0 2.5rem;">
        <div class="card">
            <div style="display:flex;justify-content:space-between;align-items:center;">
                <div class="section-title" style="display:flex;align-items:center;gap:0.5rem;"><i class="fa-solid fa-calendar-check"></i> Leave Requests</div>
                <button class="btn btn-primary" style="font-size:1rem;padding:0.6rem 1.2rem;"><i class="fa-solid fa-calendar-plus"></i> New Leave Request</button>
            </div>
            <form id="addLeaveForm" class="form-row" style="margin-bottom:2rem;gap:1rem;align-items:flex-end;">
                <select class="form-input" name="worker_id" id="workerSelect" required></select>
                <input class="form-input" type="date" name="start_date" required>
                <input class="form-input" type="date" name="end_date" required>
                <button class="btn btn-primary" type="submit">Request Leave</button>
            </form>
            <div id="leaveResult" style="margin-bottom:1.5rem;"></div>
            <table class="styled-table" style="width:100%;border-collapse:separate;border-spacing:0 0.5rem;">
                <thead>
                    <tr class="table-header" style="text-align:left;font-size:1.05rem;">
                        <th>Worker</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="leaves-table-body" style="font-size:1.08rem;"></tbody>
            </table>
        </div>
    </div>
</div>
<div class="theme-toggle" title="Toggle dark mode">
    <i class="fa-solid fa-moon"></i>
</div>
<div class="loading" style="display:none;">
    <div class="loading-spinner"></div>
</div>
<script>
const themeToggle = document.querySelector('.theme-toggle');
const htmlElement = document.documentElement;
const savedTheme = localStorage.getItem('theme') || 'light';
htmlElement.setAttribute('data-theme', savedTheme);
function updateThemeIcon(theme) {
    const icon = themeToggle.querySelector('i');
    if (theme === 'dark') {
        icon.classList.remove('fa-moon');
        icon.classList.add('fa-sun');
    } else {
        icon.classList.remove('fa-sun');
        icon.classList.add('fa-moon');
    }
}
updateThemeIcon(savedTheme);
themeToggle.addEventListener('click', () => {
    const currentTheme = htmlElement.getAttribute('data-theme');
    const newTheme = currentTheme === 'light' ? 'dark' : 'light';
    htmlElement.setAttribute('data-theme', newTheme);
    localStorage.setItem('theme', newTheme);
    updateThemeIcon(newTheme);
});
window.addEventListener('DOMContentLoaded', () => {
    const loading = document.querySelector('.loading');
    loading.style.display = 'flex';
    setTimeout(() => { loading.style.display = 'none'; }, 800);
});
function loadWorkers() {
    fetch('api/workers.php')
      .then(res => res.json())
      .then(data => {
        let html = '<option value="">Select Worker</option>';
        data.forEach(worker => {
          html += `<option value="${worker.id}">${worker.name}</option>`;
        });
        document.getElementById('workerSelect').innerHTML = html;
      });
}
function loadLeaves() {
    fetch('api/leaves.php')
      .then(res => res.json())
      .then(data => {
        let html = '';
        data.forEach(leave => {
          html += `<tr class="table-row">
            <td>${leave.worker_name ?? ''}</td>
            <td>${leave.start_date}</td>
            <td>${leave.end_date}</td>
            <td>${leave.status}</td>
          </tr>`;
        });
        document.getElementById('leaves-table-body').innerHTML = html;
      });
}
document.getElementById('addLeaveForm').onsubmit = function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch('api/add_leave.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById('leaveResult').innerHTML = '<span class="success">Leave requested!</span>';
            loadLeaves();
            this.reset();
        } else {
            document.getElementById('leaveResult').innerHTML = '<span class="error">Error requesting leave.</span>';
        }
    });
};
loadWorkers();
loadLeaves();
</script>
</body>
</html> 