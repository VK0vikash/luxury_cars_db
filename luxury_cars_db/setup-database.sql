-- Create database if not exists
CREATE DATABASE IF NOT EXISTS `luxury_cars_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `luxury_cars_db`;

-- Drop tables if they exist (for clean setup)
DROP TABLE IF EXISTS `contact_messages`;
DROP TABLE IF EXISTS `test_drive_requests`;
DROP TABLE IF EXISTS `blog_posts`;
DROP TABLE IF EXISTS `brochures`;
DROP TABLE IF EXISTS `color_variants`;
DROP TABLE IF EXISTS `car_features`;
DROP TABLE IF EXISTS `car_images`;
DROP TABLE IF EXISTS `car_specs`;
DROP TABLE IF EXISTS `car_models`;
DROP TABLE IF EXISTS `admins`;

-- Table structure for table `admins`
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `car_models`
CREATE TABLE IF NOT EXISTS `car_models` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `model_name` varchar(100) NOT NULL,
  `tagline` varchar(200) DEFAULT NULL,
  `description` text,
  `base_price` decimal(12,2) DEFAULT NULL,
  `featured` tinyint(1) DEFAULT '0',
  `status` enum('active','upcoming','discontinued') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `car_images`
CREATE TABLE IF NOT EXISTS `car_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `car_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `image_type` enum('exterior','interior','hero','gallery') DEFAULT 'gallery',
  `alt_text` varchar(200) DEFAULT NULL,
  `sort_order` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `car_id` (`car_id`),
  CONSTRAINT `car_images_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `car_models` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `car_specs`
CREATE TABLE IF NOT EXISTS `car_specs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `car_id` int(11) NOT NULL,
  `engine_type` varchar(100) DEFAULT NULL,
  `horsepower` int(11) DEFAULT NULL,
  `torque` int(11) DEFAULT NULL,
  `acceleration_0_100` decimal(4,2) DEFAULT NULL,
  `top_speed` int(11) DEFAULT NULL,
  `transmission` varchar(50) DEFAULT NULL,
  `fuel_type` varchar(50) DEFAULT NULL,
  `fuel_economy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `car_id` (`car_id`),
  CONSTRAINT `car_specs_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `car_models` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `car_features`
CREATE TABLE IF NOT EXISTS `car_features` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `car_id` int(11) NOT NULL,
  `feature_type` enum('safety','technology','comfort','performance') DEFAULT 'technology',
  `feature_name` varchar(100) NOT NULL,
  `description` text,
  `icon` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `car_id` (`car_id`),
  CONSTRAINT `car_features_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `car_models` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `color_variants`
CREATE TABLE IF NOT EXISTS `color_variants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `car_id` int(11) NOT NULL,
  `color_name` varchar(50) NOT NULL,
  `color_code` varchar(7) NOT NULL,
  `price_adjustment` decimal(8,2) DEFAULT '0.00',
  `available` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `car_id` (`car_id`),
  CONSTRAINT `color_variants_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `car_models` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `brochures`
CREATE TABLE IF NOT EXISTS `brochures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `car_id` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_size` int(11) DEFAULT NULL,
  `language` varchar(10) DEFAULT 'en',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `car_id` (`car_id`),
  CONSTRAINT `brochures_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `car_models` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `blog_posts`
CREATE TABLE IF NOT EXISTS `blog_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `slug` varchar(220) NOT NULL,
  `excerpt` text,
  `content` longtext,
  `featured_image` varchar(255) DEFAULT NULL,
  `category` enum('news','launch','event','technology') DEFAULT 'news',
  `author` varchar(100) DEFAULT NULL,
  `status` enum('draft','published') DEFAULT 'draft',
  `views` int(11) DEFAULT '0',
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `test_drive_requests`
CREATE TABLE IF NOT EXISTS `test_drive_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `car_model_id` int(11) DEFAULT NULL,
  `preferred_date` date DEFAULT NULL,
  `preferred_time` time DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `message` text,
  `status` enum('pending','confirmed','completed','cancelled') DEFAULT 'pending',
  `submitted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `car_model_id` (`car_model_id`),
  CONSTRAINT `test_drive_requests_ibfk_1` FOREIGN KEY (`car_model_id`) REFERENCES `car_models` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `contact_messages`
CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `message` text NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `read_status` tinyint(1) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample data
-- Admin user (password: admin123)
INSERT INTO `admins` (`username`, `password`, `email`) VALUES
('admin', '$2y$10$I5B2jZ4k8Hq9RfT7Yv6WxO3nP4mQ1A2C3E5G7I9K0M2N4L6P8R0T2V4X6Z8B', 'admin@luxuryauto.com');

-- Car Models
INSERT INTO `car_models` (`model_name`, `tagline`, `description`, `base_price`, `featured`, `status`) VALUES
('AUREUM GT', 'The Pinnacle of Performance', 'Experience unparalleled luxury and breathtaking performance in our flagship grand tourer.', 285000.00, 1, 'active'),
('VENTURA SUV', 'Adventure Redefined', 'Luxury meets capability in our premium sport utility vehicle.', 195000.00, 1, 'active'),
('SERENITY SEDAN', 'Elegance in Motion', 'Executive sedan with state-of-the-art technology and comfort features.', 165000.00, 1, 'active'),
('VELOCE SPORT', 'Pure Adrenaline', 'Track-inspired performance with daily driving refinement.', 325000.00, 0, 'upcoming');

-- Car Specifications
INSERT INTO `car_specs` (`car_id`, `engine_type`, `horsepower`, `torque`, `acceleration_0_100`, `top_speed`, `transmission`, `fuel_type`, `fuel_economy`) VALUES
(1, '6.0L V12 Twin-Turbo', 750, 1000, 3.20, 350, '8-Speed Automatic', 'Premium Unleaded', '15 City / 22 Highway'),
(2, '4.0L V8 Biturbo', 550, 770, 4.50, 250, '9-Speed Automatic', 'Premium Unleaded', '18 City / 24 Highway'),
(3, '3.0L V6 Hybrid', 450, 600, 5.20, 230, '8-Speed Automatic', 'Hybrid', '25 City / 30 Highway'),
(4, '5.2L V10 Naturally Aspirated', 850, 900, 2.90, 380, '7-Speed Dual-Clutch', 'Premium Unleaded', '12 City / 18 Highway');

-- Car Features
INSERT INTO `car_features` (`car_id`, `feature_type`, `feature_name`, `description`, `icon`) VALUES
(1, 'safety', 'Intelligent Collision Avoidance', 'Advanced AI predicts and prevents potential collisions', 'shield-alt'),
(1, 'technology', 'Augmented Reality HUD', 'Projects navigation and vehicle data onto windshield', 'glasses'),
(1, 'comfort', 'Executive Lounge Seats', 'Massaging seats with 24-way power adjustment', 'couch'),
(1, 'performance', 'Active Aero System', 'Adaptive aerodynamics for optimal downforce', 'wind'),
(2, 'safety', '360° Camera System', 'Complete surround view for parking and maneuvering', 'camera'),
(2, 'technology', 'Night Vision Assistant', 'Infrared system for enhanced nighttime visibility', 'moon'),
(2, 'comfort', 'Four-Zone Climate Control', 'Individual temperature settings for all passengers', 'snowflake'),
(3, 'technology', 'Gesture Control', 'Control infotainment with hand gestures', 'hand-pointer'),
(3, 'comfort', 'Executive Rear Package', 'Rear seat entertainment and business features', 'chair');

-- Color Variants
INSERT INTO `color_variants` (`car_id`, `color_name`, `color_code`, `price_adjustment`, `available`) VALUES
(1, 'Midnight Obsidian', '#0A0A0A', 0.00, 1),
(1, 'Platinum Silver', '#C0C0C0', 2500.00, 1),
(1, 'Royal Burgundy', '#800020', 3500.00, 1),
(1, 'Golden Ambition', '#D4AF37', 5000.00, 1),
(2, 'Glacier White', '#FFFFFF', 0.00, 1),
(2, 'Forest Green', '#228B22', 2000.00, 1),
(2, 'Ocean Blue', '#1E90FF', 2000.00, 1);

-- Blog Posts
INSERT INTO `blog_posts` (`title`, `slug`, `excerpt`, `content`, `category`, `author`, `status`, `published_at`) VALUES
('New Aureum GT Receives Design Award', 'aureum-gt-design-award', 'Our flagship model recognized for exceptional design excellence at the International Automotive Awards.', '<p>The AUREUM GT has been awarded the prestigious Golden Wheel Award for Best Design at the International Automotive Awards ceremony held in Geneva.</p>', 'news', 'Editorial Team', 'published', NOW()),
('Sustainable Luxury Initiative', 'sustainable-luxury', 'Announcing our commitment to carbon-neutral manufacturing by 2030.', '<p>Luxury Auto is proud to announce our ambitious sustainability roadmap aiming for carbon-neutral manufacturing processes by 2030.</p>', 'technology', 'CEO Office', 'published', NOW()),
('New Flagship Showroom Opening in Dubai', 'dubai-showroom-opening', 'Experience the future of automotive luxury at our new Dubai flagship location.', '<p>Our newest flagship showroom in Downtown Dubai offers an immersive brand experience with state-of-the-art facilities.</p>', 'event', 'Marketing Team', 'published', NOW());

-- Display success message
SELECT 'Database setup completed successfully!' AS message;