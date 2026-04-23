<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brand | LUXURY AUTO</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background-color: #0a0a0a;
            color: #fff;
        }

        /* Navigation */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 50px;
            background: rgba(10, 10, 10, 0.95);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #d4af37;
            letter-spacing: 2px;
        }

        .logo span {
            color: #fff;
        }

        .nav-links {
            display: flex;
            gap: 40px;
        }

        .nav-links a {
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: #d4af37;
        }

        /* Hero Section */
        .hero {
            height: 100vh;
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), 
                        url('https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding-top: 80px;
        }

        .hero-content h1 {
            font-size: 60px;
            margin-bottom: 20px;
            color: #d4af37;
        }

        .hero-content p {
            font-size: 20px;
            max-width: 800px;
            margin: 0 auto 30px;
            line-height: 1.6;
        }

        .cta-button {
            background: #d4af37;
            color: #000;
            padding: 15px 40px;
            font-size: 18px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: transform 0.3s, background 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .cta-button:hover {
            background: #c19b2e;
            transform: translateY(-3px);
        }

        /* Brands Section */
        .brands-section {
            padding: 100px 50px;
            text-align: center;
        }

        .section-title {
            font-size: 40px;
            margin-bottom: 60px;
            color: #d4af37;
        }

        .brands-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .brand-card {
            background: #1a1a1a;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s;
        }

        .brand-card:hover {
            transform: translateY(-10px);
        }

        .brand-image {
            height: 200px;
            overflow: hidden;
        }

        .brand-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .brand-info {
            padding: 30px;
        }

        .brand-name {
            font-size: 24px;
            margin-bottom: 15px;
            color: #d4af37;
        }

        .brand-desc {
            color: #aaa;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        /* Features Section */
        .features {
            padding: 100px 50px;
            background: #111;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .feature {
            text-align: center;
            padding: 40px 20px;
        }

        .feature i {
            font-size: 48px;
            color: #d4af37;
            margin-bottom: 20px;
        }

        .feature h3 {
            font-size: 24px;
            margin-bottom: 15px;
            color: #fff;
        }

        .feature p {
            color: #aaa;
        }

        /* Footer */
        .footer {
            background: #0a0a0a;
            padding: 50px;
            text-align: center;
            border-top: 1px solid #333;
        }

        .social-icons {
            margin: 30px 0;
        }

        .social-icons a {
            color: #fff;
            font-size: 24px;
            margin: 0 15px;
            transition: color 0.3s;
        }

        .social-icons a:hover {
            color: #d4af37;
        }

        .copyright {
            color: #666;
            margin-top: 20px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar {
                padding: 20px;
            }
            
            .nav-links {
                gap: 20px;
            }
            
            .hero-content h1 {
                font-size: 40px;
            }
            
            .features-grid {
                grid-template-columns: 1fr;
            }
            
            .brands-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="logo">LUXURY <span>AUTO</span></div>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="models.php">Models</a>
            <a href="performance.php">Performance</a>
            <a href="brand.php" style="color: #d4af37;">Brand</a>
            <a href="news.php">News</a>
            <a href="contact.php">Contact</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>OUR LEGACY</h1>
            <p>For over a century, we've been crafting automotive masterpieces that combine cutting-edge technology with timeless elegance. Discover the story behind the world's most coveted luxury vehicles.</p>
            <a href="#brands" class="cta-button">EXPLORE OUR BRANDS</a>
        </div>
    </section>

    <!-- Brands Section -->
    <section class="brands-section" id="brands">
        <h2 class="section-title">PREMIUM BRANDS</h2>
        <div class="brands-grid">
            <!-- Brand 1 -->
            <div class="brand-card">
                <div class="brand-image">
                    <img src="https://images.unsplash.com/photo-1553440569-bcc63803a83d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Mercedes">
                </div>
                <div class="brand-info">
                    <h3 class="brand-name">Mercedes-Benz</h3>
                    <p class="brand-desc">The best or nothing. German engineering at its finest, delivering luxury, performance, and innovation since 1926.</p>
                    <a href="#" class="cta-button" style="padding: 10px 25px; font-size: 14px;">VIEW MODELS</a>
                </div>
            </div>

            <!-- Brand 2 -->
            <div class="brand-card">
                <div class="brand-image">
                    <img src="https://images.unsplash.com/photo-1580273916550-e323be2ae537?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="BMW">
                </div>
                <div class="brand-info">
                    <h3 class="brand-name">BMW</h3>
                    <p class="brand-desc">Sheer Driving Pleasure. Ultimate driving machines that blend sportiness with luxury in perfect harmony.</p>
                    <a href="#" class="cta-button" style="padding: 10px 25px; font-size: 14px;">VIEW MODELS</a>
                </div>
            </div>

            <!-- Brand 3 -->
            <div class="brand-card">
                <div class="brand-image">
                    <img src="https://images.unsplash.com/photo-1494976388531-d1058494cdd8?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Audi">
                </div>
                <div class="brand-info">
                    <h3 class="brand-name">Audi</h3>
                    <p class="brand-desc">Vorsprung durch Technik. Progressive luxury with quattro all-wheel drive and innovative lighting technology.</p>
                    <a href="#" class="cta-button" style="padding: 10px 25px; font-size: 14px;">VIEW MODELS</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <h2 class="section-title">WHY CHOOSE US</h2>
        <div class="features-grid">
            <div class="feature">
                <i class="fas fa-award"></i>
                <h3>Premium Quality</h3>
                <p>Only the finest materials and craftsmanship for our vehicles.</p>
            </div>
            <div class="feature">
                <i class="fas fa-cogs"></i>
                <h3>Cutting-Edge Tech</h3>
                <p>Latest automotive technology and innovation in every model.</p>
            </div>
            <div class="feature">
                <i class="fas fa-headset"></i>
                <h3>24/7 Support</h3>
                <p>Round-the-clock customer service and roadside assistance.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="logo" style="font-size: 24px;">LUXURY <span>AUTO</span></div>
        <div class="social-icons">
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-youtube"></i></a>
        </div>
        <p class="copyright">© 2024 LUXURY AUTO. All rights reserved.</p>
    </footer>

    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
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

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.background = 'rgba(10, 10, 10, 0.98)';
                navbar.style.boxShadow = '0 5px 20px rgba(0,0,0,0.3)';
            } else {
                navbar.style.background = 'rgba(10, 10, 10, 0.95)';
                navbar.style.boxShadow = 'none';
            }
        });
    </script>
</body>
</html>