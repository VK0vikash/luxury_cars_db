<?php
// models.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Models | LUXURY AUTO</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #0c0c0c;
            color: #fff;
            overflow-x: hidden;
        }

        /* Navigation */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 25px 60px;
            background: linear-gradient(180deg, rgba(12,12,12,0.95) 0%, rgba(12,12,12,0.85) 100%);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(212, 175, 55, 0.2);
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
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.9)),
                        url('https://images.unsplash.com/photo-1493238792000-8113da705763?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 0 20px;
        }

        .hero-content {
            max-width: 800px;
        }

        .hero h1 {
            font-size: 72px;
            margin-bottom: 20px;
            background: linear-gradient(90deg, #fff, #d4af37);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        .hero p {
            font-size: 20px;
            color: #ccc;
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .cta-button {
            background: linear-gradient(135deg, #d4af37, #b8941f);
            color: #000;
            padding: 18px 45px;
            font-size: 18px;
            font-weight: bold;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 10px 30px rgba(212, 175, 55, 0.3);
        }

        .cta-button:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(212, 175, 55, 0.4);
            background: linear-gradient(135deg, #b8941f, #d4af37);
        }

        /* Models Section */
        .models-section {
            padding: 120px 60px;
            background: #0c0c0c;
        }

        .section-title {
            font-size: 48px;
            text-align: center;
            margin-bottom: 80px;
            position: relative;
            color: #fff;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: #d4af37;
        }

        /* Filter Buttons */
        .filter-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 60px;
            flex-wrap: wrap;
        }

        .filter-btn {
            background: transparent;
            color: #fff;
            border: 2px solid #333;
            padding: 12px 30px;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .filter-btn:hover,
        .filter-btn.active {
            background: #d4af37;
            color: #000;
            border-color: #d4af37;
            transform: translateY(-2px);
        }

        /* Models Grid */
        .models-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 40px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .model-card {
            background: linear-gradient(145deg, #1a1a1a, #0f0f0f);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s;
            border: 1px solid rgba(255,255,255,0.05);
            position: relative;
        }

        .model-card:hover {
            transform: translateY(-15px);
            border-color: rgba(212, 175, 55, 0.3);
            box-shadow: 0 20px 40px rgba(0,0,0,0.5);
        }

        .model-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #d4af37, #b8941f);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .model-card:hover::before {
            opacity: 1;
        }

        .model-image {
            height: 220px;
            overflow: hidden;
        }

        .model-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }

        .model-card:hover .model-image img {
            transform: scale(1.05);
        }

        .model-info {
            padding: 30px;
        }

        .model-name {
            font-size: 24px;
            margin-bottom: 10px;
            color: #fff;
        }

        .model-price {
            font-size: 28px;
            color: #d4af37;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .model-specs {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #333;
        }

        .spec {
            text-align: center;
        }

        .spec-value {
            font-size: 20px;
            color: #d4af37;
            font-weight: bold;
        }

        .spec-label {
            font-size: 14px;
            color: #888;
            text-transform: uppercase;
            margin-top: 5px;
        }

        .model-description {
            color: #aaa;
            line-height: 1.6;
            margin-bottom: 25px;
            font-size: 14px;
        }

        .model-buttons {
            display: flex;
            gap: 15px;
        }

        .details-btn,
        .test-drive-btn {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s;
        }

        .details-btn {
            background: transparent;
            color: #d4af37;
            border: 2px solid #d4af37;
        }

        .details-btn:hover {
            background: #d4af37;
            color: #000;
        }

        .test-drive-btn {
            background: linear-gradient(135deg, #d4af37, #b8941f);
            color: #000;
        }

        .test-drive-btn:hover {
            background: linear-gradient(135deg, #b8941f, #d4af37);
        }

        /* Statistics Section */
        .stats-section {
            padding: 100px 60px;
            background: linear-gradient(135deg, rgba(20,20,20,0.9), rgba(10,10,10,0.9)),
                        url('https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-attachment: fixed;
            text-align: center;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .stat-item {
            padding: 40px 20px;
        }

        .stat-number {
            font-size: 60px;
            font-weight: 800;
            color: #d4af37;
            margin-bottom: 10px;
            background: linear-gradient(90deg, #d4af37, #fff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-label {
            font-size: 18px;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        /* Footer */
        .footer {
            background: linear-gradient(180deg, #0c0c0c 0%, #080808 100%);
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
            .models-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .stats-grid,
            .footer-content {
                grid-template-columns: repeat(2, 1fr);
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
            
            .hero h1 {
                font-size: 48px;
            }
            
            .models-section {
                padding: 80px 20px;
            }
            
            .models-grid {
                grid-template-columns: 1fr;
            }
            
            .stats-section {
                padding: 60px 20px;
            }
            
            .footer {
                padding: 60px 20px 30px;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="logo">LUXURY <span>AUTO</span></div>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="models.php" class="active">Models</a>
            <a href="performance.php">Performance</a>
            <a href="brand.php">Brand</a>
            <a href="news.php">News</a>
            <a href="contact.php">Contact</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>EXQUISITE COLLECTION</h1>
            <p>Discover our curated selection of luxury vehicles, each crafted with precision engineering, innovative technology, and unparalleled comfort. Experience automotive excellence.</p>
            <button class="cta-button" onclick="scrollToModels()">EXPLORE MODELS</button>
        </div>
    </section>

    <!-- Models Section -->
    <section class="models-section" id="models">
        <h2 class="section-title">OUR COLLECTION</h2>
        
        <!-- Filter Buttons -->
        <div class="filter-buttons">
            <button class="filter-btn active" data-filter="all">All Models</button>
            <button class="filter-btn" data-filter="suv">SUV</button>
            <button class="filter-btn" data-filter="sedan">Sedan</button>
            <button class="filter-btn" data-filter="sports">Sports</button>
            <button class="filter-btn" data-filter="electric">Electric</button>
        </div>

        <!-- Models Grid -->
        <div class="models-grid">
            <!-- Model 1 -->
            <div class="model-card" data-category="suv">
                <div class="model-image">
                    <img src="https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Range Rover">
                </div>
                <div class="model-info">
                    <h3 class="model-name">Range Rover Autobiography</h3>
                    <div class="model-price">$150,000</div>
                    <div class="model-specs">
                        <div class="spec">
                            <div class="spec-value">5.0L V8</div>
                            <div class="spec-label">Engine</div>
                        </div>
                        <div class="spec">
                            <div class="spec-value">557 HP</div>
                            <div class="spec-label">Power</div>
                        </div>
                        <div class="spec">
                            <div class="spec-value">4.4s</div>
                            <div class="spec-label">0-60 mph</div>
                        </div>
                    </div>
                    <p class="model-description">The ultimate luxury SUV with handcrafted interior, advanced terrain response, and executive class comfort.</p>
                    <div class="model-buttons">
                        <button class="details-btn">DETAILS</button>
                        <button class="test-drive-btn">TEST DRIVE</button>
                    </div>
                </div>
            </div>

            <!-- Model 2 -->
            <div class="model-card" data-category="sedan">
                <div class="model-image">
                    <img src="https://images.unsplash.com/photo-1555212697-194d092e3b8f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Mercedes S-Class">
                </div>
                <div class="model-info">
                    <h3 class="model-name">Mercedes-Benz S 580</h3>
                    <div class="model-price">$125,000</div>
                    <div class="model-specs">
                        <div class="spec">
                            <div class="spec-value">4.0L V8</div>
                            <div class="spec-label">Engine</div>
                        </div>
                        <div class="spec">
                            <div class="spec-value">496 HP</div>
                            <div class="spec-label">Power</div>
                        </div>
                        <div class="spec">
                            <div class="spec-value">4.4s</div>
                            <div class="spec-label">0-60 mph</div>
                        </div>
                    </div>
                    <p class="model-description">Executive luxury sedan with MBUX Hyperscreen, E-Active Body Control, and First-Class rear cabin.</p>
                    <div class="model-buttons">
                        <button class="details-btn">DETAILS</button>
                        <button class="test-drive-btn">TEST DRIVE</button>
                    </div>
                </div>
            </div>

            <!-- Model 3 -->
            <div class="model-card" data-category="sports">
                <div class="model-image">
                    <img src="https://images.unsplash.com/photo-1519641471654-76ce0107ad1b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Porsche 911">
                </div>
                <div class="model-info">
                    <h3 class="model-name">Porsche 911 Turbo S</h3>
                    <div class="model-price">$220,000</div>
                    <div class="model-specs">
                        <div class="spec">
                            <div class="spec-value">3.8L H6</div>
                            <div class="spec-label">Engine</div>
                        </div>
                        <div class="spec">
                            <div class="spec-value">640 HP</div>
                            <div class="spec-label">Power</div>
                        </div>
                        <div class="spec">
                            <div class="spec-value">2.6s</div>
                            <div class="spec-label">0-60 mph</div>
                        </div>
                    </div>
                    <p class="model-description">Iconic sports car with rear-engine layout, all-wheel drive, and track-ready performance.</p>
                    <div class="model-buttons">
                        <button class="details-btn">DETAILS</button>
                        <button class="test-drive-btn">TEST DRIVE</button>
                    </div>
                </div>
            </div>

            <!-- Model 4 -->
            <div class="model-card" data-category="electric">
                <div class="model-image">
                    <img src="https://images.unsplash.com/photo-1621007947382-bb3c3994e3fb?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Tesla Model S">
                </div>
                <div class="model-info">
                    <h3 class="model-name">Tesla Model S Plaid</h3>
                    <div class="model-price">$135,000</div>
                    <div class="model-specs">
                        <div class="spec">
                            <div class="spec-value">Tri Motor</div>
                            <div class="spec-label">Drive</div>
                        </div>
                        <div class="spec">
                            <div class="spec-value">1,020 HP</div>
                            <div class="spec-label">Power</div>
                        </div>
                        <div class="spec">
                            <div class="spec-value">1.99s</div>
                            <div class="spec-label">0-60 mph</div>
                        </div>
                    </div>
                    <p class="model-description">Electric performance sedan with 390-mile range, yoke steering, and 0-60 mph in under 2 seconds.</p>
                    <div class="model-buttons">
                        <button class="details-btn">DETAILS</button>
                        <button class="test-drive-btn">TEST DRIVE</button>
                    </div>
                </div>
            </div>

            <!-- Model 5 -->
            <div class="model-card" data-category="suv">
                <div class="model-image">
                    <img src="https://images.unsplash.com/photo-1533106418989-88406c7cc8ca?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="BMW X7">
                </div>
                <div class="model-info">
                    <h3 class="model-name">BMW X7 M60i</h3>
                    <div class="model-price">$112,000</div>
                    <div class="model-specs">
                        <div class="spec">
                            <div class="spec-value">4.4L V8</div>
                            <div class="spec-label">Engine</div>
                        </div>
                        <div class="spec">
                            <div class="spec-value">523 HP</div>
                            <div class="spec-label">Power</div>
                        </div>
                        <div class="spec">
                            <div class="spec-value">4.5s</div>
                            <div class="spec-label">0-60 mph</div>
                        </div>
                    </div>
                    <p class="model-description">Full-size luxury SUV with Executive Lounge Package, panoramic sky lounge, and M Sport package.</p>
                    <div class="model-buttons">
                        <button class="details-btn">DETAILS</button>
                        <button class="test-drive-btn">TEST DRIVE</button>
                    </div>
                </div>
            </div>

            <!-- Model 6 -->
            <div class="model-card" data-category="sedan">
                <div class="model-image">
                    <img src="https://images.unsplash.com/photo-1549399542-7e3f8b79c341?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Audi A8">
                </div>
                <div class="model-info">
                    <h3 class="model-name">Audi A8 L Horch</h3>
                    <div class="model-price">$145,000</div>
                    <div class="model-specs">
                        <div class="spec">
                            <div class="spec-value">4.0L V8</div>
                            <div class="spec-label">Engine</div>
                        </div>
                        <div class="spec">
                            <div class="spec-value">563 HP</div>
                            <div class="spec-label">Power</div>
                        </div>
                        <div class="spec">
                            <div class="spec-value">4.8s</div>
                            <div class="spec-label">0-60 mph</div>
                        </div>
                    </div>
                    <p class="model-description">Flagship luxury sedan with dual-tone paint, executive rear seating, and predictive active suspension.</p>
                    <div class="model-buttons">
                        <button class="details-btn">DETAILS</button>
                        <button class="test-drive-btn">TEST DRIVE</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="stats-section">
        <h2 class="section-title">BY THE NUMBERS</h2>
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number">150+</div>
                <div class="stat-label">Models Available</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">98%</div>
                <div class="stat-label">Client Satisfaction</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">50+</div>
                <div class="stat-label">Countries Served</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">24/7</div>
                <div class="stat-label">Support</div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-column">
                <h3>LUXURY AUTO</h3>
                <p>World's premier luxury automotive dealership offering exclusive vehicles and unparalleled customer experience since 1995.</p>
                <div class="social-icons">
                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="footer-column">
                <h3>Quick Links</h3>
                <a href="index.php">Home</a>
                <a href="models.php">Models</a>
                <a href="performance.php">Performance</a>
                <a href="brand.php">Brand Heritage</a>
                <a href="news.php">Latest News</a>
                <a href="contact.php">Contact Us</a>
            </div>
            <div class="footer-column">
                <h3>Services</h3>
                <a href="#">Test Drive</a>
                <a href="#">Financing</a>
                <a href="#">Leasing</a>
                <a href="#">Trade-In</a>
                <a href="#">Maintenance</a>
                <a href="#">Warranty</a>
            </div>
            <div class="footer-column">
                <h3>Contact Info</h3>
                <p><i class="fas fa-map-marker-alt"></i> 123 Luxury Avenue, Beverly Hills, CA</p>
                <p><i class="fas fa-phone"></i> +1 (888) 555-LUXURY</p>
                <p><i class="fas fa-envelope"></i> info@luxuryauto.com</p>
                <p><i class="fas fa-clock"></i> Mon-Sat: 9AM - 8PM</p>
            </div>
        </div>
        <div class="copyright">
            © 2024 LUXURY AUTO. All rights reserved. | Designed with <i class="fas fa-heart" style="color: #d4af37;"></i> for automotive excellence
        </div>
    </footer>

    <script>
        // Smooth scrolling
        function scrollToModels() {
            document.getElementById('models').scrollIntoView({ behavior: 'smooth' });
        }

        // Filter functionality
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.filter-btn');
            const modelCards = document.querySelectorAll('.model-card');
            
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    
                    // Add active class to clicked button
                    this.classList.add('active');
                    
                    const filterValue = this.getAttribute('data-filter');
                    
                    // Show/hide cards based on filter
                    modelCards.forEach(card => {
                        if (filterValue === 'all' || card.getAttribute('data-category') === filterValue) {
                            card.style.display = 'block';
                            setTimeout(() => {
                                card.style.opacity = '1';
                                card.style.transform = 'translateY(0)';
                            }, 100);
                        } else {
                            card.style.opacity = '0';
                            card.style.transform = 'translateY(20px)';
                            setTimeout(() => {
                                card.style.display = 'none';
                            }, 300);
                        }
                    });
                });
            });
            
            // Model buttons functionality
            const testDriveButtons = document.querySelectorAll('.test-drive-btn');
            const detailsButtons = document.querySelectorAll('.details-btn');
            
            testDriveButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const modelName = this.closest('.model-card').querySelector('.model-name').textContent;
                    alert(`Thank you for your interest in the ${modelName}!\nOur team will contact you shortly to schedule a test drive.`);
                });
            });
            
            detailsButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const modelName = this.closest('.model-card').querySelector('.model-name').textContent;
                    const modelPrice = this.closest('.model-card').querySelector('.model-price').textContent;
                    alert(`Detailed specifications for ${modelName} (${modelPrice}) have been sent to your email.`);
                });
            });
            
            // Navbar scroll effect
            window.addEventListener('scroll', function() {
                const navbar = document.querySelector('.navbar');
                if (window.scrollY > 100) {
                    navbar.style.background = 'rgba(12, 12, 12, 0.98)';
                    navbar.style.padding = '15px 60px';
                } else {
                    navbar.style.background = 'linear-gradient(180deg, rgba(12,12,12,0.95) 0%, rgba(12,12,12,0.85) 100%)';
                    navbar.style.padding = '25px 60px';
                }
            });
            
            // Animate stats counter
            const statNumbers = document.querySelectorAll('.stat-number');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const stat = entry.target;
                        const target = parseInt(stat.textContent);
                        let current = 0;
                        const increment = target / 50;
                        
                        const timer = setInterval(() => {
                            current += increment;
                            if (current >= target) {
                                stat.textContent = target + (stat.textContent.includes('+') ? '+' : '');
                                clearInterval(timer);
                            } else {
                                stat.textContent = Math.floor(current) + (stat.textContent.includes('+') ? '+' : '');
                            }
                        }, 30);
                        
                        observer.unobserve(stat);
                    }
                });
            }, { threshold: 0.5 });
            
            statNumbers.forEach(stat => observer.observe(stat));
        });
    </script>
</body>
</html>