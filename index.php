<?php require 'session.php'; ?>
<?php
$activePage = 'dashboard';
$pageTitle = 'Dashboard';
$pageSubtitle = 'Monitor delivery operations and worker wellbeing';
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DelivrEase – Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background: #f6f8fa; }
        .dashboard-card {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            background: var(--bg-primary);
            border-radius: 1.5rem;
            box-shadow: 0 2px 12px 0 rgba(16,30,54,0.06);
            padding: 1.5rem 2rem;
            min-width: 220px;
        }
        .dashboard-card .card-icon {
            background: #f1f5f9;
            border-radius: 1rem;
            padding: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        .dashboard-card .card-title {
            font-size: 1rem;
            color: var(--text-secondary);
            font-weight: 500;
        }
        .dashboard-card .card-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
        }
        .dashboard-card .card-trend {
            font-size: 0.95rem;
            margin-top: 0.25rem;
        }
        .main {
            margin-left: 260px;
            background: var(--bg-secondary);
            min-height: 100vh;
            padding: 0 0 2rem 0;
        }
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 2rem;
            margin: 2rem 2.5rem 0 2.5rem;
        }
        .dashboard-charts {
            display: grid;
            grid-template-columns: 2fr 1.2fr;
            gap: 2rem;
            margin: 2rem 2.5rem 0 2.5rem;
        }
        @media (max-width: 1100px) {
            .dashboard-charts { grid-template-columns: 1fr; }
        }
        .dashboard-section {
            margin: 2rem 2.5rem 0 2.5rem;
        }
        .dashboard-section .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        .theme-toggle {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            background: var(--bg-primary);
            border-radius: 50%;
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: all var(--transition-speed);
            z-index: 200;
        }
        .theme-toggle:hover { transform: scale(1.1); }
        .nav-section {
            display: flex;
            flex-direction: column;
            padding: 20px;
        }
        .nav-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: var(--text);
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 8px;
            transition: all 0.3s ease;
        }
        .nav-item:hover {
            background: rgba(90,201,148,0.1);
            color: var(--primary);
        }
        .nav-item.active {
            background: var(--primary);
            color: white;
        }
        .nav-item i {
            margin-right: 12px;
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }
        .landing-link {
            margin-top: auto;
            background: rgba(90,201,148,0.1);
            color: var(--primary);
            border: 1px solid var(--primary);
        }
        .landing-link:hover {
            background: var(--primary);
            color: white;
        }
    </style>
</head>
<body>
    <?php include 'components/sidebar.php'; ?>
    <main class="main">
        <?php include 'components/header.php'; ?>
        <div class="dashboard-cards">
            <div class="dashboard-card">
                <div class="card-icon" style="background:#e0e7ff; color:#4f46e5;"><i class="fa-solid fa-box"></i></div>
                <div>
                    <div class="card-title">Active Deliveries</div>
                    <div class="card-value">48</div>
                    <div class="card-trend" style="color:#22c55e;"><i class="fa-solid fa-arrow-up"></i> 12% from last week</div>
                </div>
            </div>
            <div class="dashboard-card">
                <div class="card-icon" style="background:#d1fae5; color:#22c55e;"><i class="fa-solid fa-user"></i></div>
                <div>
                    <div class="card-title">Available Drivers</div>
                    <div class="card-value">30</div>
                    <div class="card-trend" style="color:#22c55e;"><i class="fa-solid fa-arrow-up"></i> 5% from last week</div>
                </div>
            </div>
            <div class="dashboard-card" style="background:#fff7ed;">
                <div class="card-icon" style="background:#fef3c7; color:#f59e0b;"><i class="fa-solid fa-triangle-exclamation"></i></div>
                <div>
                    <div class="card-title">High Fatigue Alerts</div>
                    <div class="card-value">4</div>
                    <div class="card-trend" style="color:#ef4444;"><i class="fa-solid fa-arrow-down"></i> 2% from last week</div>
                </div>
            </div>
            <div class="dashboard-card">
                <div class="card-icon" style="background:#e0e7ff; color:#4f46e5;"><i class="fa-solid fa-truck-fast"></i></div>
                <div>
                    <div class="card-title">Avg. Deliveries/Worker</div>
                    <div class="card-value">18</div>
                    <div class="card-trend" style="color:#22c55e;"><i class="fa-solid fa-arrow-up"></i> 3% from last week</div>
                </div>
            </div>
        </div>
        <div class="dashboard-charts">
            <div class="card">
                <div class="section-title">Average Worker Fatigue Levels</div>
                <canvas id="fatigueAreaChart" height="120"></canvas>
            </div>
            <div class="card">
                <div class="section-title">Worker Workload Distribution</div>
                <canvas id="workloadPieChart" height="180"></canvas>
                <div style="margin-top:1.5rem;">
                    <span style="color:#22c55e;">Optimal Load: 60%</span><br>
                    <span style="color:#f59e0b;">Near Capacity: 27%</span><br>
                    <span style="color:#ef4444;">Overloaded: 13%</span>
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
    // Theme toggle
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
    // Loading animation (for demo, show on page load for 1s)
    window.addEventListener('DOMContentLoaded', () => {
        const loading = document.querySelector('.loading');
        loading.style.display = 'flex';
        setTimeout(() => { loading.style.display = 'none'; }, 800);
    });
    // Chart.js Area Chart
    const fatigueAreaChart = document.getElementById('fatigueAreaChart').getContext('2d');
    new Chart(fatigueAreaChart, {
        type: 'line',
        data: {
            labels: ['8AM','9AM','10AM','11AM','12PM','1PM','2PM','3PM','4PM','5PM','6PM'],
            datasets: [{
                label: 'Fatigue',
                data: [10, 15, 22, 30, 38, 45, 52, 60, 70, 80, 90],
                fill: true,
                backgroundColor: 'rgba(245, 158, 11, 0.15)',
                borderColor: 'rgba(245, 158, 11, 1)',
                tension: 0.4,
                pointRadius: 0
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, max: 100, ticks: { stepSize: 25 } },
                x: { grid: { display: false } }
            }
        }
    });
    // Chart.js Pie Chart
    const workloadPieChart = document.getElementById('workloadPieChart').getContext('2d');
    new Chart(workloadPieChart, {
        type: 'pie',
        data: {
            labels: ['Optimal Load', 'Near Capacity', 'Overloaded'],
            datasets: [{
                data: [60, 27, 13],
                backgroundColor: [
                    'rgba(34, 197, 94, 0.8)',
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(239, 68, 68, 0.8)'
                ]
            }]
        },
        options: {
            plugins: { legend: { position: 'bottom' } }
        }
    });
    fetch('api/workers.php')
      .then(res => res.json())
      .then(data => {
        // Example: render workers in a table
        let html = '';
        data.forEach(worker => {
          html += `<tr>
            <td>${worker.name}</td>
            <td>${worker.status}</td>
            <td>${worker.fatigue_score}%</td>
          </tr>`;
        });
        document.getElementById('workers-table-body').innerHTML = html;
      });
    </script>
</body>
</html>
