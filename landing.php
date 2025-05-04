<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DelivrEase – Fair, Human-Centric Delivery Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #5AC994;
            --navy: #1F2D3D;
            --bg: #F8F9FA;
            --text: #374151;
            --accent: #4F46E5;
            --card: #fff;
            --shadow: 0 8px 32px rgba(31,45,61,0.10);
            --radius: 1.5rem;
        }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            margin: 0;
            min-height: 100vh;
        }
        .hero {
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 90vh;
            padding: 4rem 2rem 2rem 2rem;
            background: linear-gradient(120deg, #1F2D3D 40%, #5AC994 100%);
            border-radius: 0 0 var(--radius) var(--radius);
            position: relative;
            z-index: 1;
        }
        .site-name {
            position: absolute;
            top: 2.5rem;
            left: 2.5rem;
            font-size: 2.1rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -1px;
            z-index: 2;
            text-shadow: 0 2px 12px rgba(31,45,61,0.13);
        }
        .site-name .accent {
            color: var(--primary);
        }
        .site-name .green {
            color: #5AC994 !important;
        }
        .hero-content {
            max-width: 600px;
            color: #fff;
        }
        .hero-title {
            font-size: 2.7rem;
            font-weight: 800;
            color: #fff;
            text-shadow: 0 4px 24px rgba(31,45,61,0.18);
            margin-bottom: 1.2rem;
            letter-spacing: -1px;
            animation: fadeInUp 1.2s 0.2s both;
        }
        .hero-sub {
            font-size: 1.18rem;
            color: #5AC994;
            font-weight: 500;
            margin-bottom: 2.2rem;
            animation: fadeInUp 1.2s 0.5s both;
        }
        .cta-row {
            display: flex;
            gap: 1.2rem;
            margin-bottom: 2.2rem;
        }
        .cta-btn {
            font-size: 1.05rem;
            font-weight: 600;
            padding: 0.85rem 2.2rem;
            border-radius: 1.2rem;
            border: none;
            cursor: pointer;
            box-shadow: 0 2px 12px 0 rgba(31,45,61,0.10);
            transition: background 0.2s, color 0.2s, box-shadow 0.2s, transform 0.2s;
        }
        .cta-btn.primary {
            background: linear-gradient(90deg, #5AC994 0%, #4F46E5 100%);
            color: #fff;
        }
        .cta-btn.primary:hover {
            background: linear-gradient(90deg, #4F46E5 0%, #5AC994 100%);
            transform: scale(1.04);
        }
        .cta-btn.ghost {
            background: transparent;
            color: #fff;
            border: 2px solid #5AC994;
        }
        .cta-btn.ghost:hover {
            color: #5AC994;
            background: rgba(90,201,148,0.07);
            border-color: #fff;
        }
        .hero-visual img, .hero-visual .img-placeholder {
            max-width: 370px;
            border-radius: 2rem;
            box-shadow: 0 8px 32px rgba(31,45,61,0.10);
            margin-left: 2rem;
            display: block;
        }
        .hero-visual .img-placeholder {
            border: 2px dashed #5AC994;
            color: #4F46E5;
            text-align: center;
            font-size: 1.1rem;
            min-height: 250px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .hero-visual {
            flex: 1;
            min-width: 320px;
            text-align: right;
            z-index: 1;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }
        .features-section {
            background: var(--bg);
            padding: 6rem 2rem;
            position: relative;
        }
        .features-title {
            font-size: 2.5rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 3.5rem;
            color: var(--navy);
            position: relative;
        }
        .features-title::after {
            content: '';
            position: absolute;
            bottom: -0.5rem;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: var(--primary);
            border-radius: 2px;
        }
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2.5rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        .feature-card {
            background: var(--card);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 2.5rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(90,201,148,0.1);
        }
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(31,45,61,0.15);
        }
        .feature-card:hover::before {
            opacity: 1;
        }
        .feature-icon {
            width: 48px;
            height: 48px;
            margin-bottom: 1.5rem;
            color: var(--primary);
            opacity: 0.9;
        }
        .feature-icon svg {
            width: 100%;
            height: 100%;
        }
        .feature-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--navy);
        }
        .feature-desc {
            color: var(--text);
            font-size: 1.05rem;
            line-height: 1.6;
            opacity: 0.9;
        }
        .story-section {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 4rem 2rem;
        }
        .glass-card {
            background: rgba(255,255,255,0.35);
            box-shadow: var(--shadow);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border-radius: 2rem;
            padding: 2.5rem 2.5rem 2rem 2.5rem;
            max-width: 480px;
            width: 100%;
            border: 1.5px solid rgba(90,201,148,0.13);
            margin: 0 2vw;
        }
        .glass-block {
            margin-top: 1.2rem;
            background: rgba(255,255,255,0.45);
            border-radius: 1.2rem;
            padding: 1.2rem 1.5rem;
            box-shadow: 0 2px 12px 0 rgba(31,45,61,0.07);
            font-size: 1.13rem;
            color: var(--navy);
            font-weight: 500;
            text-align: center;
        }
        .glass-quote {
            font-size: 1.1rem;
            color: var(--text);
            margin-top: 2.2rem;
            font-style: italic;
            opacity: 0.85;
        }
        .footer {
            background: var(--navy);
            color: #fff;
            text-align: center;
            padding: 2rem 1rem 1rem 1rem;
            border-radius: var(--radius) var(--radius) 0 0;
            margin-top: 4rem;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(40px);}
            to { opacity: 1; transform: none;}
        }
        @media (max-width: 900px) {
            .hero { flex-direction: column; text-align: center; }
            .site-name { position: static; margin-bottom: 2rem; }
            .hero-visual { margin-top: 2rem; align-items: center; }
            .hero-visual img, .hero-visual .img-placeholder { margin-left: 0; }
            .features-grid { flex-direction: column; display: flex; }
            .story-section { flex-direction: column; }
        }
    </style>
</head>
<body>
    <div class="hero">
        <div class="site-name">Delivr<span class="green">Ease</span></div>
        <div class="hero-content">
            <div class="hero-title">Empowering Fairness. Delivering Wellbeing.</div>
            <div class="hero-sub">
                Where every route respects the human behind the delivery—operational excellence, powered by empathy.
            </div>
            <div class="cta-row">
                <a href="index.php"><button class="cta-btn primary">Try the Demo</button></a>
                <a href="#features"><button class="cta-btn ghost">See Features</button></a>
            </div>
        </div>
        <div class="hero-visual">
            <img src="assets/wmremove-transformed-Photoroom.png" alt="Delivery worker illustration" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
            <div class="img-placeholder" style="display:none;">Image not found.<br>Place <b>assets/wmremove-transformed-Photoroom.png</b> here.</div>
        </div>
    </div>
    <section class="features-section" id="features">
        <div class="features-title">Key Features</div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="feature-title">Automated Delivery Assignment</div>
                <div class="feature-desc">Intelligent order distribution based on real-time availability, workload, and zone familiarity—minimizing manual intervention and optimizing delivery efficiency.</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 8V12L15 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="feature-title">Fatigue Tracking System</div>
                <div class="feature-desc">Advanced monitoring of worker fatigue through distance, time, and delivery metrics—ensuring sustainable workload management and worker wellbeing.</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19 4H5C3.89543 4 3 4.89543 3 6V20C3 21.1046 3.89543 22 5 22H19C20.1046 22 21 21.1046 21 20V6C21 4.89543 20.1046 4 19 4Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M16 2V6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M8 2V6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M3 10H21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="feature-title">Integrated Leave Management</div>
                <div class="feature-desc">Streamlined leave request processing with automated conflict detection—maintaining operational continuity while respecting worker needs.</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M19.4 15C19.2669 15.3016 19.2272 15.6362 19.286 15.9606C19.3448 16.285 19.4995 16.5843 19.73 16.82L19.79 16.88C19.976 17.0657 20.1235 17.2863 20.2241 17.5291C20.3247 17.7719 20.3766 18.0322 20.3766 18.295C20.3766 18.5578 20.3247 18.8181 20.2241 19.0609C20.1235 19.3037 19.976 19.5243 19.79 19.71C19.6043 19.896 19.3837 20.0435 19.1409 20.1441C18.8981 20.2447 18.6378 20.2966 18.375 20.2966C18.1122 20.2966 17.8519 20.2447 17.6091 20.1441C17.3663 20.0435 17.1457 19.896 16.96 19.71L16.9 19.65C16.6643 19.4195 16.365 19.2648 16.0406 19.206C15.7162 19.1472 15.3816 19.1869 15.08 19.32C14.7842 19.4468 14.532 19.6572 14.3543 19.9255C14.1766 20.1938 14.0813 20.5082 14.08 20.83V21C14.08 21.5304 13.8693 22.0391 13.4942 22.4142C13.1191 22.7893 12.6104 23 12.08 23C11.5496 23 11.0409 22.7893 10.6658 22.4142C10.2907 22.0391 10.08 21.5304 10.08 21V20.91C10.0723 20.579 9.96512 20.2573 9.77299 19.9885C9.58086 19.7197 9.31295 19.5166 9.004 19.41C8.70941 19.2769 8.38189 19.2372 8.06448 19.296C7.74707 19.3548 7.45467 19.5095 7.225 19.74L7.165 19.8C6.97925 19.9857 6.75868 20.1332 6.51588 20.2338C6.27308 20.3344 6.01283 20.3863 5.75 20.3863C5.48717 20.3863 5.22692 20.3344 4.98412 20.2338C4.74132 20.1332 4.52075 19.9857 4.335 19.8C4.14925 19.6143 4.00175 19.3937 3.90117 19.1509C3.80059 18.9081 3.74866 18.6478 3.74866 18.385C3.74866 18.1222 3.80059 17.8619 3.90117 17.6191C4.00175 17.3763 4.14925 17.1557 4.335 16.97L4.395 16.91C4.62554 16.6795 4.78021 16.3802 4.839 16.0558C4.89779 15.7314 4.85812 15.3968 4.725 15.095C4.59187 14.7932 4.37154 14.5409 4.09254 14.3712C3.81354 14.2015 3.48891 14.1228 3.165 14.145H3C2.46957 14.145 1.96086 13.9343 1.58579 13.5592C1.21071 13.1841 1 12.6754 1 12.145C1 11.6146 1.21071 11.1059 1.58579 10.7308C1.96086 10.3557 2.46957 10.145 3 10.145H3.09C3.42099 10.1373 3.74268 10.0301 4.01154 9.83799C4.2804 9.64586 4.48345 9.37795 4.59 9.069C4.72312 8.77441 4.87879 8.48201 5.11 8.252L5.17 8.192C5.35575 8.00625 5.50325 7.78568 5.60383 7.54288C5.70441 7.30008 5.75634 7.03983 5.75634 6.777C5.75634 6.51417 5.70441 6.25392 5.60383 6.01112C5.50325 5.76832 5.35575 5.54775 5.17 5.362C4.98425 5.17625 4.76368 5.02875 4.52088 4.92817C4.27808 4.82759 4.01783 4.77566 3.755 4.77566C3.49217 4.77566 3.23192 4.82759 2.98912 4.92817C2.74632 5.02875 2.52575 5.17625 2.34 5.362L2.28 5.422C2.04946 5.65254 1.75021 5.80721 1.42579 5.866C1.10137 5.92479 0.76675 5.88512 0.465 5.752C0.16325 5.61887 -0.0890543 5.39854 -0.258754 5.11954C-0.428454 4.84054 -0.507204 4.51591 -0.485 4.192V4.145C-0.485 3.61457 -0.274286 3.10586 0.100786 2.73079C0.475858 2.35571 0.984573 2.145 1.515 2.145H4.515" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="feature-title">Equitable Workload Distribution</div>
                <div class="feature-desc">Data-driven workload balancing across active personnel—promoting fair opportunity and sustainable performance metrics.</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 21H4C3.46957 21 2.96086 20.7893 2.58579 20.4142C2.21071 20.0391 2 19.5304 2 19V3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M7 10L12 15L22 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="feature-title">Delivery and Performance Logging</div>
                <div class="feature-desc">Comprehensive delivery history with detailed metrics—enabling data-driven insights and transparent performance evaluation.</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 8V16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M8 12H16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="feature-title">Zone-Based Routing and Allocation</div>
                <div class="feature-desc">Optimized delivery assignments based on worker zone expertise—enhancing route efficiency and service quality.</div>
            </div>
        </div>
    </section>
    <footer class="footer">
        &copy; <?php echo date('Y'); ?> DelivrEase. All rights reserved.
    </footer>
</body>
</html> 