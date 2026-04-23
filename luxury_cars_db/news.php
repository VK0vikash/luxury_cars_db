<?php
// news.php - Clean & Advanced Car News Page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car News | LUXURY AUTO</title>
    <style>
        :root {
            --gold: #d4af37;
            --dark: #0a0a0a;
            --light: #ffffff;
            --gray: #888888;
            --dark-card: #1a1a1a;
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
        }

        /* Navigation */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 40px;
            background: rgba(10, 10, 10, 0.95);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            backdrop-filter: blur(10px);
        }

        .logo {
            font-size: 28px;
            font-weight: 700;
            color: var(--gold);
            letter-spacing: 1px;
        }

        .logo span {
            color: var(--light);
        }

        .nav-links {
            display: flex;
            gap: 30px;
        }

        .nav-links a {
            color: var(--light);
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            padding: 8px 0;
            position: relative;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: var(--gold);
        }

        .nav-links a.active {
            color: var(--gold);
        }

        .nav-links a.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: var(--gold);
        }

        /* Hero */
        .hero {
            padding: 140px 40px 60px;
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
        }

       .hero h1 {
    font-size: 48px;
    font-weight: 700;
    margin-bottom: 20px;
    background: linear-gradient(90deg, var(--light), var(--gold));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

        .hero p {
            font-size: 18px;
            color: var(--gray);
            margin-bottom: 40px;
        }

        /* Categories */
        .categories {
            padding: 20px 40px;
            background: rgba(26, 26, 26, 0.8);
            position: sticky;
            top: 80px;
            z-index: 900;
        }

        .category-filters {
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .category-btn {
            padding: 10px 25px;
            background: transparent;
            border: 1px solid #333;
            color: var(--light);
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 14px;
            font-weight: 500;
        }

        .category-btn:hover,
        .category-btn.active {
            background: var(--gold);
            color: var(--dark);
            border-color: var(--gold);
            transform: translateY(-2px);
        }

        /* Featured Article */
        .featured-article {
            padding: 60px 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .featured-card {
            background: var(--dark-card);
            border-radius: 15px;
            overflow: hidden;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            padding: 40px;
            border: 1px solid rgba(212, 175, 55, 0.1);
        }

        .featured-content h3 {
            font-size: 32px;
            margin-bottom: 20px;
            color: var(--light);
        }

        .featured-meta {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .featured-category {
            background: rgba(212, 175, 55, 0.1);
            color: var(--gold);
            padding: 5px 15px;
            border-radius: 15px;
        }

        .featured-date {
            color: var(--gray);
        }

        .featured-excerpt {
            color: var(--gray);
            margin-bottom: 30px;
            line-height: 1.8;
        }

        .featured-image {
            border-radius: 10px;
            overflow: hidden;
            height: 300px;
        }

        .featured-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }

        .featured-card:hover .featured-image img {
            transform: scale(1.05);
        }

        .read-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: var(--gold);
            color: var(--dark);
            padding: 12px 30px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
        }

        .read-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(212, 175, 55, 0.2);
        }

        /* News Grid */
        .news-grid-section {
            padding: 60px 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-title {
            font-size: 32px;
            margin-bottom: 40px;
            color: var(--light);
            position: relative;
            padding-bottom: 15px;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background: var(--gold);
        }

        .news-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 30px;
        }

        .news-card {
            background: var(--dark-card);
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .news-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            border-color: rgba(212, 175, 55, 0.2);
        }

        .news-image {
            height: 200px;
            overflow: hidden;
        }

        .news-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }

        .news-card:hover .news-image img {
            transform: scale(1.1);
        }

        .news-content {
            padding: 25px;
        }

        .news-category {
            display: inline-block;
            background: rgba(212, 175, 55, 0.1);
            color: var(--gold);
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .news-title {
            font-size: 20px;
            margin-bottom: 10px;
            color: var(--light);
            line-height: 1.4;
        }

        .news-excerpt {
            color: var(--gray);
            font-size: 14px;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .news-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .news-date {
            color: var(--gray);
            font-size: 13px;
        }

        /* Newsletter */
        .newsletter {
            padding: 80px 40px;
            background: rgba(26, 26, 26, 0.8);
            text-align: center;
            max-width: 800px;
            margin: 40px auto;
            border-radius: 20px;
        }

        .newsletter h3 {
            font-size: 28px;
            margin-bottom: 15px;
            color: var(--light);
        }

        .newsletter p {
            color: var(--gray);
            margin-bottom: 30px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .subscribe-form {
            display: flex;
            gap: 15px;
            max-width: 500px;
            margin: 0 auto;
        }

        .email-input {
            flex: 1;
            padding: 15px 25px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 25px;
            color: var(--light);
            font-size: 15px;
            outline: none;
        }

        .email-input:focus {
            border-color: var(--gold);
        }

        .subscribe-btn {
            background: var(--gold);
            color: var(--dark);
            padding: 15px 35px;
            border: none;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .subscribe-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(212, 175, 55, 0.2);
        }

        /* Footer */
        .footer {
            padding: 60px 40px 30px;
            background: rgba(10, 10, 10, 0.95);
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-column h4 {
            font-size: 18px;
            color: var(--gold);
            margin-bottom: 20px;
        }

        .footer-links {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .footer-links a {
            color: var(--gray);
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: var(--gold);
        }

        .copyright {
            text-align: center;
            color: var(--gray);
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            font-size: 14px;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .featured-card {
                grid-template-columns: 1fr;
                gap: 30px;
            }
            
            .footer-content {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 15px 20px;
                flex-direction: column;
                gap: 15px;
            }
            
            .nav-links {
                gap: 20px;
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .hero {
                padding: 120px 20px 40px;
            }
            
            .hero h1 {
                font-size: 36px;
            }
            
            .categories,
            .featured-article,
            .news-grid-section {
                padding: 40px 20px;
            }
            
            .news-grid {
                grid-template-columns: 1fr;
            }
            
            .footer {
                padding: 40px 20px 20px;
            }
            
            .subscribe-form {
                flex-direction: column;
            }
        }

        @media (max-width: 480px) {
            .hero h1 {
                font-size: 28px;
            }
            
            .featured-content h3 {
                font-size: 24px;
            }
            
            .section-title {
                font-size: 24px;
            }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
            <a href="brand.php">Brand</a>
            <a href="news.php" class="active">News</a>
            <a href="contact.php">Contact</a>
        </div>
    </nav>

    <!-- Hero -->
    <section class="hero">
        <h1>Car News & Updates</h1>
        <p>Latest news, reviews, and updates about luxury cars, new launches, and automotive technology.</p>
    </section>

    <!-- Categories -->
    <section class="categories">
        <div class="category-filters">
            <button class="category-btn active" data-category="all">All News</button>
            <button class="category-btn" data-category="new-launches">New Launches</button>
            <button class="category-btn" data-category="reviews">Car Reviews</button>
            <button class="category-btn" data-category="technology">Technology</button>
            <button class="category-btn" data-category="updates">Industry Updates</button>
        </div>
    </section>

    <!-- Featured Article -->
    <section class="featured-article">
        <div class="featured-card">
            <div class="featured-content">
                <div class="featured-meta">
                    <span class="featured-category">New Launch</span>
                    <span class="featured-date">February 6, 2024</span>
                </div>
                <h3>2024 Mercedes-AMG GT Coupe: First Drive Review</h3>
                <p class="featured-excerpt">The new AMG GT Coupe combines stunning design with phenomenal performance. With a 4.0-liter V8 biturbo engine producing 577 horsepower, it delivers 0-60 mph in just 3.5 seconds.</p>
                <button class="read-btn" onclick="readArticle('amg-gt-review')">
                    Read Full Review
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>
            <div class="featured-image">
                <img src="https://images.unsplash.com/photo-1555212697-194d092e3b8f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Mercedes AMG GT">
            </div>
        </div>
    </section>

    <!-- News Grid -->
    <section class="news-grid-section">
        <h2 class="section-title">Latest Car News</h2>
        <div class="news-grid">
            <!-- News 1 -->
            <div class="news-card" data-category="new-launches">
                <div class="news-image">
                    <img src="https://images.unsplash.com/photo-1549399542-7e3f8b79c341?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Porsche 911">
                </div>
                <div class="news-content">
                    <span class="news-category">New Launch</span>
                    <h3 class="news-title">Porsche Unveils 2024 911 Turbo S</h3>
                    <p class="news-excerpt">The latest 911 Turbo S features a 640 hp engine and achieves 0-60 mph in 2.6 seconds with improved aerodynamics.</p>
                    <div class="news-meta">
                        <span class="news-date">Feb 5, 2024</span>
                        <button class="read-btn" style="padding: 8px 20px; font-size: 14px;" onclick="readArticle('porsche-911')">
                            Read
                        </button>
                    </div>
                </div>
            </div>

            <!-- News 2 -->
            <div class="news-card" data-category="technology">
                <div class="news-image">
                    <img src="https://images.unsplash.com/photo-1580273916550-e323be2ae537?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="BMW Technology">
                </div>
                <div class="news-content">
                    <span class="news-category">Technology</span>
                    <h3 class="news-title">BMW's New Electric Platform Revealed</h3>
                    <p class="news-excerpt">BMW announces NEUE KLASSE platform offering 30% more range and faster charging for future electric models.</p>
                    <div class="news-meta">
                        <span class="news-date">Feb 4, 2024</span>
                        <button class="read-btn" style="padding: 8px 20px; font-size: 14px;" onclick="readArticle('bmw-electric')">
                            Read
                        </button>
                    </div>
                </div>
            </div>

            <!-- News 3 -->
            <div class="news-card" data-category="reviews">
                <div class="news-image">
                    <img src="https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Range Rover Review">
                </div>
                <div class="news-content">
                    <span class="news-category">Car Review</span>
                    <h3 class="news-title">Range Rover Sport SV: Luxury Meets Performance</h3>
                    <p class="news-excerpt">Our detailed review of the new Range Rover Sport SV with its 626 hp V8 and advanced off-road capabilities.</p>
                    <div class="news-meta">
                        <span class="news-date">Feb 3, 2024</span>
                        <button class="read-btn" style="padding: 8px 20px; font-size: 14px;" onclick="readArticle('range-rover-review')">
                            Read
                        </button>
                    </div>
                </div>
            </div>

            <!-- News 4 -->
            <div class="news-card" data-category="updates">
                <div class="news-image">
                    <img src="https://images.unsplash.com/photo-1494976388531-d1058494cdd8?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Car Industry">
                </div>
                <div class="news-content">
                    <span class="news-category">Industry Updates</span>
                    <h3 class="news-title">Luxury Car Sales Increase by 15% in Q4 2023</h3>
                    <p class="news-excerpt">Despite economic challenges, luxury car manufacturers report record sales figures for the last quarter.</p>
                    <div class="news-meta">
                        <span class="news-date">Feb 2, 2024</span>
                        <button class="read-btn" style="padding: 8px 20px; font-size: 14px;" onclick="readArticle('sales-update')">
                            Read
                        </button>
                    </div>
                </div>
            </div>

            <!-- News 5 -->
            <div class="news-card" data-category="new-launches">
                <div class="news-image">
                    <img src="https://images.unsplash.com/photo-1519641471654-76ce0107ad1b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Audi Launch">
                </div>
                <div class="news-content">
                    <span class="news-category">New Launch</span>
                    <h3 class="news-title">Audi RS e-tron GT Performance Edition</h3>
                    <p class="news-excerpt">Audi launches limited edition RS e-tron GT with 637 hp and exclusive interior package, limited to 500 units worldwide.</p>
                    <div class="news-meta">
                        <span class="news-date">Feb 1, 2024</span>
                        <button class="read-btn" style="padding: 8px 20px; font-size: 14px;" onclick="readArticle('audi-etron')">
                            Read
                        </button>
                    </div>
                </div>
            </div>

            <!-- News 6 -->
            <div class="news-card" data-category="technology">
                <div class="news-image">
                    <img src="https://images.unsplash.com/photo-1621007947382-bb3c3994e3fb?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Tesla Update">
                </div>
                <div class="news-content">
                    <span class="news-category">Technology</span>
                    <h3 class="news-title">Tesla Model S Plaid+ Gets New Battery Tech</h3>
                    <p class="news-excerpt">Tesla announces new 4680 battery cells for Model S Plaid+, increasing range to 520 miles on a single charge.</p>
                    <div class="news-meta">
                        <span class="news-date">Jan 31, 2024</span>
                        <button class="read-btn" style="padding: 8px 20px; font-size: 14px;" onclick="readArticle('tesla-battery')">
                            Read
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="newsletter">
        <h3>Stay Updated With Car News</h3>
        <p>Subscribe to our newsletter for the latest car news, reviews, and exclusive updates delivered to your inbox.</p>
        <form class="subscribe-form" id="newsletterForm">
            <input type="email" class="email-input" placeholder="Enter your email" required>
            <button type="submit" class="subscribe-btn">Subscribe</button>
        </form>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-column">
                <h4>LUXURY AUTO</h4>
                <p style="color: var(--gray); font-size: 14px; line-height: 1.6;">Your trusted source for luxury car news, reviews, and industry updates.</p>
            </div>
            <div class="footer-column">
                <h4>Quick Links</h4>
                <div class="footer-links">
                    <a href="index.php">Home</a>
                    <a href="models.php">Car Models</a>
                    <a href="news.php">Latest News</a>
                    <a href="contact.php">Contact Us</a>
                </div>
            </div>
            <div class="footer-column">
                <h4>Contact</h4>
                <div class="footer-links">
                    <a href="mailto:news@luxuryauto.com">news@luxuryauto.com</a>
                    <a href="tel:+18885551234">+1 (888) 555-1234</a>
                    <a href="#">Media Inquiries</a>
                    <a href="#">Advertising</a>
                </div>
            </div>
        </div>
        <div class="copyright">
            © 2024 LUXURY AUTO NEWS. All rights reserved. | All news articles are about cars and automotive industry.
        </div>
    </footer>

    <script>
        // Category Filtering
        document.addEventListener('DOMContentLoaded', function() {
            const categoryBtns = document.querySelectorAll('.category-btn');
            const newsCards = document.querySelectorAll('.news-card');
            
            categoryBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    // Update active button
                    categoryBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    
                    const category = this.getAttribute('data-category');
                    
                    // Filter news cards
                    newsCards.forEach(card => {
                        if (category === 'all' || card.getAttribute('data-category') === category) {
                            card.style.display = 'block';
                            setTimeout(() => {
                                card.style.opacity = '1';
                            }, 10);
                        } else {
                            card.style.opacity = '0';
                            setTimeout(() => {
                                card.style.display = 'none';
                            }, 300);
                        }
                    });
                });
            });
            
            // Newsletter Form
            const newsletterForm = document.getElementById('newsletterForm');
            newsletterForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const email = this.querySelector('.email-input').value;
                
                if (validateEmail(email)) {
                    alert(`Thank you for subscribing!\nYou'll receive the latest car news at ${email}`);
                    this.reset();
                } else {
                    alert('Please enter a valid email address.');
                }
            });
            
            // Email validation
            function validateEmail(email) {
                const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(email);
            }
        });
        
        // Read Article Function
        function readArticle(articleId) {
            const articles = {
                'amg-gt-review': {
                    title: '2024 Mercedes-AMG GT Coupe Review',
                    content: 'The new AMG GT Coupe delivers exceptional performance with its 4.0L V8 biturbo engine. The interior features premium materials and the latest MBUX infotainment system.'
                },
                'porsche-911': {
                    title: '2024 Porsche 911 Turbo S Launch',
                    content: 'Porsche introduces the most powerful 911 Turbo S yet with improved aerodynamics and advanced chassis technology.'
                },
                'bmw-electric': {
                    title: 'BMW NEUE KLASSE Platform',
                    content: 'BMW\'s new electric vehicle platform promises increased range, faster charging, and sustainable materials.'
                },
                'range-rover-review': {
                    title: 'Range Rover Sport SV Review',
                    content: 'Combining luxury with extreme performance, the Range Rover Sport SV is a benchmark in the SUV segment.'
                },
                'sales-update': {
                    title: 'Luxury Car Sales Report Q4 2023',
                    content: 'Industry analysis shows 15% growth in luxury car sales despite global economic challenges.'
                },
                'audi-etron': {
                    title: 'Audi RS e-tron GT Performance',
                    content: 'Limited edition electric sports car with exclusive features and enhanced performance package.'
                },
                'tesla-battery': {
                    title: 'Tesla 4680 Battery Technology',
                    content: 'New battery cells provide 16% more range and improved thermal management for Model S Plaid+.'
                }
            };
            
            if (articles[articleId]) {
                const article = articles[articleId];
                alert(`📰 ${article.title}\n\n${article.content}\n\n[Full article would load here in a complete website]`);
            }
        }
        
        // Smooth scroll for navigation
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
        
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.background = 'rgba(10, 10, 10, 0.98)';
                navbar.style.boxShadow = '0 5px 20px rgba(0,0,0,0.2)';
            } else {
                navbar.style.background = 'rgba(10, 10, 10, 0.95)';
                navbar.style.boxShadow = 'none';
            }
        });
    </script>
</body>
</html>