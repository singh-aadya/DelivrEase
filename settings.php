<?php
$activePage = 'settings';
$pageTitle = 'Settings';
$pageSubtitle = 'Configure system preferences and parameters';
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - DelivrEase</title>
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
            <div style="display:flex;gap:1rem;margin-bottom:2rem;">
                <button class="btn" style="background:#e5e7eb;color:#1e293b;min-width:160px;">General</button>
                <button class="btn" style="background:#f3f4f6;color:#1e293b;min-width:160px;">Notifications</button>
                <button class="btn" style="background:#f3f4f6;color:#1e293b;min-width:160px;">Fatigue Tracking</button>
                <button class="btn" style="background:#f3f4f6;color:#1e293b;min-width:160px;">Zones & Routing</button>
            </div>
            <div class="section-title" style="display:flex;align-items:center;gap:0.5rem;"><i class="fa-solid fa-gear"></i> General Settings</div>
            <div style="color:var(--text-secondary);margin-bottom:2rem;">Configure basic system settings and preferences</div>
            <form>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:2rem;">
                    <div>
                        <label class="form-label">Company Name</label>
                        <input class="form-input" type="text" value="DelivrEase Logistics">
                    </div>
                    <div>
                        <label class="form-label">Contact Email</label>
                        <input class="form-input" type="email" value="support@delivrease.com">
                    </div>
                    <div>
                        <label class="form-label">Phone Number</label>
                        <input class="form-input" type="text" value="+1 (555) 123-4567">
                    </div>
                    <div>
                        <label class="form-label">Timezone</label>
                        <input class="form-input" type="text" value="UTC-5 (Eastern Time)">
                    </div>
                </div>
                <div style="margin-top:2.5rem;">
                    <div class="section-title" style="font-size:1.1rem;">System Preferences</div>
                    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:2rem;align-items:center;">
                        <div>
                            <b>Dark Mode</b><br>
                            <span style="color:var(--text-secondary);font-size:0.98em;">Enable dark mode for the interface</span>
                        </div>
                        <div>
                            <b>Auto Refresh</b><br>
                            <span style="color:var(--text-secondary);font-size:0.98em;">Automatically refresh dashboard data</span>
                        </div>
                        <div>
                            <b>Analytics Collection</b><br>
                            <span style="color:var(--text-secondary);font-size:0.98em;">Allow usage data collection to improve the system</span>
                        </div>
                        <div><label class="switch"><input type="checkbox"><span class="slider"></span></label></div>
                        <div><label class="switch"><input type="checkbox" checked><span class="slider"></span></label></div>
                        <div><label class="switch"><input type="checkbox" checked><span class="slider"></span></label></div>
                    </div>
                </div>
                <div style="margin-top:2.5rem;text-align:right;">
                    <button class="btn btn-primary" style="font-size:1rem;padding:0.7rem 2rem;"><i class="fa-solid fa-floppy-disk"></i> Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</main>
<div class="theme-toggle" title="Toggle dark mode">
    <i class="fa-solid fa-moon"></i>
</div>
<div class="loading" style="display:none;">
    <div class="loading-spinner"></div>
</div>
<style>
.switch { position: relative; display: inline-block; width: 44px; height: 24px; }
.switch input { opacity: 0; width: 0; height: 0; }
.slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #e5e7eb; transition: .4s; border-radius: 24px; }
.slider:before { position: absolute; content: ""; height: 18px; width: 18px; left: 3px; bottom: 3px; background-color: #fff; transition: .4s; border-radius: 50%; box-shadow: 0 1px 4px 0 rgba(16,30,54,0.10); }
input:checked + .slider { background-color: #4F46E5; }
input:checked + .slider:before { transform: translateX(20px); }
</style>
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