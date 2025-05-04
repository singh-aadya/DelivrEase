<?php
$activePage = 'alerts';
$pageTitle = 'Alerts';
$pageSubtitle = 'Monitor and respond to system notifications';
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alerts - DelivrEase</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
<?php include 'components/sidebar.php'; ?>
<main class="main">
    <?php include 'components/header.php'; ?>
    <div style="margin:2rem 2.5rem 0 2.5rem;">
        <div class="card" style="margin-bottom:2rem;">
            <div style="background:#fee2e2;color:#ef4444;padding:1rem 1.5rem;border-radius:1rem;margin-bottom:1.5rem;display:flex;align-items:center;gap:1rem;">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <b>Active Alerts</b>
                <span>There are 3 active alerts requiring attention.</span>
            </div>
            <div class="section-title" style="display:flex;align-items:center;gap:0.5rem;"><i class="fa-solid fa-bell"></i> System Alerts</div>
            <div style="margin:1rem 0 1.5rem 0;display:flex;gap:1rem;">
                <button class="btn" style="background:#e5e7eb;color:#1e293b;">All</button>
                <button class="btn" style="background:#f3f4f6;color:#1e293b;">Active (3)</button>
                <button class="btn" style="background:#f3f4f6;color:#1e293b;">Resolved</button>
            </div>
            <table style="width:100%; border-collapse:separate; border-spacing:0 0.5rem;">
                <thead>
                    <tr style="color:var(--text-secondary); text-align:left; font-size:1rem;">
                        <th>ID</th>
                        <th>Type</th>
                        <th>Severity</th>
                        <th>Description</th>
                        <th>Worker</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody style="font-size:1.05rem;">
                    <tr>
                        <td>ALT-1001</td>
                        <td>Fatigue</td>
                        <td><span class="status status-fatigued" style="background:#fef3c7;color:#f59e0b;">High</span></td>
                        <td>Worker Lisa Brown has reached high fatigue levels</td>
                        <td>Lisa Brown (WRK-1004)</td>
                        <td><i class="fa-regular fa-clock"></i> 2025-04-30 09:15 AM</td>
                        <td><span class="status status-leave" style="background:#fee2e2;color:#ef4444;">● Active</span></td>
                        <td><button class="btn" style="background:#dcfce7;color:#22c55e;">Resolve</button></td>
                    </tr>
                    <tr>
                        <td>ALT-1002</td>
                        <td>Coverage</td>
                        <td><span class="status status-fatigued" style="background:#fef9c3;color:#eab308;">Medium</span></td>
                        <td>South Zone has insufficient worker coverage</td>
                        <td>N/A</td>
                        <td><i class="fa-regular fa-clock"></i> 2025-04-30 08:22 AM</td>
                        <td><span class="status status-leave" style="background:#fee2e2;color:#ef4444;">● Active</span></td>
                        <td><button class="btn" style="background:#dcfce7;color:#22c55e;">Resolve</button></td>
                    </tr>
                    <tr>
                        <td>ALT-1003</td>
                        <td>Fatigue</td>
                        <td><span class="status status-leave" style="background:#fee2e2;color:#ef4444;">Critical</span></td>
                        <td>Worker David Lee exceeding recommended delivery count</td>
                        <td>David Lee (WRK-1005)</td>
                        <td><i class="fa-regular fa-clock"></i> 2025-04-30 10:05 AM</td>
                        <td><span class="status status-leave" style="background:#fee2e2;color:#ef4444;">● Active</span></td>
                        <td><button class="btn" style="background:#dcfce7;color:#22c55e;">Resolve</button></td>
                    </tr>
                    <tr>
                        <td>ALT-1004</td>
                        <td>Delivery</td>
                        <td><span class="status status-available" style="background:#e0e7ff;color:#4f46e5;">Low</span></td>
                        <td>Delivery DEL-1002 delayed by more than 15 minutes</td>
                        <td>Sarah Johnson (WRK-1002)</td>
                        <td><i class="fa-regular fa-clock"></i> 2025-04-30 07:45 AM</td>
                        <td><span class="status status-available" style="background:#dcfce7;color:#22c55e;">● Resolved</span></td>
                        <td><button class="btn" style="background:#f3f4f6;color:#1e293b;">Details</button></td>
                    </tr>
                    <tr>
                        <td>ALT-1005</td>
                        <td>System</td>
                        <td><span class="status status-fatigued" style="background:#fef9c3;color:#eab308;">Medium</span></td>
                        <td>GPS tracking temporarily unavailable for North Zone</td>
                        <td>N/A</td>
                        <td><i class="fa-regular fa-clock"></i> 2025-04-30 06:30 AM</td>
                        <td><span class="status status-available" style="background:#dcfce7;color:#22c55e;">● Resolved</span></td>
                        <td><button class="btn" style="background:#f3f4f6;color:#1e293b;">Details</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</main>
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
</script>
</body>
</html> 