
?>

<?php
// index.php - Advanced Homepage
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LUXURY AUTO | Redefining Automotive Excellence</title>
    <style>
        :root {
            --gold: #d4af37;
            --dark: #0a0a0a;
            --light: #ffffff;
            --gray: #888888;
            --dark-card: #1a1a1a;
            --border: rgba(255, 255, 255, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', 'Segoe UI', sans-serif;
        }

        body {
            background-color: var(--dark);
            color: var(--light);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Navigation */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 25px 60px;
            background: rgba(10, 10, 10, 0.95);
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
            color: var(--gold);
            letter-spacing: 3px;
            text-transform: uppercase;
            position: relative;
        }

        .logo span {
            color: var(--light);
        }

        .logo::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, var(--gold), transparent);
        }

        .nav-links {
            display: flex;
            gap: 40px;
        }

        .nav-links a {
            color: var(--light);
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
            padding: 8px 0;
            position: relative;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: var(--gold);
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--gold);
            transition: width 0.3s;
        }

        .nav-links a:hover::after,
        .nav-links a.active::after {
            width: 100%;
        }

        .nav-links a.active {
            color: var(--gold);
        }

        /* Hero Section with Car Animation */
        .hero {
            height: 100vh;
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.8)),
                        url('https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            position: relative;
            display: flex;
            align-items: center;
            padding: 0 60px;
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
            position: relative;
            z-index: 2;
            max-width: 800px;
        }

        .hero-subtitle {
            font-size: 20px;
            color: var(--gold);
            letter-spacing: 4px;
            text-transform: uppercase;
            margin-bottom: 20px;
            opacity: 0;
            animation: fadeInUp 1s 0.3s forwards;
        }

        .hero-title {
            font-size: 96px;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 30px;
            background: linear-gradient(90deg, var(--light) 0%, var(--gold) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 10px 30px rgba(0,0,0,0.3);
            opacity: 0;
            animation: fadeInUp 1s 0.6s forwards;
        }

        .hero-description {
            font-size: 22px;
            color: var(--gray);
            margin-bottom: 50px;
            max-width: 600px;
            line-height: 1.6;
            opacity: 0;
            animation: fadeInUp 1s 0.9s forwards;
        }

        .hero-buttons {
            display: flex;
            gap: 20px;
            opacity: 0;
            animation: fadeInUp 1s 1.2s forwards;
        }

        .primary-btn, .secondary-btn {
            padding: 18px 45px;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .primary-btn {
            background: linear-gradient(135deg, var(--gold), #b8941f);
            color: var(--dark);
            border: none;
        }

        .primary-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(212, 175, 55, 0.3);
        }

        .secondary-btn {
            background: transparent;
            color: var(--light);
            border: 2px solid var(--gold);
        }

        .secondary-btn:hover {
            background: var(--gold);
            color: var(--dark);
            transform: translateY(-5px);
        }

        /* Animated Car */
        .animated-car {
            position: absolute;
            right: 10%;
            bottom: 20%;
            width: 600px;
            height: 300px;
            opacity: 0;
            animation: fadeInRight 1.5s 1.5s forwards, float 6s infinite 2.5s;
        }

        .car-image {
            width: 100%;
            height: 100%;
            background: url('https://images.unsplash.com/photo-1553440569-bcc63803a83d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80') center/contain no-repeat;
            filter: drop-shadow(0 20px 30px rgba(0,0,0,0.5));
        }

        /* Stats Section */
        .stats-section {
            padding: 100px 60px;
            background: var(--dark);
            position: relative;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .stat-card {
            text-align: center;
            padding: 40px 20px;
            background: var(--dark-card);
            border-radius: 20px;
            border: 1px solid var(--border);
            transition: all 0.3s;
            opacity: 0;
            transform: translateY(50px);
        }

        .stat-card.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .stat-card:hover {
            transform: translateY(-10px);
            border-color: var(--gold);
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }

        .stat-number {
            font-size: 60px;
            font-weight: 800;
            color: var(--gold);
            margin-bottom: 10px;
            line-height: 1;
        }

        .stat-label {
            font-size: 18px;
            color: var(--light);
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        /* Featured Models */
        .models-section {
            padding: 150px 60px;
            background: rgba(15, 15, 15, 0.9);
        }

        .section-header {
            text-align: center;
            margin-bottom: 80px;
            opacity: 0;
            transform: translateY(30px);
        }

        .section-header.visible {
            opacity: 1;
            transform: translateY(0);
            transition: all 0.8s;
        }

        .section-subtitle {
            font-size: 18px;
            color: var(--gold);
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 56px;
            font-weight: 800;
            color: var(--light);
            line-height: 1.2;
        }

        .models-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 40px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .model-card {
            background: var(--dark-card);
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid var(--border);
            transition: all 0.4s;
            opacity: 0;
            transform: translateY(50px);
        }

        .model-card.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .model-card:hover {
            transform: translateY(-20px);
            border-color: var(--gold);
            box-shadow: 0 30px 60px rgba(0,0,0,0.4);
        }

        .model-image {
            height: 250px;
            overflow: hidden;
        }

        .model-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }

        .model-card:hover .model-image img {
            transform: scale(1.1);
        }

        .model-content {
            padding: 30px;
        }

        .model-name {
            font-size: 28px;
            margin-bottom: 10px;
            color: var(--light);
        }

        .model-price {
            font-size: 24px;
            color: var(--gold);
            margin-bottom: 15px;
            font-weight: 700;
        }

        .model-specs {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border);
        }

        .spec {
            text-align: center;
        }

        .spec-value {
            font-size: 20px;
            color: var(--light);
            font-weight: 600;
        }

        .spec-label {
            font-size: 12px;
            color: var(--gray);
            text-transform: uppercase;
            margin-top: 5px;
        }


        /* Technology Section */
        .tech-section {
            padding: 150px 60px;
            background: linear-gradient(135deg, rgba(10,10,10,0.9), rgba(15,15,15,0.9)),
                        url('https://images.unsplash.com/photo-1549399542-7e3f8b79c341?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-attachment: fixed;
            position: relative;
        }

        .tech-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(212, 175, 55, 0.05), transparent);
        }

        .tech-content {
            position: relative;
            z-index: 2;
            max-width: 1200px;
            margin: 0 auto;
        }

        .tech-features {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 40px;
            margin-top: 60px;
        }

        .tech-feature {
            text-align: center;
            padding: 40px 30px;
            background: rgba(26, 26, 26, 0.8);
            border-radius: 20px;
            border: 1px solid var(--border);
            transition: all 0.3s;
            backdrop-filter: blur(10px);
            opacity: 0;
            transform: translateY(50px);
        }

        .tech-feature.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .tech-feature:hover {
            transform: translateY(-10px);
            border-color: var(--gold);
        }

        .tech-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.1), rgba(212, 175, 55, 0.05));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            font-size: 36px;
            color: var(--gold);
        }

        .tech-feature h3 {
            font-size: 24px;
            margin-bottom: 15px;
            color: var(--light);
        }

        .tech-feature p {
            color: var(--gray);
            line-height: 1.6;
        }

        /* CTA Section */
        .cta-section {
            padding: 150px 60px;
            background: var(--dark);
            text-align: center;
            position: relative;
        }

        .cta-content {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
            opacity: 0;
            transform: translateY(50px);
        }

        .cta-content.visible {
            opacity: 1;
            transform: translateY(0);
            transition: all 0.8s;
        }

        .cta-title {
            font-size: 64px;
            font-weight: 800;
            margin-bottom: 30px;
            background: linear-gradient(90deg, var(--light), var(--gold));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .cta-description {
            font-size: 20px;
            color: var(--gray);
            margin-bottom: 50px;
            line-height: 1.6;
        }

        /* Footer */
        .footer {
            padding: 80px 60px 40px;
            background: linear-gradient(180deg, var(--dark) 0%, #080808 100%);
            border-top: 1px solid var(--border);
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 60px;
            max-width: 1400px;
            margin: 0 auto 60px;
        }

        .footer-column h4 {
            font-size: 20px;
            color: var(--gold);
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 10px;
        }

        .footer-column h4::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 2px;
            background: var(--gold);
        }

        .footer-links {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .footer-links a {
            color: var(--gray);
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: var(--gold);
        }

        .social-icons {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        .social-icon {
            width: 40px;
            height: 40px;
            background: var(--dark-card);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--light);
            text-decoration: none;
            transition: all 0.3s;
        }

        .social-icon:hover {
            background: var(--gold);
            color: var(--dark);
            transform: translateY(-3px);
        }

        .copyright {
            text-align: center;
            color: var(--gray);
            padding-top: 40px;
            border-top: 1px solid var(--border);
            font-size: 14px;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(100px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .hero-title {
                font-size: 76px;
            }
            
            .animated-car {
                width: 500px;
                right: 5%;
            }
            
            .stats-grid,
            .tech-features,
            .footer-content {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 992px) {
            .hero {
                flex-direction: column;
                justify-content: center;
                text-align: center;
                padding: 0 30px;
            }
            
            .hero-title {
                font-size: 56px;
            }
            
            .animated-car {
                position: relative;
                right: auto;
                bottom: auto;
                width: 400px;
                height: 200px;
                margin-top: 40px;
                order: 2;
            }
            
            .hero-content {
                order: 1;
            }
            
            .hero-buttons {
                justify-content: center;
            }
            
            .section-title {
                font-size: 42px;
            }
            
            .cta-title {
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
            
            .hero-title {
                font-size: 42px;
            }
            
            .hero-description {
                font-size: 18px;
            }
            
            .hero-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .primary-btn,
            .secondary-btn {
                width: 100%;
                max-width: 300px;
            }
            
            .stats-section,
            .models-section,
            .tech-section,
            .cta-section {
                padding: 80px 20px;
            }
            
            .models-grid {
                grid-template-columns: 1fr;
            }
            
            .footer {
                padding: 60px 20px 30px;
            }
            
            .footer-content {
                grid-template-columns: 1fr;
                gap: 40px;
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 32px;
            }
            
            .section-title {
                font-size: 32px;
            }
            
            .stat-number {
                font-size: 48px;
            }
            
            .cta-title {
                font-size: 36px;
            }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="logo">LUXURY <span>AUTO</span></div>
        <div class="nav-links">
            <a href="index.php" class="active">Home</a>
            <a href="models.php">Models</a>
            <a href="performance.php">Performance</a>
            <a href="brand.php">Brand</a>
            <a href="news.php">News</a>
            <a href="contact.php">Contact</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <div class="hero-subtitle">REDEFINING EXCELLENCE</div>
            <h1 class="hero-title">AUTOMOTIVE<br>MASTERY</h1>
            <p class="hero-description">Experience unparalleled luxury, performance, and innovation. Where cutting-edge engineering meets timeless elegance in every vehicle we craft.</p>
            <div class="hero-buttons">
                <a href="models.php" class="primary-btn">
                    <i class="fas fa-car"></i>
                    EXPLORE MODELS
                </a>
                <a href="contact.php" class="secondary-btn">
                    <i class="fas fa-headset"></i>
                    CONTACT US
                </a>
            </div>
        </div>
        
        <!-- Animated Car -->
        <div class="animated-car">
            <div class="car-image"></div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="stats-grid">
            <div class="stat-card" id="stat1">
                <div class="stat-number" data-count="150">0</div>
                <div class="stat-label">MODELS AVAILABLE</div>
            </div>
            <div class="stat-card" id="stat2">
                <div class="stat-number" data-count="98">0</div>
                <div class="stat-label">CLIENT SATISFACTION</div>
            </div>
            <div class="stat-card" id="stat3">
                <div class="stat-number" data-count="50">0</div>
                <div class="stat-label">COUNTRIES SERVED</div>
            </div>
            <div class="stat-card" id="stat4">
                <div class="stat-number" data-count="24">24</div>
                <div class="stat-label">/7 SUPPORT</div>
            </div>
        </div>
    </section>

    <!-- Featured Models -->
    <section class="models-section">
        <div class="section-header" id="modelsHeader">
            <div class="section-subtitle">EXCLUSIVE COLLECTION</div>
            <h2 class="section-title">FEATURED MODELS</h2>
        </div>
        
        <div class="models-grid">
            <div class="model-card" id="model1">
                <div class="model-image">
                    <img src="https://images.unsplash.com/photo-1553440569-bcc63803a83d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Mercedes AMG GT">
                </div>
                <div class="model-content">
                    <h3 class="model-name">Mercedes-AMG GT</h3>
                    <div class="model-price">$150,000</div>
                    <div class="model-specs">
                        <div class="spec">
                            <div class="spec-value">4.0L V8</div>
                            <div class="spec-label">ENGINE</div>
                        </div>
                        <div class="spec">
                            <div class="spec-value">577 HP</div>
                            <div class="spec-label">POWER</div>
                        </div>
                        <div class="spec">
                            <div class="spec-value">3.5s</div>
                            <div class="spec-label">0-60 MPH</div>
                        </div>
                    </div>
                    <a href="models.php" class="secondary-btn" style="width: 100%; padding: 15px;">
                        VIEW DETAILS
                    </a>
                </div>
            </div>
            
            <div class="model-card" id="model2">
                <div class="model-image">
                    <img src="https://images.unsplash.com/photo-1494976388531-d1058494cdd8?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Porsche 911">
                </div>
                <div class="model-content">
                    <h3 class="model-name">Porsche 911 Turbo S</h3>
                    <div class="model-price">$220,000</div>
                    <div class="model-specs">
                        <div class="spec">
                            <div class="spec-value">3.8L H6</div>
                            <div class="spec-label">ENGINE</div>
                        </div>
                        <div class="spec">
                            <div class="spec-value">640 HP</div>
                            <div class="spec-label">POWER</div>
                        </div>
                        <div class="spec">
                            <div class="spec-value">2.6s</div>
                            <div class="spec-label">0-60 MPH</div>
                        </div>
                    </div>
                    <a href="models.php" class="secondary-btn" style="width: 100%; padding: 15px;">
                        VIEW DETAILS
                    </a>
                </div>
            </div>
            
            <div class="model-card" id="model3">
                <div class="model-image">
                    <img src="https://images.unsplash.com/photo-1580273916550-e323be2ae537?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="BMW M8">
                </div>
                <div class="model-content">
                    <h3 class="model-name">BMW M8 Competition</h3>
                    <div class="model-price">$145,000</div>
                    <div class="model-specs">
                        <div class="spec">
                            <div class="spec-value">4.4L V8</div>
                            <div class="spec-label">ENGINE</div>
                        </div>
                        <div class="spec">
                            <div class="spec-value">617 HP</div>
                            <div class="spec-label">POWER</div>
                        </div>
                        <div class="spec">
                            <div class="spec-value">3.0s</div>
                            <div class="spec-label">0-60 MPH</div>
                        </div>
                    </div>
                    <a href="models.php" class="secondary-btn" style="width: 100%; padding: 15px;">
                        VIEW DETAILS
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Technology Section -->
    <section class="tech-section">
        <div class="tech-content">
            <div class="section-header" id="techHeader">
                <div class="section-subtitle">INNOVATION</div>
                <h2 class="section-title">CUTTING-EDGE TECHNOLOGY</h2>
            </div>
            
            <div class="tech-features">
                <div class="tech-feature" id="tech1">
                    <div class="tech-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h3>Hybrid Power</h3>
                    <p>Advanced hybrid systems combining electric efficiency with powerful combustion engines for optimal performance.</p>
                </div>
                
                <div class="tech-feature" id="tech2">
                    <div class="tech-icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <h3>AI Integration</h3>
                    <p>Artificial intelligence systems that learn driving patterns and optimize performance in real-time.</p>
                </div>
                
                <div class="tech-feature" id="tech3">
                    <div class="tech-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Safety First</h3>
                    <p>State-of-the-art safety features including predictive collision avoidance and 360° monitoring systems.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="cta-content" id="ctaContent">
            <h2 class="cta-title">BEGIN YOUR JOURNEY</h2>
            <p class="cta-description">Experience the pinnacle of automotive excellence. Schedule a private viewing or test drive with our luxury specialists today.</p>
            <a href="contact.php" class="primary-btn" style="font-size: 18px; padding: 20px 60px;">
                <i class="fas fa-calendar-alt"></i>
                SCHEDULE VIEWING
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-column">
                <h4>LUXURY AUTO</h4>
                <p style="color: var(--gray); font-size: 14px; line-height: 1.6; margin-bottom: 20px;">Redefining automotive excellence through innovation, luxury, and unparalleled performance.</p>
                <div class="social-icons">
                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="footer-column">
                <h4>Quick Links</h4>
                <div class="footer-links">
                    <a href="index.php">Home</a>
                    <a href="models.php">Models</a>
                    <a href="performance.php">Performance</a>
                    <a href="brand.php">Brand Heritage</a>
                </div>
            </div>
            <div class="footer-column">
                <h4>Explore</h4>
                <div class="footer-links">
                    <a href="news.php">Latest News</a>
                    <a href="contact.php">Contact Us</a>
                    <a href="#">Showrooms</a>
                    <a href="#">Financing</a>
                </div>
            </div>
            <div class="footer-column">
                <h4>Contact</h4>
                <div class="footer-links">
                    <a href="mailto:info@luxuryauto.com">info@luxuryauto.com</a>
                    <a href="tel:+18885551234">+1 (888) 555-1234</a>
                    <a href="#">24/7 Support</a>
                    <a href="#">Global Locations</a>
                </div>
            </div>
        </div>
        <div class="copyright">
            © 2024 LUXURY AUTO. All rights reserved. | Automotive Excellence Redefined
        </div>
    </footer>

    <script>
        // Navbar Scroll Effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 100) {
                navbar.style.background = 'rgba(10, 10, 10, 0.98)';
                navbar.style.padding = '15px 60px';
                navbar.style.backdropFilter = 'blur(20px)';
            } else {
                navbar.style.background = 'rgba(10, 10, 10, 0.95)';
                navbar.style.padding = '25px 60px';
                navbar.style.backdropFilter = 'blur(15px)';
            }
        });

        // Animated Counter
        function animateCounter(element) {
            const target = parseInt(element.getAttribute('data-count'));
            const duration = 2000;
            const increment = target / (duration / 16);
            
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

        // Scroll Animations
        function checkScroll() {
            const elements = [
                { id: 'stat1', element: document.getElementById('stat1') },
                { id: 'stat2', element: document.getElementById('stat2') },
                { id: 'stat3', element: document.getElementById('stat3') },
                { id: 'stat4', element: document.getElementById('stat4') },
                { id: 'modelsHeader', element: document.getElementById('modelsHeader') },
                { id: 'model1', element: document.getElementById('model1') },
                { id: 'model2', element: document.getElementById('model2') },
                { id: 'model3', element: document.getElementById('model3') },
                { id: 'techHeader', element: document.getElementById('techHeader') },
                { id: 'tech1', element: document.getElementById('tech1') },
                { id: 'tech2', element: document.getElementById('tech2') },
                { id: 'tech3', element: document.getElementById('tech3') },
                { id: 'ctaContent', element: document.getElementById('ctaContent') }
            ];

            elements.forEach(item => {
                if (item.element) {
                    const elementTop = item.element.getBoundingClientRect().top;
                    const screenPosition = window.innerHeight / 1.2;

                    if (elementTop < screenPosition) {
                        item.element.classList.add('visible');
                        
                        // Animate counters for stats
                        if (item.id.startsWith('stat')) {
                            const numberElement = item.element.querySelector('.stat-number');
                            if (numberElement && !numberElement.classList.contains('animated')) {
                                numberElement.classList.add('animated');
                                if (item.id !== 'stat4') { // Don't animate the 24/7 stat
                                    animateCounter(numberElement);
                                }
                            }
                        }
                    }
                }
            });
        }

        // Parallax Effect
        function handleParallax() {
            const scrolled = window.pageYOffset;
            const hero = document.querySelector('.hero');
            const techSection = document.querySelector('.tech-section');
            
            if (hero) {
                hero.style.backgroundPositionY = (scrolled * 0.5) + 'px';
            }
            
            if (techSection) {
                techSection.style.backgroundPositionY = (scrolled * 0.3) + 'px';
            }
        }

        // Car Floating Animation
        function carFloatAnimation() {
            const car = document.querySelector('.animated-car');
            if (car) {
                let floatDirection = 1;
                let floatPosition = 0;
                
                setInterval(() => {
                    floatPosition += 0.2 * floatDirection;
                    if (floatPosition > 20 || floatPosition < -20) {
                        floatDirection *= -1;
                    }
                    car.style.transform = `translateY(${floatPosition}px)`;
                }, 50);
            }
        }

        // Initialize Everything
        document.addEventListener('DOMContentLoaded', function() {
            // Initial check for elements in view
            checkScroll();
            
            // Event Listeners
            window.addEventListener('scroll', function() {
                checkScroll();
                handleParallax();
            });
            
            // Start car animation after initial delay
            setTimeout(carFloatAnimation, 2500);
            
            // Smooth scrolling for navigation links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;
                    
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        window.scrollTo({
                            top: targetElement.offsetTop - 80,
                            behavior: 'smooth'
                        });
                    }
                });
            });
            
            // Button hover effects
            const buttons = document.querySelectorAll('.primary-btn, .secondary-btn');
            buttons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                });
                
                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });

        // Model card click handler
        document.querySelectorAll('.model-card').forEach(card => {
            card.addEventListener('click', function(e) {
                if (!e.target.closest('a')) {
                    const modelName = this.querySelector('.model-name').textContent;
                    alert(`Loading details for ${modelName}...\n[Redirecting to models page]`);
                    window.location.href = 'models.php';
                }
            });
        });
    </script>
</body>
</html>