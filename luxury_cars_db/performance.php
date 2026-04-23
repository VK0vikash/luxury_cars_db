<?php
require_once 'includes/db.php';


// performance.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Performance | LUXURY AUTO</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Montserrat', 'Segoe UI', sans-serif;
        }

        body {
            background-color: #0a0a0a;
            color: #fff;
            overflow-x: hidden;
        }

        /* Navigation */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 25px 60px;
            background: linear-gradient(180deg, rgba(10,10,10,0.98) 0%, rgba(10,10,10,0.92) 100%);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(212, 175, 55, 0.15);
            transition: all 0.4s;
        }

        .logo {
            font-size: 32px;
            font-weight: 800;
            color: #d4af37;
            letter-spacing: 3px;
            text-transform: uppercase;
            position: relative;
        }

        .logo span {
            color: #fff;
        }

        .logo::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, #d4af37, transparent);
        }

        .nav-links {
            display: flex;
            gap: 40px;
        }

        .nav-links a {
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
            padding: 8px 0;
            position: relative;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: #d4af37;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: #d4af37;
            transition: width 0.3s;
        }

        .nav-links a:hover::after,
        .nav-links a.active::after {
            width: 100%;
        }

        .nav-links a.active {
            color: #d4af37;
        }

        /* Hero Section */
        .hero {
            height: 100vh;
            background: linear-gradient(rgba(0,0,0,0.85), rgba(0,0,0,0.92)),
                        url('https://images.unsplash.com/photo-1549399542-7e3f8b79c341?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            align-items: center;
            padding: 0 60px;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 30% 50%, rgba(212, 175, 55, 0.1), transparent 50%);
        }

        .hero-content {
            max-width: 800px;
            position: relative;
            z-index: 2;
        }

        .hero-subtitle {
            font-size: 18px;
            color: #d4af37;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .hero-title {
            font-size: 84px;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 30px;
            background: linear-gradient(90deg, #fff 0%, #d4af37 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        .hero-description {
            font-size: 20px;
            color: #ccc;
            line-height: 1.6;
            max-width: 600px;
            margin-bottom: 40px;
        }

        .hero-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            margin-top: 60px;
        }

        .hero-stat {
            text-align: center;
            padding: 30px 20px;
            background: rgba(255,255,255,0.05);
            border-radius: 15px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(212, 175, 55, 0.1);
            transition: transform 0.3s, background 0.3s;
        }

        .hero-stat:hover {
            transform: translateY(-10px);
            background: rgba(212, 175, 55, 0.1);
            border-color: rgba(212, 175, 55, 0.3);
        }

        .stat-number {
            font-size: 48px;
            font-weight: 800;
            color: #d4af37;
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 14px;
            color: #aaa;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        /* Technologies Section */
        .tech-section {
            padding: 150px 60px;
            background: #0a0a0a;
        }

        .section-header {
            text-align: center;
            margin-bottom: 100px;
        }

        .section-subtitle {
            font-size: 18px;
            color: #d4af37;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 56px;
            font-weight: 800;
            color: #fff;
            line-height: 1.2;
        }

        .tech-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 50px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .tech-card {
            background: linear-gradient(145deg, #1a1a1a, #0f0f0f);
            border-radius: 20px;
            padding: 50px 40px;
            position: relative;
            overflow: hidden;
            transition: all 0.4s;
            border: 1px solid rgba(255,255,255,0.05);
        }

        .tech-card:hover {
            transform: translateY(-20px);
            box-shadow: 0 30px 60px rgba(0,0,0,0.5);
            border-color: rgba(212, 175, 55, 0.3);
        }

        .tech-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #d4af37, #b8941f);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.5s;
        }

        .tech-card:hover::before {
            transform: scaleX(1);
        }

        .tech-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.1), rgba(212, 175, 55, 0.05));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
            font-size: 36px;
            color: #d4af37;
        }

        .tech-title {
            font-size: 28px;
            color: #fff;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .tech-description {
            color: #aaa;
            line-height: 1.6;
            font-size: 16px;
            margin-bottom: 30px;
        }

        .tech-specs {
            display: flex;
            gap: 20px;
            margin-top: 30px;
        }

        .tech-spec {
            flex: 1;
            text-align: center;
            padding: 15px;
            background: rgba(255,255,255,0.03);
            border-radius: 10px;
        }

        .spec-value {
            font-size: 24px;
            color: #d4af37;
            font-weight: 700;
        }

        .spec-label {
            font-size: 12px;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 5px;
        }

        /* Performance Section */
        .performance-section {
            padding: 150px 60px;
            background: linear-gradient(135deg, rgba(15,15,15,0.95), rgba(10,10,10,0.95)),
                        url('https://images.unsplash.com/photo-1553440569-bcc63803a83d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-attachment: fixed;
            position: relative;
        }

        .performance-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(212, 175, 55, 0.05), transparent);
        }

        .performance-content {
            position: relative;
            z-index: 2;
            max-width: 1200px;
            margin: 0 auto;
        }

        .performance-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 40px;
            margin-bottom: 100px;
        }

        .performance-stat {
            text-align: center;
            padding: 40px 20px;
            background: rgba(255,255,255,0.05);
            border-radius: 20px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(212, 175, 55, 0.1);
            transition: all 0.3s;
        }

        .performance-stat:hover {
            transform: scale(1.05);
            background: rgba(212, 175, 55, 0.1);
            border-color: rgba(212, 175, 55, 0.3);
        }

        .performance-number {
            font-size: 56px;
            font-weight: 800;
            color: #d4af37;
            margin-bottom: 15px;
        }

        .performance-label {
            font-size: 16px;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 600;
        }

        /* Timeline */
        .timeline {
            position: relative;
            max-width: 1000px;
            margin: 100px auto;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            width: 2px;
            height: 100%;
            background: linear-gradient(to bottom, transparent, #d4af37, transparent);
        }

        .timeline-item {
            margin-bottom: 100px;
            position: relative;
            width: 45%;
        }

        .timeline-item:nth-child(odd) {
            margin-left: 0;
            margin-right: auto;
        }

        .timeline-item:nth-child(even) {
            margin-left: auto;
            margin-right: 0;
        }

        .timeline-content {
            background: linear-gradient(145deg, #1a1a1a, #0f0f0f);
            padding: 40px;
            border-radius: 20px;
            border: 1px solid rgba(212, 175, 55, 0.1);
            position: relative;
        }

        .timeline-year {
            font-size: 24px;
            color: #d4af37;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .timeline-title {
            font-size: 22px;
            color: #fff;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .timeline-description {
            color: #aaa;
            line-height: 1.6;
        }

        /* Footer */
        .footer {
            background: linear-gradient(180deg, #0a0a0a 0%, #080808 100%);
            padding: 80px 60px 40px;
            border-top: 1px solid rgba(212, 175, 55, 0.1);
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 60px;
            max-width: 1400px;
            margin: 0 auto 60px;
        }

        .footer-column h3 {
            font-size: 20px;
            color: #d4af37;
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 10px;
        }

        .footer-column h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 2px;
            background: #d4af37;
        }

        .footer-column p,
        .footer-column a {
            color: #aaa;
            margin-bottom: 15px;
            display: block;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-column a:hover {
            color: #d4af37;
        }

        .social-icons {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        .social-icon {
            width: 40px;
            height: 40px;
            background: #1a1a1a;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            text-decoration: none;
            transition: all 0.3s;
        }

        .social-icon:hover {
            background: #d4af37;
            color: #000;
            transform: translateY(-3px);
        }

        .copyright {
            text-align: center;
            color: #666;
            padding-top: 40px;
            border-top: 1px solid #333;
            font-size: 14px;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .hero-stats,
            .performance-stats,
            .footer-content {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .tech-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 992px) {
            .hero-title {
                font-size: 64px;
            }
            
            .section-title {
                font-size: 48px;
            }
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 20px;
                flex-direction: column;
                gap: 20px;
            }
            
            .nav-links {
                gap: 20px;
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .hero {
                padding: 0 20px;
            }
            
            .hero-title {
                font-size: 48px;
            }
            
            .tech-section,
            .performance-section {
                padding: 80px 20px;
            }
            
            .tech-grid {
                grid-template-columns: 1fr;
            }
            
            .footer {
                padding: 60px 20px 30px;
            }
            
            .footer-content {
                grid-template-columns: 1fr;
                gap: 40px;
            }
            
            .timeline::before {
                left: 30px;
            }
            
            .timeline-item {
                width: calc(100% - 60px);
                margin-left: 60px !important;
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 36px;
            }
            
            .hero-stats,
            .performance-stats {
                grid-template-columns: 1fr;
            }
            
            .section-title {
                font-size: 36px;
            }
        }

        /* Animation Classes */
        .animate-on-scroll {
            opacity: 0;
            transform: translateY(50px);
            transition: opacity 0.6s, transform 0.6s;
        }

        .animate-on-scroll.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(212, 175, 55, 0.4); }
            70% { box-shadow: 0 0 0 20px rgba(212, 175, 55, 0); }
            100% { box-shadow: 0 0 0 0 rgba(212, 175, 55, 0); }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="logo">LUXURY <span>AUTO</span></div>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="models.php">Models</a>
            <a href="performance.php" class="active">Performance</a>
            <a href="brand.php">Brand</a>
            <a href="news.php">News</a>
            <a href="contact.php">Contact</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <div class="hero-subtitle">Engineering Excellence</div>
            <h1 class="hero-title">BEYOND<br>PERFORMANCE</h1>
            <p class="hero-description">Where cutting-edge technology meets unparalleled engineering. Experience the perfect harmony of power, precision, and innovation in every vehicle we craft.</p>
            
            <div class="hero-stats">
                <div class="hero-stat">
                    <div class="stat-number" data-count="750">0</div>
                    <div class="stat-label">PEAK POWER</div>
                </div>
                <div class="hero-stat">
                    <div class="stat-number" data-count="3">0</div>
                    <div class="stat-label">0-100 KM/H</div>
                </div>
                <div class="hero-stat">
                    <div class="stat-number" data-count="350">0</div>
                    <div class="stat-label">TOP SPEED</div>
                </div>
                <div class="hero-stat">
                    <div class="stat-number" data-count="48">0</div>
                    <div class="stat-label">HYBRID SYSTEM</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Technologies Section -->
    <section class="tech-section">
        <div class="section-header">
            <div class="section-subtitle">Innovative Technologies</div>
            <h2 class="section-title">ENGINEERING REINVENTED</h2>
        </div>

        <div class="tech-grid">
            <!-- Tech 1 -->
            <div class="tech-card animate-on-scroll">
                <div class="tech-icon">
                    <i class="fas fa-tachometer-alt"></i>
                </div>
                <h3 class="tech-title">Turbo Hybrid V8</h3>
                <p class="tech-description">Our most powerful engine combines twin-turbocharging with electric motor assist for instantaneous response and unprecedented efficiency.</p>
                <div class="tech-specs">
                    <div class="tech-spec">
                        <div class="spec-value">750 HP</div>
                        <div class="spec-label">Max Power</div>
                    </div>
                    <div class="tech-spec">
                        <div class="spec-value">900 Nm</div>
                        <div class="spec-label">Torque</div>
                    </div>
                </div>
            </div>

            <!-- Tech 2 -->
            <div class="tech-card animate-on-scroll">
                <div class="tech-icon">
                    <i class="fas fa-cogs"></i>
                </div>
                <h3 class="tech-title">Adaptive Suspension Pro</h3>
                <p class="tech-description">AI-controlled suspension system that reads the road 1000 times per second, adjusting each wheel independently for optimal comfort and handling.</p>
                <div class="tech-specs">
                    <div class="tech-spec">
                        <div class="spec-value">0.001s</div>
                        <div class="spec-label">Response Time</div>
                    </div>
                    <div class="tech-spec">
                        <div class="spec-value">4D</div>
                        <div class="spec-label">Control</div>
                    </div>
                </div>
            </div>

            <!-- Tech 3 -->
            <div class="tech-card animate-on-scroll">
                <div class="tech-icon">
                    <i class="fas fa-bolt"></i>
                </div>
                <h3 class="tech-title">E-Torque System</h3>
                <p class="tech-description">Regenerative braking and electric boost technology that recovers energy and delivers instant torque for maximum acceleration.</p>
                <div class="tech-specs">
                    <div class="tech-spec">
                        <div class="spec-value">48V</div>
                        <div class="spec-label">Hybrid System</div>
                    </div>
                    <div class="tech-spec">
                        <div class="spec-value">25%</div>
                        <div class="spec-label">Efficiency Gain</div>
                    </div>
                </div>
            </div>

            <!-- Tech 4 -->
            <div class="tech-card animate-on-scroll">
                <div class="tech-icon">
                    <i class="fas fa-car"></i>
                </div>
                <h3 class="tech-title">Aerodynamic Precision</h3>
                <p class="tech-description">Active aerodynamics with deployable spoilers and air vents that optimize downforce and reduce drag at every speed.</p>
                <div class="tech-specs">
                    <div class="tech-spec">
                        <div class="spec-value">Cd 0.22</div>
                        <div class="spec-label">Drag Coefficient</div>
                    </div>
                    <div class="tech-spec">
                        <div class="spec-value">250kg</div>
                        <div class="spec-label">Downforce</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Performance Section -->
    <section class="performance-section">
        <div class="performance-content">
            <div class="performance-stats">
                <div class="performance-stat">
                    <div class="performance-number" data-count="2.8">0</div>
                    <div class="performance-label">0-100 KM/H (s)</div>
                </div>
                <div class="performance-stat">
                    <div class="performance-number" data-count="350">0</div>
                    <div class="performance-label">TOP SPEED (KM/H)</div>
                </div>
                <div class="performance-stat">
                    <div class="performance-number" data-count="750">0</div>
                    <div class="performance-label">HORSEPOWER</div>
                </div>
                <div class="performance-stat">
                    <div class="performance-number" data-count="900">0</div>
                    <div class="performance-label">TORQUE (NM)</div>
                </div>
            </div>

            <!-- Performance Timeline -->
            <div class="timeline">
                <div class="timeline-item animate-on-scroll">
                    <div class="timeline-content">
                        <div class="timeline-year">2024</div>
                        <h4 class="timeline-title">Quantum Drive System</h4>
                        <p class="timeline-description">Introducing our revolutionary all-electric powertrain with 0-100km/h in 1.9 seconds and 1000km range.</p>
                    </div>
                </div>

                <div class="timeline-item animate-on-scroll">
                    <div class="timeline-content">
                        <div class="timeline-year">2023</div>
                        <h4 class="timeline-title">Neural Suspension</h4>
                        <p class="timeline-description">AI-powered suspension system that predicts road conditions and adjusts in real-time for perfect handling.</p>
                    </div>
                </div>

                <div class="timeline-item animate-on-scroll">
                    <div class="timeline-content">
                        <div class="timeline-year">2022</div>
                        <h4 class="timeline-title">Carbon Fiber Architecture</h4>
                        <p class="timeline-description">Full carbon fiber monocoque construction reducing weight by 40% while increasing structural rigidity by 60%.</p>
                    </div>
                </div>

                <div class="timeline-item animate-on-scroll">
                    <div class="timeline-content">
                        <div class="timeline-year">2021</div>
                        <h4 class="timeline-title">Hybrid V12 Engine</h4>
                        <p class="timeline-description">World's first hybrid V12 producing 850hp while reducing emissions by 30% compared to conventional engines.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-column">
                <h3>LUXURY AUTO</h3>
                <p>Redefining automotive performance through innovation, precision engineering, and cutting-edge technology.</p>
                <div class="social-icons">
                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="footer-column">
                <h3>Performance</h3>
                <a href="#">Engine Technology</a>
                <a href="#">Aerodynamics</a>
                <a href="#">Suspension Systems</a>
                <a href="#">Braking Technology</a>
                <a href="#">Hybrid Systems</a>
                <a href="#">Track Performance</a>
            </div>
            <div class="footer-column">
                <h3>Services</h3>
                <a href="#">Performance Testing</a>
                <a href="#">Track Days</a>
                <a href="#">Driver Training</a>
                <a href="#">Performance Upgrades</a>
                <a href="#">Technical Support</a>
                <a href="#">Warranty</a>
            </div>
            <div class="footer-column">
                <h3>Contact Info</h3>
                <p><i class="fas fa-map-marker-alt"></i> Performance Center, Monaco GP Circuit</p>
                <p><i class="fas fa-phone"></i> +1 (888) 555-PERFORM</p>
                <p><i class="fas fa-envelope"></i> performance@luxuryauto.com</p>
                <p><i class="fas fa-clock"></i> 24/7 Technical Support</p>
            </div>
        </div>
        <div class="copyright">
            © 2024 LUXURY AUTO PERFORMANCE DIVISION. All rights reserved. | Pushing the boundaries of automotive excellence
        </div>
    </footer>

    <script>
        // Animated Counter
        function animateCounter(element) {
            const target = parseInt(element.getAttribute('data-count'));
            const duration = 2000; // 2 seconds
            const increment = target / (duration / 16); // 60fps
            
            let current = 0;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    element.textContent = target;
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(current);
                }
            }, 16);
        }

        // Scroll Animation
        function animateOnScroll() {
            const elements = document.querySelectorAll('.animate-on-scroll');
            elements.forEach(element => {
                const elementTop = element.getAttribute('data-animate-delay') || 0;
                const elementPosition = element.getBoundingClientRect().top;
                const screenPosition = window.innerHeight / 1.2;

                if (elementPosition < screenPosition) {
                    setTimeout(() => {
                        element.classList.add('visible');
                    }, parseInt(elementTop));
                }
            });
        }

        // Stats Counter on Scroll
        function animateStatsOnScroll() {
            const stats = document.querySelectorAll('.stat-number, .performance-number');
            stats.forEach(stat => {
                const statPosition = stat.getBoundingClientRect().top;
                const screenPosition = window.innerHeight / 1.3;
                
                if (statPosition < screenPosition && !stat.classList.contains('animated')) {
                    stat.classList.add('animated');
                    animateCounter(stat);
                }
            });
        }

        // Navbar Scroll Effect
        function handleNavbarScroll() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 100) {
                navbar.style.background = 'rgba(10, 10, 10, 0.98)';
                navbar.style.padding = '15px 60px';
                navbar.style.backdropFilter = 'blur(20px)';
            } else {
                navbar.style.background = 'linear-gradient(180deg, rgba(10,10,10,0.98) 0%, rgba(10,10,10,0.92) 100%)';
                navbar.style.padding = '25px 60px';
                navbar.style.backdropFilter = 'blur(15px)';
            }
        }

        // Parallax Effect
        function handleParallax() {
            const scrolled = window.pageYOffset;
            const parallaxElements = document.querySelectorAll('.hero, .performance-section');
            
            parallaxElements.forEach(element => {
                const speed = element.classList.contains('hero') ? 0.5 : 0.3;
                element.style.backgroundPositionY = (scrolled * speed) + 'px';
            });
        }

        // Initialize everything
        document.addEventListener('DOMContentLoaded', function() {
            // Initial animations
            animateOnScroll();
            animateStatsOnScroll();
            
            // Event listeners
            window.addEventListener('scroll', function() {
                handleNavbarScroll();
                animateOnScroll();
                animateStatsOnScroll();
                handleParallax();
            });
            
            // Add animation delay attributes
            const animateElements = document.querySelectorAll('.animate-on-scroll');
            animateElements.forEach((element, index) => {
                element.setAttribute('data-animate-delay', index * 200);
            });
            
            // Initialize navbar
            handleNavbarScroll();
            
            // Add click effects to tech cards
            const techCards = document.querySelectorAll('.tech-card');
            techCards.forEach(card => {
                card.addEventListener('click', function() {
                    this.classList.toggle('pulse');
                    setTimeout(() => {
                        this.classList.remove('pulse');
                    }, 2000);
                });
            });
            
            // Performance section interactive
            const performanceStats = document.querySelectorAll('.performance-stat');
            performanceStats.forEach(stat => {
                stat.addEventListener('mouseenter', function() {
                    const number = this.querySelector('.performance-number');
                    if (number && !number.classList.contains('animated')) {
                        number.classList.add('animated');
                        animateCounter(number);
                    }
                });
            });
        });

        // Smooth scrolling for navigation
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                if(targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if(targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</body>
</html>