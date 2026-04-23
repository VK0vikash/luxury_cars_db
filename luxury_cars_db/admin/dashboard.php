<?php
session_start();
require_once '../includes/db.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Get dashboard statistics
try {
    // Test drive requests
    $stmt = $conn->query("SELECT COUNT(*) as total, 
                                  SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending 
                           FROM test_drive_requests");
    $testDriveStats = $stmt->fetch();
    
    // Car models
    $stmt = $conn->query("SELECT COUNT(*) as total FROM car_models");
    $carModelStats = $stmt->fetch();
    
    // Blog posts
    $stmt = $conn->query("SELECT COUNT(*) as total FROM blog_posts WHERE status = 'published'");
    $blogStats = $stmt->fetch();
    
    // Recent test drive requests
    $stmt = $conn->query("
        SELECT tdr.*, cm.model_name 
        FROM test_drive_requests tdr 
        LEFT JOIN car_models cm ON tdr.car_model_id = cm.id 
        ORDER BY submitted_at DESC 
        LIMIT 5
    ");
    $recentRequests = $stmt->fetchAll();
    
    // Recent contact messages
    $stmt = $conn->query("SELECT * FROM contact_messages ORDER BY created_at DESC LIMIT 5");
    $recentMessages = $stmt->fetchAll();
    
} catch(PDOException $e) {
    $error = "Database error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | LUXURY AUTO</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        :root {
            --primary: #D4AF37;
            --primary-dark: #B8941F;
            --dark: #0A0A0A;
            --dark-light: #1A1A1A;
            --light: #FFFFFF;
            --light-secondary: #B0B0B0;
            --success: #28a745;
            --warning: #ffc107;
            --danger: #dc3545;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--dark);
            color: var(--light);
            line-height: 1.6;
        }
        
        .admin-container {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .admin-sidebar {
            width: 250px;
            background: var(--dark-light);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }
        
        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .admin-logo {
            color: var(--primary);
            font-size: 1.5rem;
            font-weight: 700;
            text-decoration: none;
            display: block;
            margin-bottom: 0.5rem;
        }
        
        .admin-subtitle {
            color: var(--light-secondary);
            font-size: 0.9rem;
        }
        
        .sidebar-menu {
            padding: 1rem 0;
        }
        
        .menu-item {
            display: block;
            padding: 0.8rem 1.5rem;
            color: var(--light-secondary);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }
        
        .menu-item:hover,
        .menu-item.active {
            background: rgba(212, 175, 55, 0.1);
            color: var(--primary);
            border-left-color: var(--primary);
        }
        
        .menu-item i {
            width: 20px;
            margin-right: 10px;
        }
        
        .menu-divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
            margin: 1rem 0;
        }
        
        .sidebar-footer {
            padding: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            position: absolute;
            bottom: 0;
            width: 100%;
        }
        
        /* Main Content */
        .admin-main {
            flex: 1;
            margin-left: 250px;
            padding: 2rem;
        }
        
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .admin-avatar {
            width: 40px;
            height: 40px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: var(--dark);
        }
        
        /* Dashboard Stats */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: var(--dark-light);
            border-radius: 10px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary);
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        
        .stat-icon.primary {
            background: rgba(212, 175, 55, 0.2);
            color: var(--primary);
        }
        
        .stat-icon.success {
            background: rgba(40, 167, 69, 0.2);
            color: var(--success);
        }
        
        .stat-icon.warning {
            background: rgba(255, 193, 7, 0.2);
            color: var(--warning);
        }
        
        .stat-icon.danger {
            background: rgba(220, 53, 69, 0.2);
            color: var(--danger);
        }
        
        .stat-content h3 {
            font-size: 2rem;
            margin-bottom: 0.2rem;
        }
        
        .stat-content p {
            color: var(--light-secondary);
            font-size: 0.9rem;
        }
        
        /* Tables */
        .dashboard-section {
            margin-bottom: 3rem;
        }
        
        .section-title {
            font-size: 1.3rem;
            margin-bottom: 1rem;
            color: var(--light);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .dashboard-table {
            background: var(--dark-light);
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .table-responsive {
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        thead {
            background: rgba(0, 0, 0, 0.3);
        }
        
        th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: var(--light-secondary);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        td {
            padding: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        tbody tr:hover {
            background: rgba(255, 255, 255, 0.05);
        }
        
        .status-badge {
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .status-pending {
            background: rgba(255, 193, 7, 0.2);
            color: var(--warning);
        }
        
        .status-confirmed {
            background: rgba(40, 167, 69, 0.2);
            color: var(--success);
        }
        
        .status-completed {
            background: rgba(0, 123, 255, 0.2);
            color: #007bff;
        }
        
        .btn-action {
            padding: 0.3rem 0.8rem;
            border-radius: 5px;
            border: none;
            background: transparent;
            color: var(--light);
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }
        
        .btn-view {
            background: var(--primary);
            color: var(--dark);
        }
        
        .btn-view:hover {
            background: var(--primary-dark);
        }
        
        .btn-delete {
            background: var(--danger);
            color: var(--light);
        }
        
        .btn-delete:hover {
            background: #c82333;
        }
        
        /* Alert Messages */
        .alert {
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1.5rem;
            border: 1px solid transparent;
        }
        
        .alert-success {
            background: rgba(40, 167, 69, 0.2);
            border-color: var(--success);
            color: #d4edda;
        }
        
        .alert-error {
            background: rgba(220, 53, 69, 0.2);
            border-color: var(--danger);
            color: #f8d7da;
        }
        
        /* Quick Actions */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 2rem;
        }
        
        .action-card {
            background: var(--dark-light);
            padding: 1.5rem;
            border-radius: 10px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            text-decoration: none;
            color: var(--light);
            display: block;
        }
        
        .action-card:hover {
            border-color: var(--primary);
            transform: translateY(-3px);
        }
        
        .action-card i {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }
        
        .action-card h4 {
            margin-bottom: 0.5rem;
        }
        
        .action-card p {
            color: var(--light-secondary);
            font-size: 0.9rem;
        }
        
        /* Logout Button */
        .btn-logout {
            background: transparent;
            border: 1px solid var(--danger);
            color: var(--danger);
            padding: 0.5rem 1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-logout:hover {
            background: var(--danger);
            color: var(--light);
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <a href="dashboard.php" class="admin-logo">LUXURY AUTO</a>
                <div class="admin-subtitle">Admin Panel</div>
            </div>
            
            <nav class="sidebar-menu">
                <a href="dashboard.php" class="menu-item active">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                
                <div class="menu-divider"></div>
                
                <a href="car-models.php" class="menu-item">
                    <i class="fas fa-car"></i> Car Models
                </a>
                <a href="car-specs.php" class="menu-item">
                    <i class="fas fa-cogs"></i> Specifications
                </a>
                <a href="car-gallery.php" class="menu-item">
                    <i class="fas fa-images"></i> Gallery
                </a>
                <a href="car-features.php" class="menu-item">
                    <i class="fas fa-star"></i> Features
                </a>
                
                <div class="menu-divider"></div>
                
                <a href="test-drives.php" class="menu-item">
                    <i class="fas fa-calendar-alt"></i> Test Drives
                    <?php if($testDriveStats['pending'] > 0): ?>
                    <span class="badge"><?php echo $testDriveStats['pending']; ?></span>
                    <?php endif; ?>
                </a>
                <a href="contact-messages.php" class="menu-item">
                    <i class="fas fa-envelope"></i> Messages
                    <?php if(count($recentMessages) > 0): ?>
                    <span class="badge"><?php echo count($recentMessages); ?></span>
                    <?php endif; ?>
                </a>
                <a href="blog-posts.php" class="menu-item">
                    <i class="fas fa-newspaper"></i> Blog Posts
                </a>
                
                <div class="menu-divider"></div>
                
                <a href="settings.php" class="menu-item">
                    <i class="fas fa-cog"></i> Settings
                </a>
                <a href="admins.php" class="menu-item">
                    <i class="fas fa-users"></i> Administrators
                </a>
            </nav>
            
            <div class="sidebar-footer">
                <div class="admin-info">
                    <div class="admin-avatar">
                        <?php echo strtoupper(substr($_SESSION['admin_username'], 0, 1)); ?>
                    </div>
                    <div style="margin-top: 0.5rem;">
                        <strong><?php echo htmlspecialchars($_SESSION['admin_username']); ?></strong>
                        <br>
                        <small style="color: var(--light-secondary);">Administrator</small>
                    </div>
                </div>
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="admin-main">
            <header class="admin-header">
                <h1>Dashboard</h1>
                <div class="header-actions">
                    <span>Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?></span>
                    <a href="logout.php" class="btn-logout">Logout</a>
                </div>
            </header>
            
            <?php if(isset($error)): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon primary">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?php echo $testDriveStats['total']; ?></h3>
                        <p>Test Drive Requests</p>
                        <?php if($testDriveStats['pending'] > 0): ?>
                        <small style="color: var(--warning);"><?php echo $testDriveStats['pending']; ?> pending</small>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon success">
                        <i class="fas fa-car"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?php echo $carModelStats['total']; ?></h3>
                        <p>Car Models</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon warning">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?php echo $blogStats['total']; ?></h3>
                        <p>Blog Posts</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon danger">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?php echo count($recentMessages); ?></h3>
                        <p>New Messages</p>
                    </div>
                </div>
            </div>
            
            <!-- Recent Test Drive Requests -->
            <div class="dashboard-section">
                <h2 class="section-title">
                    <i class="fas fa-calendar-alt"></i> Recent Test Drive Requests
                </h2>
                
                <div class="dashboard-table">
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Model</th>
                                    <th>Date & Time</th>
                                    <th>City</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($recentRequests as $request): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($request['full_name']); ?></td>
                                    <td><?php echo $request['model_name'] ? htmlspecialchars($request['model_name']) : 'Not specified'; ?></td>
                                    <td>
                                        <?php echo date('M d, Y', strtotime($request['preferred_date'])); ?>
                                        <?php if($request['preferred_time']): ?>
                                        <br><small><?php echo date('h:i A', strtotime($request['preferred_time'])); ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($request['city']); ?></td>
                                    <td>
                                        <span class="status-badge status-<?php echo $request['status']; ?>">
                                            <?php echo ucfirst($request['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn-action btn-view">
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                        <button class="btn-action btn-delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div style="text-align: right; margin-top: 1rem;">
                    <a href="test-drives.php" class="btn-action btn-view">View All Requests</a>
                </div>
            </div>
            
            <!-- Recent Contact Messages -->
            <div class="dashboard-section">
                <h2 class="section-title">
                    <i class="fas fa-envelope"></i> Recent Contact Messages
                </h2>
                
                <div class="dashboard-table">
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Subject</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($recentMessages as $message): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($message['name']); ?></td>
                                    <td><?php echo htmlspecialchars($message['email']); ?></td>
                                    <td><?php echo htmlspecialchars($message['subject'] ?? 'No subject'); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($message['created_at'])); ?></td>
                                    <td>
                                        <?php if($message['read_status']): ?>
                                        <span class="status-badge status-completed">Read</span>
                                        <?php else: ?>
                                        <span class="status-badge status-pending">Unread</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button class="btn-action btn-view">
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                        <button class="btn-action btn-delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div style="text-align: right; margin-top: 1rem;">
                    <a href="contact-messages.php" class="btn-action btn-view">View All Messages</a>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="dashboard-section">
                <h2 class="section-title">
                    <i class="fas fa-bolt"></i> Quick Actions
                </h2>
                
                <div class="quick-actions">
                    <a href="car-models.php?action=add" class="action-card">
                        <i class="fas fa-plus-circle"></i>
                        <h4>Add New Car Model</h4>
                        <p>Create a new car model entry</p>
                    </a>
                    
                    <a href="blog-posts.php?action=add" class="action-card">
                        <i class="fas fa-edit"></i>
                        <h4>Write Blog Post</h4>
                        <p>Create new blog content</p>
                    </a>
                    
                    <a href="settings.php" class="action-card">
                        <i class="fas fa-cog"></i>
                        <h4>Site Settings</h4>
                        <p>Update website configuration</p>
                    </a>
                    
                    <a href="admins.php?action=add" class="action-card">
                        <i class="fas fa-user-plus"></i>
                        <h4>Add Admin User</h4>
                        <p>Create new administrator account</p>
                    </a>
                </div>
            </div>
        </main>
    </div>
    
    <script>
        // Update status badges dynamically
        document.addEventListener('DOMContentLoaded', function() {
            // Add badge styles
            const style = document.createElement('style');
            style.textContent = `
                .badge {
                    background: var(--danger);
                    color: white;
                    border-radius: 50%;
                    width: 20px;
                    height: 20px;
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 0.7rem;
                    margin-left: 5px;
                }
            `;
            document.head.appendChild(style);
            
            // Auto-refresh dashboard every 60 seconds
            setInterval(() => {
                fetch('dashboard-data.php')
                    .then(response => response.json())
                    .then(data => {
                        // Update stats
                        document.querySelectorAll('.stat-content h3')[0].textContent = data.testDrives.total;
                        document.querySelectorAll('.stat-content h3')[1].textContent = data.carModels;
                        document.querySelectorAll('.stat-content h3')[2].textContent = data.blogPosts;
                        document.querySelectorAll('.stat-content h3')[3].textContent = data.newMessages;
                    })
                    .catch(error => console.error('Error refreshing dashboard:', error));
            }, 60000);
        });
    </script>
</body>
</html>