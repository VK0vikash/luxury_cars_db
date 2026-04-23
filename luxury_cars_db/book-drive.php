<?php
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Form validation
    $errors = [];
    $data = [
        'full_name' => trim($_POST['full_name'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'phone' => trim($_POST['phone'] ?? ''),
        'car_model_id' => $_POST['car_model'] ?? null,
        'preferred_date' => $_POST['preferred_date'] ?? '',
        'preferred_time' => $_POST['preferred_time'] ?? '',
        'city' => trim($_POST['city'] ?? ''),
        'message' => trim($_POST['message'] ?? '')
    ];
    
    // Validate inputs
    if (empty($data['full_name'])) $errors[] = 'Full name is required';
    if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required';
    if (empty($data['phone'])) $errors[] = 'Phone number is required';
    if (empty($data['preferred_date'])) $errors[] = 'Preferred date is required';
    
    if (empty($errors)) {
        try {
            $stmt = $conn->prepare("
                INSERT INTO test_drive_requests 
                (full_name, email, phone, car_model_id, preferred_date, preferred_time, city, message, ip_address) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            $stmt->execute([
                $data['full_name'],
                $data['email'],
                $data['phone'],
                $data['car_model_id'] ?: null,
                $data['preferred_date'],
                $data['preferred_time'],
                $data['city'],
                $data['message'],
                $_SERVER['REMOTE_ADDR']
            ]);
            
            $success = true;
            $data = []; // Clear form data
            
            // Send notification email (you would implement this)
            // sendTestDriveNotification($data);
            
        } catch (PDOException $e) {
            $errors[] = 'Database error: ' . $e->getMessage();
        }
    }
}

// Fetch car models for dropdown
$stmt = $conn->prepare("SELECT id, model_name FROM car_models WHERE status = 'active' ORDER BY model_name");
$stmt->execute();
$carModels = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Test Drive | LUXURY AUTO</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <section class="hero-section mini-hero">
        <div class="hero-video-container">
            <video autoplay muted loop playsinline class="hero-video">
                <source src="assets/videos/test-drive-hero.mp4" type="video/mp4">
            </video>
            <div class="video-overlay"></div>
        </div>
        
        <div class="hero-content">
            <h1 class="hero-title">Experience Excellence</h1>
            <p class="hero-subtitle">Book your personal test drive today</p>
        </div>
    </section>
    
    <section class="section">
        <div class="container">
            <div class="booking-container">
                <div class="booking-form-wrapper" data-aos="fade-up">
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-error">
                            <h4>Please correct the following:</h4>
                            <ul>
                                <?php foreach ($errors as $error): ?>
                                    <li><?php echo htmlspecialchars($error); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($success) && $success): ?>
                        <div class="alert alert-success" data-aos="fade-up">
                            <h3><i class="fas fa-check-circle"></i> Thank You!</h3>
                            <p>Your test drive request has been submitted successfully. Our representative will contact you within 24 hours to confirm your appointment.</p>
                            <a href="index.php" class="btn-primary">Back to Home</a>
                        </div>
                    <?php else: ?>
                    
                    <form method="POST" class="booking-form" id="testDriveForm">
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="full_name">Full Name *</label>
                                <input type="text" id="full_name" name="full_name" 
                                       value="<?php echo htmlspecialchars($data['full_name'] ?? ''); ?>" 
                                       required>
                            </div>
                            
                            <div class="form-group">
                                <label for="email">Email Address *</label>
                                <input type="email" id="email" name="email" 
                                       value="<?php echo htmlspecialchars($data['email'] ?? ''); ?>" 
                                       required>
                            </div>
                            
                            <div class="form-group">
                                <label for="phone">Phone Number *</label>
                                <input type="tel" id="phone" name="phone" 
                                       value="<?php echo htmlspecialchars($data['phone'] ?? ''); ?>" 
                                       required>
                            </div>
                            
                            <div class="form-group">
                                <label for="car_model">Preferred Model</label>
                                <select id="car_model" name="car_model">
                                    <option value="">Select a model</option>
                                    <?php foreach ($carModels as $model): ?>
                                        <option value="<?php echo $model['id']; ?>"
                                            <?php echo ($data['car_model_id'] ?? '') == $model['id'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($model['model_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="city">City *</label>
                                <input type="text" id="city" name="city" 
                                       value="<?php echo htmlspecialchars($data['city'] ?? ''); ?>" 
                                       required>
                            </div>
                            
                            <div class="form-group">
                                <label for="preferred_date">Preferred Date *</label>
                                <input type="date" id="preferred_date" name="preferred_date" 
                                       value="<?php echo htmlspecialchars($data['preferred_date'] ?? ''); ?>" 
                                       min="<?php echo date('Y-m-d'); ?>" 
                                       required>
                            </div>
                            
                            <div class="form-group">
                                <label for="preferred_time">Preferred Time</label>
                                <select id="preferred_time" name="preferred_time">
                                    <option value="">Select time</option>
                                    <option value="09:00" <?php echo ($data['preferred_time'] ?? '') == '09:00' ? 'selected' : ''; ?>>09:00 AM</option>
                                    <option value="10:00" <?php echo ($data['preferred_time'] ?? '') == '10:00' ? 'selected' : ''; ?>>10:00 AM</option>
                                    <option value="11:00" <?php echo ($data['preferred_time'] ?? '') == '11:00' ? 'selected' : ''; ?>>11:00 AM</option>
                                    <option value="13:00" <?php echo ($data['preferred_time'] ?? '') == '13:00' ? 'selected' : ''; ?>>01:00 PM</option>
                                    <option value="14:00" <?php echo ($data['preferred_time'] ?? '') == '14:00' ? 'selected' : ''; ?>>02:00 PM</option>
                                    <option value="15:00" <?php echo ($data['preferred_time'] ?? '') == '15:00' ? 'selected' : ''; ?>>03:00 PM</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="message">Additional Notes</label>
                            <textarea id="message" name="message" rows="4"><?php echo htmlspecialchars($data['message'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="form-submit">
                            <button type="submit" class="btn-primary btn-large">
                                <i class="fas fa-paper-plane"></i> Submit Request
                            </button>
                        </div>
                    </form>
                    <?php endif; ?>
                </div>
                
                <div class="booking-info" data-aos="fade-left" data-aos-delay="300">
                    <h3>What to Expect</h3>
                    <div class="info-points">
                        <div class="info-point">
                            <i class="fas fa-user-tie"></i>
                            <div>
                                <h4>Personal Consultation</h4>
                                <p>One-on-one time with our product specialist</p>
                            </div>
                        </div>
                        <div class="info-point">
                            <i class="fas fa-route"></i>
                            <div>
                                <h4>Custom Route</h4>
                                <p>Tailored driving route to experience the vehicle's capabilities</p>
                            </div>
                        </div>
                        <div class="info-point">
                            <i class="fas fa-clock"></i>
                            <div>
                                <h4>90 Minutes</h4>
                                <p>Comprehensive test drive experience</p>
                            </div>
                        </div>
                        <div class="info-point">
                            <i class="fas fa-chart-line"></i>
                            <div>
                                <h4>Performance Demo</h4>
                                <p>Experience acceleration, handling, and innovative features</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="contact-info-box">
                        <h4>Need Immediate Assistance?</h4>
                        <p><i class="fas fa-phone"></i> +1 (888) LUX-AUTO</p>
                        <p><i class="fas fa-envelope"></i> testdrive@luxuryauto.com</p>
                        <p><i class="fas fa-clock"></i> Mon-Sat: 9AM-7PM, Sun: 10AM-5PM</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <?php include 'includes/footer.php'; ?>
    
    <script>
        // Form validation
        document.getElementById('testDriveForm').addEventListener('submit', function(e) {
            const date = new Date(document.getElementById('preferred_date').value);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            if (date < today) {
                e.preventDefault();
                alert('Please select a future date for your test drive.');
                return false;
            }
            
            // Additional validation can be added here
            return true;
        });
    </script>
</body>
</html>