<?php
// includes/header.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LUXURY AUTO</title>
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
        
        /* Active link */
        .nav-links a.active {
            color: #d4af37;
            border-bottom: 2px solid #d4af37;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="logo">LUXURY <span>AUTO</span></div>
        <div class="nav-links">
            <a href="index.php" <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'class="active"' : ''; ?>>Home</a>
            <a href="models.php" <?php echo basename($_SERVER['PHP_SELF']) == 'models.php' ? 'class="active"' : ''; ?>>Models</a>
            <a href="performance.php" <?php echo basename($_SERVER['PHP_SELF']) == 'performance.php' ? 'class="active"' : ''; ?>>Performance</a>
            <a href="brand.php" <?php echo basename($_SERVER['PHP_SELF']) == 'brand.php' ? 'class="active"' : ''; ?>>Brand</a>
            <a href="news.php" <?php echo basename($_SERVER['PHP_SELF']) == 'news.php' ? 'class="active"' : ''; ?>>News</a>
            <a href="contact.php" <?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'class="active"' : ''; ?>>Contact</a>
        </div>
    </nav>
    
    <!-- Spacer for fixed navbar -->
    <div style="height: 80px;"></div>