<?php
$activePage = 'reports';
$pageTitle = 'Reports';
$pageSubtitle = 'Generate and view analytical reports';
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - DelivrEase</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
<?php include 'components/sidebar.php'; ?>
<main class="main">
    <?php include 'components/header.php'; ?>
    <div style="margin:2rem 2.5rem 0 2.5rem;">
        <div class="card">
            <div style="display:flex;justify-content:space-between;align-items:center;">
                <div class="section-title" style="display:flex;align-items:center;gap:0.5rem;"><i class="fa-solid fa-chart-bar"></i> Available Reports</div>
                <div style="display:flex;gap:1rem;">
                    <button class="btn" style="background:#f3f4f6;color:#1e293b;"><i class="fa-regular fa-calendar"></i> Schedule Report</button>
                    <button class="btn btn-primary" style="font-size:1rem;padding:0.6rem 1.2rem;"><i class="fa-regular fa-file-lines"></i> Create Report</button>
                </div>
            </div>
            <div style="margin:1.5rem 0 1.5rem 0;display:flex;gap:1rem;">
                <button class="btn" style="background:#e5e7eb;color:#1e293b;">All Reports</button>
                <button class="btn" style="background:#f3f4f6;color:#1e293b;">Performance</button>
                <button class="btn" style="background:#f3f4f6;color:#1e293b;">Worker Wellbeing</button>
                <button class="btn" style="background:#f3f4f6;color:#1e293b;">Operational</button>
                <button class="btn" style="margin-left:auto;background:#f3f4f6;color:#1e293b;"><i class="fa-solid fa-filter"></i> Filter</button>
            </div>
            <div style="display:grid;gap:1rem;">
                <div style="background:#fff;border-radius:1rem;padding:1.25rem 1.5rem;box-shadow:0 1px 4px 0 rgba(16,30,54,0.04);display:flex;justify-content:space-between;align-items:center;">
                    <div>
                        <b>Monthly Delivery Performance</b><br>
                        <span style="color:var(--text-secondary);font-size:0.98em;">Overview of delivery times, success rates, and worker performance<br>Last generated: April 25, 2025</span>
                    </div>
                    <button class="btn" style="background:#f3f4f6;color:#1e293b;"><i class="fa-solid fa-download"></i> Download</button>
                </div>
                <div style="background:#fff;border-radius:1rem;padding:1.25rem 1.5rem;box-shadow:0 1px 4px 0 rgba(16,30,54,0.04);display:flex;justify-content:space-between;align-items:center;">
                    <div>
                        <b>Worker Fatigue Analysis</b><br>
                        <span style="color:var(--text-secondary);font-size:0.98em;">Detailed breakdown of worker fatigue trends and potential risks<br>Last generated: April 28, 2025</span>
                    </div>
                    <button class="btn" style="background:#f3f4f6;color:#1e293b;"><i class="fa-solid fa-download"></i> Download</button>
                </div>
                <div style="background:#fff;border-radius:1rem;padding:1.25rem 1.5rem;box-shadow:0 1px 4px 0 rgba(16,30,54,0.04);display:flex;justify-content:space-between;align-items:center;">
                    <div>
                        <b>Zone Efficiency Report</b><br>
                        <span style="color:var(--text-secondary);font-size:0.98em;">Analysis of delivery efficiency across different geographical zones<br>Last generated: April 26, 2025</span>
                    </div>
                    <button class="btn" style="background:#f3f4f6;color:#1e293b;"><i class="fa-solid fa-download"></i> Download</button>
                </div>
                <div style="background:#fff;border-radius:1rem;padding:1.25rem 1.5rem;box-shadow:0 1px 4px 0 rgba(16,30,54,0.04);display:flex;justify-content:space-between;align-items:center;">
                    <div>
                        <b>Leave Management Summary</b><br>
                        <span style="color:var(--text-secondary);font-size:0.98em;">Overview of approved and pending leave requests<br>Last generated: April 29, 2025</span>
                    </div>
                    <button class="btn" style="background:#f3f4f6;color:#1e293b;"><i class="fa-solid fa-download"></i> Download</button>
                </div>
                <div style="background:#fff;border-radius:1rem;padding:1.25rem 1.5rem;box-shadow:0 1px 4px 0 rgba(16,30,54,0.04);display:flex;justify-content:space-between;align-items:center;">
                    <div>
                        <b>Delivery Exception Analysis</b><br>
                        <span style="color:var(--text-secondary);font-size:0.98em;">Details on failed or delayed deliveries with cause analysis<br>Last generated: April 27, 2025</span>
                    </div>
                    <button class="btn" style="background:#f3f4f6;color:#1e293b;"><i class="fa-solid fa-download"></i> Download</button>
                </div>
            </div>
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