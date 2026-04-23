<?php
echo "<h2>Testing Database Connection</h2>";

// Try different configurations
$configs = [
    ['host' => 'localhost', 'user' => 'root', 'pass' => ''],
    ['host' => '127.0.0.1', 'user' => 'root', 'pass' => ''],
    ['host' => 'localhost', 'user' => 'root', 'pass' => 'root'],
    ['host' => 'localhost', 'user' => 'admin', 'pass' => ''],
];

foreach ($configs as $config) {
    echo "Trying: {$config['user']}@{$config['host']}... ";
    
    try {
        $conn = new PDO(
            "mysql:host={$config['host']};dbname=luxury_cars_db",
            $config['user'],
            $config['pass']
        );
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "<span style='color: green;'>SUCCESS!</span><br>";
        
        // Show database info
        $stmt = $conn->query("SELECT DATABASE() as db, USER() as user");
        $result = $stmt->fetch();
        echo "Connected to: " . $result['db'] . " as " . $result['user'] . "<br>";
        break;
        
    } catch(PDOException $e) {
        echo "<span style='color: red;'>FAILED: " . $e->getMessage() . "</span><br>";
    }
}

echo "<hr>";
echo "<h3>Checking MySQL Status:</h3>";

// Check if MySQL service is running
if (function_exists('mysqli_connect')) {
    echo "MySQL extension is loaded<br>";
} else {
    echo "MySQL extension is NOT loaded<br>";
}

// Try to connect without database
try {
    $conn = new PDO("mysql:host=localhost", "root", "");
    echo "Can connect to MySQL server<br>";
} catch(PDOException $e) {
    echo "Cannot connect to MySQL server: " . $e->getMessage() . "<br>";
}

// Check if database exists
try {
    $conn = new PDO("mysql:host=localhost", "root", "");
    $stmt = $conn->query("SHOW DATABASES LIKE 'luxury_cars_db'");
    if ($stmt->rowCount() > 0) {
        echo "Database 'luxury_cars_db' exists<br>";
    } else {
        echo "Database 'luxury_cars_db' does NOT exist<br>";
    }
} catch(PDOException $e) {
    echo "Error checking databases: " . $e->getMessage() . "<br>";
}
?>