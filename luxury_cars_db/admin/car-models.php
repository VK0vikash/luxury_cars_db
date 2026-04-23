
<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Handle actions
if (isset($_GET['action']) && $_GET['action'] == 'add') {
    // Show add form
    $pageTitle = "Add New Car Model";
} elseif (isset($_GET['id'])) {
    // Show edit form
    $pageTitle = "Edit Car Model";
} else {
    // List all car models
    $pageTitle = "Manage Car Models";
    
    // Fetch car models
    try {
        $stmt = $conn->query("SELECT * FROM car_models ORDER BY created_at DESC");
        $carModels = $stmt->fetchAll();
    } catch(PDOException $e) {
        $error = "Database error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> | LUXURY AUTO</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Copy ALL CSS from your dashboard.php here */
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
        
        /* Copy ALL other CSS styles from your dashboard.php */
        /* ... Paste ALL CSS here ... */
    </style>
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar (Same as dashboard) -->
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <a href="dashboard.php" class="admin-logo">LUXURY AUTO</a>
                <div class="admin-subtitle">Admin Panel</div>
            </div>
            
            <nav class="sidebar-menu">
                <a href="dashboard.php" class="menu-item">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                
                <div class="menu-divider"></div>
                
                <a href="car-models.php" class="menu-item active">
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
                </a>
                <a href="contact-messages.php" class="menu-item">
                    <i class="fas fa-envelope"></i> Messages
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
                <h1><?php echo $pageTitle; ?></h1>
                <div class="header-actions">
                    <span>Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?></span>
                    <a href="logout.php" class="btn-logout">Logout</a>
                </div>
            </header>
            
            <?php if(isset($error)): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if(isset($_GET['action']) && $_GET['action'] == 'add'): ?>
                <!-- Add Car Form -->
                <div class="dashboard-table" style="padding: 2rem;">
                    <h3 style="margin-bottom: 1.5rem;">Add New Car Model</h3>
                    <form action="save-car.php" method="POST" enctype="multipart/form-data">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                            <div>
                                <label style="display: block; margin-bottom: 0.5rem; color: var(--light-secondary);">Model Name</label>
                                <input type="text" name="model_name" style="width: 100%; padding: 0.8rem; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); border-radius: 5px; color: var(--light);" required>
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: 0.5rem; color: var(--light-secondary);">Base Price ($)</label>
                                <input type="number" step="0.01" name="base_price" style="width: 100%; padding: 0.8rem; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); border-radius: 5px; color: var(--light);" required>
                            </div>
                        </div>
                        
                        <div style="margin-bottom: 1.5rem;">
                            <label style="display: block; margin-bottom: 0.5rem; color: var(--light-secondary);">Tagline</label>
                            <input type="text" name="tagline" style="width: 100%; padding: 0.8rem; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); border-radius: 5px; color: var(--light);">
                        </div>
                        
                        <div style="margin-bottom: 1.5rem;">
                            <label style="display: block; margin-bottom: 0.5rem; color: var(--light-secondary);">Description</label>
                            <textarea name="description" rows="5" style="width: 100%; padding: 0.8rem; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); border-radius: 5px; color: var(--light);"></textarea>
                        </div>
                        
                        <div style="margin-bottom: 1.5rem;">
                            <label style="display: block; margin-bottom: 0.5rem; color: var(--light-secondary);">Status</label>
                            <select name="status" style="width: 100%; padding: 0.8rem; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); border-radius: 5px; color: var(--light);">
                                <option value="active">Active</option>
                                <option value="upcoming">Upcoming</option>
                                <option value="discontinued">Discontinued</option>
                            </select>
                        </div>
                        
                        <div style="margin-bottom: 1.5rem;">
                            <label style="display: block; margin-bottom: 0.5rem; color: var(--light-secondary);">Featured Image</label>
                            <input type="file" name="image" accept="image/*" style="width: 100%; padding: 0.8rem; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); border-radius: 5px; color: var(--light);">
                        </div>
                        
                        <div style="display: flex; gap: 1rem;">
                            <button type="submit" class="btn-action btn-view" style="padding: 0.8rem 2rem;">Save Car Model</button>
                            <a href="car-models.php" class="btn-action" style="padding: 0.8rem 2rem; background: transparent; border: 1px solid var(--light-secondary);">Cancel</a>
                        </div>
                    </form>
                </div>
                
            <?php elseif(isset($_GET['id'])): ?>
                <!-- Edit Car Form -->
                <div class="dashboard-table" style="padding: 2rem;">
                    <h3 style="margin-bottom: 1.5rem;">Edit Car Model</h3>
                    <p>Edit form for car ID: <?php echo $_GET['id']; ?></p>
                </div>
                
            <?php else: ?>
                <!-- List Car Models -->
                <div class="dashboard-section">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                        <h2 class="section-title">
                            <i class="fas fa-car"></i> Car Models
                        </h2>
                        <a href="car-models.php?action=add" class="btn-action btn-view">
                            <i class="fas fa-plus"></i> Add New Car
                        </a>
                    </div>
                    
                    <div class="dashboard-table">
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Model Name</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(isset($carModels) && count($carModels) > 0): ?>
                                        <?php foreach($carModels as $car): ?>
                                        <tr>
                                            <td><?php echo $car['id']; ?></td>
                                            <td>
                                                <strong><?php echo htmlspecialchars($car['model_name']); ?></strong><br>
                                                <small style="color: var(--light-secondary);"><?php echo htmlspecialchars($car['tagline']); ?></small>
                                            </td>
                                            <td>$<?php echo number_format($car['base_price'], 2); ?></td>
                                            <td>
                                                <span class="status-badge status-<?php echo $car['status']; ?>">
                                                    <?php echo ucfirst($car['status']); ?>
                                                </span>
                                            </td>
                                            <td><?php echo date('M d, Y', strtotime($car['created_at'])); ?></td>
                                            <td>
                                                <a href="car-models.php?id=<?php echo $car['id']; ?>" class="btn-action btn-view">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <button class="btn-action btn-delete" onclick="deleteCar(<?php echo $car['id']; ?>)">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" style="text-align: center; padding: 3rem;">
                                                <i class="fas fa-car" style="font-size: 3rem; color: var(--light-secondary); margin-bottom: 1rem; display: block;"></i>
                                                <h3>No Car Models Found</h3>
                                                <p style="color: var(--light-secondary);">Add your first car model to get started</p>
                                                <a href="car-models.php?action=add" class="btn-action btn-view" style="margin-top: 1rem;">
                                                    <i class="fas fa-plus"></i> Add First Car
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </main>
    </div>
    
    <script>
        function deleteCar(id) {
            if(confirm('Are you sure you want to delete this car model?')) {
                window.location.href = 'delete-car.php?id=' + id;
            }
        }
    </script>
</body>
</html>