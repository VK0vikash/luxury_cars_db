<?php
// Emergency database connection fix
error_reporting(E_ALL);
ini_set('display_errors', 1);

class EmergencyDB {
    private static $connection = null;
    
    public static function getConnection() {
        if (self::$connection === null) {
            // Try multiple connection methods
            $attempts = [
                ['dsn' => 'mysql:host=localhost;dbname=luxury_cars_db;charset=utf8mb4', 'user' => 'root', 'pass' => ''],
                ['dsn' => 'mysql:host=127.0.0.1;dbname=luxury_cars_db;charset=utf8mb4', 'user' => 'root', 'pass' => ''],
                ['dsn' => 'mysql:host=localhost;dbname=luxury_cars_db;charset=utf8mb4', 'user' => 'root', 'pass' => 'root'],
                // Try without database first
                ['dsn' => 'mysql:host=localhost;charset=utf8mb4', 'user' => 'root', 'pass' => ''],
            ];
            
            foreach ($attempts as $attempt) {
                try {
                    self::$connection = new PDO(
                        $attempt['dsn'],
                        $attempt['user'],
                        $attempt['pass'],
                        [
                            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                            PDO::ATTR_EMULATE_PREPARES => false
                        ]
                    );
                    
                    echo "<!-- Connected successfully using: " . $attempt['user'] . "@localhost -->\n";
                    return self::$connection;
                    
                } catch(PDOException $e) {
                    echo "<!-- Connection failed: " . $e->getMessage() . " -->\n";
                    continue;
                }
            }
            
            // If all attempts failed
            die("
                <div style='padding: 20px; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px;'>
                    <h3>Database Connection Error</h3>
                    <p>Cannot connect to MySQL database. Please check:</p>
                    <ol>
                        <li>MySQL service is running in XAMPP</li>
                        <li>Database 'luxury_cars_db' exists</li>
                        <li>Username/password are correct (default: root/empty)</li>
                        <li>Check includes/config.php settings</li>
                    </ol>
                    <p><a href='http://localhost/phpmyadmin' target='_blank'>Open phpMyAdmin</a></p>
                </div>
            ");
        }
        
        return self::$connection;
    }
}

// Test connection
$conn = EmergencyDB::getConnection();
?>