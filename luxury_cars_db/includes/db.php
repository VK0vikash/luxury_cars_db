<?php
$host = 'localhost';
$dbname = 'luxury_cars_db'; // Your database name
$username = 'root'; // XAMPP default
$password = ''; // XAMPP default

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
<?php
session_start();
require_once 'config.php';

class Database {
    private $conn;
    
    public function __construct() {
        try {
            $this->conn = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
    
    public function getConnection() {
        return $this->conn;
    }
}

// Create tables if not exists
function createTables($conn) {
    $queries = [
        "CREATE TABLE IF NOT EXISTS admins (
            id INT PRIMARY KEY AUTO_INCREMENT,
            username VARCHAR(50) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            email VARCHAR(100) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )",
        
        "CREATE TABLE IF NOT EXISTS car_models (
            id INT PRIMARY KEY AUTO_INCREMENT,
            model_name VARCHAR(100) NOT NULL,
            tagline VARCHAR(200),
            description TEXT,
            base_price DECIMAL(12,2),
            featured BOOLEAN DEFAULT 0,
            status ENUM('active', 'upcoming', 'discontinued') DEFAULT 'active',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )",
        
        "CREATE TABLE IF NOT EXISTS car_images (
            id INT PRIMARY KEY AUTO_INCREMENT,
            car_id INT NOT NULL,
            image_path VARCHAR(255) NOT NULL,
            image_type ENUM('exterior', 'interior', 'hero', 'gallery') DEFAULT 'gallery',
            alt_text VARCHAR(200),
            sort_order INT DEFAULT 0,
            FOREIGN KEY (car_id) REFERENCES car_models(id) ON DELETE CASCADE
        )",
        
        "CREATE TABLE IF NOT EXISTS car_specs (
            id INT PRIMARY KEY AUTO_INCREMENT,
            car_id INT NOT NULL,
            engine_type VARCHAR(100),
            horsepower INT,
            torque INT,
            acceleration_0_100 DECIMAL(4,2),
            top_speed INT,
            transmission VARCHAR(50),
            fuel_type VARCHAR(50),
            fuel_economy VARCHAR(50),
            FOREIGN KEY (car_id) REFERENCES car_models(id) ON DELETE CASCADE
        )",
        
        "CREATE TABLE IF NOT EXISTS car_features (
            id INT PRIMARY KEY AUTO_INCREMENT,
            car_id INT NOT NULL,
            feature_type ENUM('safety', 'technology', 'comfort', 'performance') DEFAULT 'technology',
            feature_name VARCHAR(100) NOT NULL,
            description TEXT,
            icon VARCHAR(50),
            FOREIGN KEY (car_id) REFERENCES car_models(id) ON DELETE CASCADE
        )",
        
        "CREATE TABLE IF NOT EXISTS color_variants (
            id INT PRIMARY KEY AUTO_INCREMENT,
            car_id INT NOT NULL,
            color_name VARCHAR(50) NOT NULL,
            color_code VARCHAR(7) NOT NULL,
            price_adjustment DECIMAL(8,2) DEFAULT 0,
            available BOOLEAN DEFAULT 1,
            FOREIGN KEY (car_id) REFERENCES car_models(id) ON DELETE CASCADE
        )",
        
        "CREATE TABLE IF NOT EXISTS brochures (
            id INT PRIMARY KEY AUTO_INCREMENT,
            car_id INT NOT NULL,
            file_path VARCHAR(255) NOT NULL,
            file_size INT,
            language VARCHAR(10) DEFAULT 'en',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (car_id) REFERENCES car_models(id) ON DELETE CASCADE
        )",
        
        "CREATE TABLE IF NOT EXISTS blog_posts (
            id INT PRIMARY KEY AUTO_INCREMENT,
            title VARCHAR(200) NOT NULL,
            slug VARCHAR(220) UNIQUE NOT NULL,
            excerpt TEXT,
            content LONGTEXT,
            featured_image VARCHAR(255),
            category ENUM('news', 'launch', 'event', 'technology') DEFAULT 'news',
            author VARCHAR(100),
            status ENUM('draft', 'published') DEFAULT 'draft',
            views INT DEFAULT 0,
            published_at TIMESTAMP NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )",
        
        "CREATE TABLE IF NOT EXISTS test_drive_requests (
            id INT PRIMARY KEY AUTO_INCREMENT,
            full_name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL,
            phone VARCHAR(20) NOT NULL,
            car_model_id INT,
            preferred_date DATE,
            preferred_time TIME,
            city VARCHAR(50),
            message TEXT,
            status ENUM('pending', 'confirmed', 'completed', 'cancelled') DEFAULT 'pending',
            submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (car_model_id) REFERENCES car_models(id)
        )",
        
        "CREATE TABLE IF NOT EXISTS contact_messages (
            id INT PRIMARY KEY AUTO_INCREMENT,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL,
            subject VARCHAR(200),
            message TEXT NOT NULL,
            ip_address VARCHAR(45),
            read_status BOOLEAN DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )"
    ];
    
    foreach ($queries as $query) {
        try {
            $conn->exec($query);
        } catch(PDOException $e) {
            // Table might already exist
        }
    }
    
    // Create default admin if not exists
    $stmt = $conn->prepare("SELECT COUNT(*) FROM admins");
    $stmt->execute();
    if($stmt->fetchColumn() == 0) {
        $password = password_hash('admin123', PASSWORD_DEFAULT);
        $conn->exec("INSERT INTO admins (username, password, email) VALUES ('admin', '$password', 'admin@luxuryauto.com')");
    }
}

// Initialize database
$database = new Database();
$conn = $database->getConnection();
createTables($conn);
?>