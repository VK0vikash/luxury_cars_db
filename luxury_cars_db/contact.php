<?php
// contact.php - Advanced Contact Page
$success = false;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $interest = trim($_POST['interest'] ?? '');
    
    // Validation
    if (empty($name)) $errors[] = 'Name is required';
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required';
    if (empty($message)) $errors[] = 'Message is required';
    
    if (empty($errors)) {
        // In a real application, you would:
        // 1. Save to database
        // 2. Send email notification
        // 3. Process the inquiry
        
        $success = true;
        // Clear form data
        $name = $email = $subject = $message = $phone = $interest = '';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact | LUXURY AUTO</title>
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
            padding: 20px 40px;
            background: rgba(10, 10, 10, 0.95);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            backdrop-filter: blur(10px);
            transition: all 0.3s;
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
            height: 70vh;
            background: linear-gradient(rgba(0,0,0,0.8), rgba(0,0,0,0.9)),
                        url('https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            padding: 0 40px;
            margin-top: 80px;
            position: relative;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 70% 50%, rgba(212, 175, 55, 0.1), transparent 50%);
        }

        .hero-content {
            max-width: 800px;
            position: relative;
            z-index: 2;
        }

        .hero h1 {
            font-size: 60px;
            font-weight: 700;
            margin-bottom: 20px;
            background: linear-gradient(90deg, var(--light), var(--gold));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1.2;
        }

        .hero p {
            font-size: 20px;
            color: var(--gray);
            margin-bottom: 40px;
            max-width: 600px;
        }

        .cta-button {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: var(--gold);
            color: var(--dark);
            padding: 16px 40px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(212, 175, 55, 0.3);
        }

        /* Contact Section */
        .contact-section {
            padding: 100px 40px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
        }

        .section-title {
            font-size: 36px;
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

        /* Contact Form */
        .contact-form-container {
            background: var(--dark-card);
            border-radius: 20px;
            padding: 40px;
            border: 1px solid var(--border);
        }

        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            border: 1px solid transparent;
        }

        .alert-success {
            background: rgba(40, 167, 69, 0.1);
            border-color: #28a745;
            color: #d4edda;
        }

        .alert-error {
            background: rgba(220, 53, 69, 0.1);
            border-color: #dc3545;
            color: #f8d7da;
        }

        .alert ul {
            list-style: none;
            margin-top: 10px;
        }

        .alert li {
            margin-bottom: 5px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--light);
            font-weight: 500;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 15px 20px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--light);
            font-size: 16px;
            transition: all 0.3s;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--gold);
            background: rgba(255, 255, 255, 0.08);
        }

        .form-group textarea {
            min-height: 150px;
            resize: vertical;
        }

        /* Contact Info */
        .contact-info {
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        .info-card {
            background: var(--dark-card);
            border-radius: 15px;
            padding: 30px;
            border: 1px solid var(--border);
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .info-card:hover {
            transform: translateY(-10px);
            border-color: var(--gold);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .info-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--gold), transparent);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .info-card:hover::before {
            opacity: 1;
        }

        .info-icon {
            width: 60px;
            height: 60px;
            background: rgba(212, 175, 55, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: var(--gold);
            margin-bottom: 20px;
        }

        .info-card h3 {
            font-size: 22px;
            margin-bottom: 15px;
            color: var(--light);
        }

        .info-card p {
            color: var(--gray);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Showrooms */
        .showrooms-section {
            padding: 80px 40px;
            background: rgba(26, 26, 26, 0.5);
            max-width: 1400px;
            margin: 0 auto;
        }

        .showrooms-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .showroom-card {
            background: var(--dark-card);
            border-radius: 15px;
            overflow: hidden;
            border: 1px solid var(--border);
            transition: all 0.3s;
        }

        .showroom-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
            border-color: rgba(212, 175, 55, 0.3);
        }

        .showroom-image {
            height: 200px;
            overflow: hidden;
        }

        .showroom-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }

        .showroom-card:hover .showroom-image img {
            transform: scale(1.1);
        }

        .showroom-content {
            padding: 25px;
        }

        .showroom-content h3 {
            font-size: 22px;
            margin-bottom: 15px;
            color: var(--light);
        }

        .showroom-details {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 20px;
        }

        .showroom-detail {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--gray);
            font-size: 14px;
        }

        /* Map */
        .map-section {
            padding: 80px 40px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .map-container {
            height: 500px;
            border-radius: 15px;
            overflow: hidden;
            border: 1px solid var(--border);
            margin-top: 40px;
            background: var(--dark-card);
        }

        iframe {
            width: 100%;
            height: 100%;
            border: none;
            filter: grayscale(100%) invert(90%) hue-rotate(180deg);
        }

        /* FAQ */
        .faq-section {
            padding: 80px 40px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .faq-container {
            margin-top: 40px;
        }

        .faq-item {
            border-bottom: 1px solid var(--border);
            overflow: hidden;
        }

        .faq-question {
            width: 100%;
            padding: 25px 0;
            background: none;
            border: none;
            color: var(--light);
            font-size: 18px;
            text-align: left;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            transition: color 0.3s;
        }

        .faq-question:hover {
            color: var(--gold);
        }

        .faq-question i {
            transition: transform 0.3s;
        }

        .faq-item.active .faq-question i {
            transform: rotate(180deg);
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }

        .faq-item.active .faq-answer {
            max-height: 300px;
        }

        .faq-answer-content {
            padding: 0 0 25px 0;
            color: var(--gray);
            line-height: 1.7;
        }

        /* Footer */
        .footer {
            padding: 60px 40px 30px;
            background: rgba(10, 10, 10, 0.95);
            border-top: 1px solid var(--border);
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 40px;
            max-width: 1400px;
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
            gap: 12px;
        }

        .footer-links a {
            color: var(--gray);
            text-decoration: none;
            transition: color 0.3s;
            font-size: 14px;
        }

        .footer-links a:hover {
            color: var(--gold);
        }

        .copyright {
            text-align: center;
            color: var(--gray);
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
            font-size: 14px;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .contact-grid {
                grid-template-columns: 1fr;
                gap: 40px;
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
                padding: 0 20px;
                height: 60vh;
                margin-top: 100px;
            }
            
            .hero h1 {
                font-size: 40px;
            }
            
            .contact-section,
            .showrooms-section,
            .map-section,
            .faq-section {
                padding: 60px 20px;
            }
            
            .showrooms-grid {
                grid-template-columns: 1fr;
            }
            
            .footer {
                padding: 40px 20px 20px;
            }
            
            .footer-content {
                grid-template-columns: 1fr;
                gap: 30px;
            }
        }

        @media (max-width: 480px) {
            .hero h1 {
                font-size: 32px;
            }
            
            .section-title {
                font-size: 28px;
            }
            
            .contact-form-container {
                padding: 25px;
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
            <a href="news.php">News</a>
            <a href="contact.php" class="active">Contact</a>
        </div>
    </nav>

    <!-- Hero -->
    <section class="hero">
        <div class="hero-content">
            <h1>Experience Luxury Service</h1>
            <p>Connect with our dedicated team for personalized assistance, exclusive offers, and unparalleled customer service.</p>
            <button class="cta-button" onclick="scrollToForm()">
                Get In Touch
                <i class="fas fa-arrow-down"></i>
            </button>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section" id="contact">
        <h2 class="section-title">Contact Us</h2>
        <div class="contact-grid">
            <!-- Contact Form -->
            <div class="contact-form-container">
                <?php if($success): ?>
                    <div class="alert alert-success">
                        <h3><i class="fas fa-check-circle"></i> Message Sent Successfully!</h3>
                        <p>Thank you for contacting Luxury Auto. Our team will respond within 24 hours.</p>
                    </div>
                <?php endif; ?>
                
                <?php if(!empty($errors)): ?>
                    <div class="alert alert-error">
                        <h3><i class="fas fa-exclamation-circle"></i> Please fix the following:</h3>
                        <ul>
                            <?php foreach($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                
                <form method="POST" id="contactForm">
                    <div class="form-group">
                        <label for="name">Full Name *</label>
                        <input type="text" id="name" name="name" 
                               value="<?php echo htmlspecialchars($name ?? ''); ?>" 
                               required placeholder="John Smith">
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email Address *</label>
                        <input type="email" id="email" name="email" 
                               value="<?php echo htmlspecialchars($email ?? ''); ?>" 
                               required placeholder="john@example.com">
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" 
                               value="<?php echo htmlspecialchars($phone ?? ''); ?>" 
                               placeholder="+1 (555) 123-4567">
                    </div>
                    
                    <div class="form-group">
                        <label for="interest">Interest</label>
                        <select id="interest" name="interest">
                            <option value="">Select an option</option>
                            <option value="test-drive" <?php echo ($interest ?? '') === 'test-drive' ? 'selected' : ''; ?>>Schedule Test Drive</option>
                            <option value="sales" <?php echo ($interest ?? '') === 'sales' ? 'selected' : ''; ?>>Sales Inquiry</option>
                            <option value="service" <?php echo ($interest ?? '') === 'service' ? 'selected' : ''; ?>>Service & Maintenance</option>
                            <option value="finance" <?php echo ($interest ?? '') === 'finance' ? 'selected' : ''; ?>>Financing Options</option>
                            <option value="general" <?php echo ($interest ?? '') === 'general' ? 'selected' : ''; ?>>General Inquiry</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" id="subject" name="subject" 
                               value="<?php echo htmlspecialchars($subject ?? ''); ?>" 
                               placeholder="How can we help you?">
                    </div>
                    
                    <div class="form-group">
                        <label for="message">Message *</label>
                        <textarea id="message" name="message" required 
                                  placeholder="Tell us about your requirements..."><?php echo htmlspecialchars($message ?? ''); ?></textarea>
                    </div>
                    
                    <button type="submit" class="cta-button" style="width: 100%;">
                        <i class="fas fa-paper-plane"></i> Send Message
                    </button>
                </form>
            </div>
            
            <!-- Contact Information -->
            <div class="contact-info">
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <h3>Phone Support</h3>
                    <p><i class="fas fa-phone"></i> +1 (888) LUX-AUTO</p>
                    <p><i class="fas fa-clock"></i> 24/7 Emergency Support</p>
                    <p><i class="fas fa-calendar"></i> Mon-Fri: 8AM-8PM EST</p>
                    <p><i class="fas fa-calendar"></i> Sat-Sun: 9AM-6PM EST</p>
                    <button class="cta-button" onclick="callSupport()" style="margin-top: 20px; padding: 12px 25px; font-size: 14px;">
                        <i class="fas fa-phone"></i> Call Now
                    </button>
                </div>
                
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h3>Email</h3>
                    <p><i class="fas fa-envelope"></i> info@luxuryauto.com</p>
                    <p><i class="fas fa-briefcase"></i> sales@luxuryauto.com</p>
                    <p><i class="fas fa-tools"></i> service@luxuryauto.com</p>
                    <p><i class="fas fa-headset"></i> support@luxuryauto.com</p>
                    <button class="cta-button" onclick="emailSupport()" style="margin-top: 20px; padding: 12px 25px; font-size: 14px;">
                        <i class="fas fa-envelope"></i> Email Us
                    </button>
                </div>
                
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>Live Support</h3>
                    <p><i class="fas fa-comments"></i> Live Chat Available</p>
                    <p><i class="fas fa-video"></i> Virtual Consultations</p>
                    <p><i class="fas fa-clock"></i> Response: Within 1 hour</p>
                    <button class="cta-button" onclick="startLiveChat()" style="margin-top: 20px; padding: 12px 25px; font-size: 14px;">
                        <i class="fas fa-comments"></i> Start Live Chat
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Showrooms -->
    <section class="showrooms-section">
        <h2 class="section-title">Global Showrooms</h2>
        <p style="color: var(--gray); margin-bottom: 30px; font-size: 18px;">Visit our exclusive showrooms worldwide for a personalized luxury experience.</p>
        
        <div class="showrooms-grid">
            <div class="showroom-card">
                <div class="showroom-image">
                    <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="New York Showroom">
                </div>
                <div class="showroom-content">
                    <h3>New York Flagship</h3>
                    <div class="showroom-details">
                        <div class="showroom-detail">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>123 Luxury Avenue, Manhattan, NY 10001</span>
                        </div>
                        <div class="showroom-detail">
                            <i class="fas fa-phone"></i>
                            <span>+1 (212) 555-0123</span>
                        </div>
                        <div class="showroom-detail">
                            <i class="fas fa-clock"></i>
                            <span>Mon-Sat: 9AM-8PM | Sun: 10AM-6PM</span>
                        </div>
                    </div>
                    <button class="cta-button" onclick="getDirections('newyork')" style="width: 100%; padding: 12px;">
                        <i class="fas fa-directions"></i> Get Directions
                    </button>
                </div>
            </div>
            
            <div class="showroom-card">
                <div class="showroom-image">
                    <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Dubai Showroom">
                </div>
                <div class="showroom-content">
                    <h3>Dubai Experience Center</h3>
                    <div class="showroom-details">
                        <div class="showroom-detail">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Sheikh Zayed Road, Downtown Dubai</span>
                        </div>
                        <div class="showroom-detail">
                            <i class="fas fa-phone"></i>
                            <span>+971 4 123 4567</span>
                        </div>
                        <div class="showroom-detail">
                            <i class="fas fa-clock"></i>
                            <span>Sat-Thu: 10AM-10PM | Fri: 2PM-10PM</span>
                        </div>
                    </div>
                    <button class="cta-button" onclick="getDirections('dubai')" style="width: 100%; padding: 12px;">
                        <i class="fas fa-directions"></i> Get Directions
                    </button>
                </div>
            </div>
            
            <div class="showroom-card">
                <div class="showroom-image">
                    <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="London Showroom">
                </div>
                <div class="showroom-content">
                    <h3>London Heritage</h3>
                    <div class="showroom-details">
                        <div class="showroom-detail">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>45 Mayfair Street, London W1K 7AA</span>
                        </div>
                        <div class="showroom-detail">
                            <i class="fas fa-phone"></i>
                            <span>+44 20 7123 4567</span>
                        </div>
                        <div class="showroom-detail">
                            <i class="fas fa-clock"></i>
                            <span>Mon-Sat: 9AM-7PM | Sun: 11AM-5PM</span>
                        </div>
                    </div>
                    <button class="cta-button" onclick="getDirections('london')" style="width: 100%; padding: 12px;">
                        <i class="fas fa-directions"></i> Get Directions
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Map -->
    <section class="map-section">
        <h2 class="section-title">Find Us</h2>
        <p style="color: var(--gray); margin-bottom: 30px; font-size: 18px;">Locate our nearest showroom for an exclusive viewing experience.</p>
        
        <div class="map-container">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3024.177858804427!2d-73.98784468459413!3d40.70556567933207!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25a315cdf4c9b%3A0x8b934de5cae6f7a!2sWall%20St%2C%20New%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2s!4v1633023226784!5m2!1sen!2s" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </section>

    <!-- FAQ -->
    <section class="faq-section">
        <h2 class="section-title">Frequently Asked Questions</h2>
        <p style="color: var(--gray); margin-bottom: 30px; font-size: 18px;">Find quick answers to common questions about our services.</p>
        
        <div class="faq-container">
            <div class="faq-item">
                <button class="faq-question">
                    <span>What is your response time for inquiries?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        <p>We aim to respond to all inquiries within 24 hours during business days. For urgent matters, please call our 24/7 support line at +1 (888) LUX-AUTO.</p>
                    </div>
                </div>
            </div>
            
            <div class="faq-item">
                <button class="faq-question">
                    <span>Do you offer international delivery?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        <p>Yes, we offer worldwide delivery services. Our team will coordinate all logistics including customs clearance, registration, and compliance with local regulations in your country.</p>
                    </div>
                </div>
            </div>
            
            <div class="faq-item">
                <button class="faq-question">
                    <span>Can I schedule a private viewing?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        <p>Absolutely. We offer exclusive private viewings outside of regular business hours. Contact our concierge service to arrange a personalized experience with one of our luxury specialists.</p>
                    </div>
                </div>
            </div>
            
            <div class="faq-item">
                <button class="faq-question">
                    <span>What financing options are available?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        <p>We offer a range of financing options including lease programs, financing through our partner banks, and cash purchase options. Our financial advisors will create a customized plan based on your needs.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-column">
                <h4>LUXURY AUTO</h4>
                <p style="color: var(--gray); font-size: 14px; line-height: 1.6; margin-bottom: 20px;">Experience unparalleled luxury and service with our dedicated team.</p>
            </div>
            <div class="footer-column">
                <h4>Quick Links</h4>
                <div class="footer-links">
                    <a href="index.php">Home</a>
                    <a href="models.php">Car Models</a>
                    <a href="performance.php">Performance</a>
                    <a href="contact.php">Contact Us</a>
                </div>
            </div>
            <div class="footer-column">
                <h4>Contact</h4>
                <div class="footer-links">
                    <a href="mailto:info@luxuryauto.com">info@luxuryauto.com</a>
                    <a href="tel:+18885551234">+1 (888) 555-1234</a>
                    <a href="#">Live Chat</a>
                    <a href="#">Schedule Appointment</a>
                </div>
            </div>
            <div class="footer-column">
                <h4>Follow Us</h4>
                <div class="footer-links">
                    <a href="#"><i class="fab fa-facebook"></i> Facebook</a>
                    <a href="#"><i class="fab fa-instagram"></i> Instagram</a>
                    <a href="#"><i class="fab fa-twitter"></i> Twitter</a>
                    <a href="#"><i class="fab fa-linkedin"></i> LinkedIn</a>
                </div>
            </div>
        </div>
        <div class="copyright">
            © 2024 LUXURY AUTO. All rights reserved. | Unparalleled Service & Luxury Experience
        </div>
    </footer>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.background = 'rgba(10, 10, 10, 0.98)';
                navbar.style.padding = '15px 40px';
            } else {
                navbar.style.background = 'rgba(10, 10, 10, 0.95)';
                navbar.style.padding = '20px 40px';
            }
        });
        
        // Form submission
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const message = document.getElementById('message').value.trim();
            
            if (!name || !email || !message) {
                e.preventDefault();
                alert('Please fill in all required fields (Name, Email, Message).');
                return;
            }
            
            if (!validateEmail(email)) {
                e.preventDefault();
                alert('Please enter a valid email address.');
                return;
            }
            
            // Form is valid - PHP will handle the actual submission
        });
        
        // Email validation
        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }
        
        // FAQ Accordion
        document.querySelectorAll('.faq-question').forEach(button => {
            button.addEventListener('click', () => {
                const faqItem = button.parentElement;
                const isActive = faqItem.classList.contains('active');
                
                // Close all FAQ items
                document.querySelectorAll('.faq-item').forEach(item => {
                    item.classList.remove('active');
                });
                
                // Open clicked item if it wasn't active
                if (!isActive) {
                    faqItem.classList.add('active');
                }
            });
        });
        
        // Button Functions
        function scrollToForm() {
            document.getElementById('contact').scrollIntoView({ behavior: 'smooth' });
        }
        
        function callSupport() {
            alert('Calling Luxury Auto Support: +1 (888) LUX-AUTO\n\n[In a real application, this would initiate a phone call]');
        }
        
        function emailSupport() {
            alert('Opening email client to: info@luxuryauto.com\n\n[In a real application, this would open your email client]');
        }
        
        function startLiveChat() {
            alert('Starting Live Chat...\n\n[In a real application, this would open a live chat window]');
        }
        
        function getDirections(location) {
            const locations = {
                'newyork': '123 Luxury Avenue, Manhattan, NY 10001',
                'dubai': 'Sheikh Zayed Road, Downtown Dubai',
                'london': '45 Mayfair Street, London W1K 7AA'
            };
            
            if (locations[location]) {
                alert(`Opening Google Maps for directions to:\n${locations[location]}\n\n[In a real application, this would open Google Maps]`);
            }
        }
        
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
    </script>
</body>
</html>