<?php
// Database Configuration for XAMPP
define('DB_HOST', 'localhost');
define('DB_NAME', 'luxury_cars_db');
define('DB_USER', 'root');      // XAMPP default username
define('DB_PASS', '');          // XAMPP default password (empty)

// Site Configuration
define('SITE_NAME', 'LUXURY AUTO');
define('SITE_URL', 'http://localhost/luxury-car-website');
define('ADMIN_EMAIL', 'admin@luxuryauto.com');

// File Upload Paths
define('UPLOAD_PATH', $_SERVER['DOCUMENT_ROOT'] . '/luxury-car-website/assets/uploads/');
define('UPLOAD_URL', SITE_URL . '/assets/uploads/');
?>