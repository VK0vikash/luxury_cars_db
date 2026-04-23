<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

include '../includes/db.php';

// Update status
if (isset($_GET['update_status'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];
    $stmt = $pdo->prepare("UPDATE test_drive_requests SET status = ? WHERE id = ?");
    $stmt->execute([$status, $id]);
    header('Location: test_drives.php?msg=updated');
    exit();
}

// Fetch all requests
$stmt = $pdo->query("SELECT tdr.*, cm.name as car_name 
                     FROM test_drive_requests tdr 
                     LEFT JOIN car_models cm ON tdr.car_model_id = cm.id 
                     ORDER BY tdr.created_at DESC");
$requests = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Drive Requests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div class="container mt-4">
        <h2>Test Drive Requests</h2>
        
        <?php if (isset($_GET['msg'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Status updated successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Car Model</th>
                                <th>Date</th>
                                <th>Phone</th>
                                <th>City</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($requests as $request): ?>
                            <tr>
                                <td><?php echo $request['id']; ?></td>
                                <td>
                                    <strong><?php echo htmlspecialchars($request['customer_name']); ?></strong><br>
                                    <small class="text-muted"><?php echo $request['email']; ?></small>
                                </td>
                                <td><?php echo $request['car_name'] ?? 'N/A'; ?></td>
                                <td><?php echo date('d M Y', strtotime($request['preferred_date'])); ?></td>
                                <td><?php echo $request['phone']; ?></td>
                                <td><?php echo $request['city']; ?></td>
                                <td>
                                    <span class="badge bg-<?php 
                                        switch($request['status']) {
                                            case 'pending': echo 'warning'; break;
                                            case 'confirmed': echo 'success'; break;
                                            case 'completed': echo 'info'; break;
                                            case 'cancelled': echo 'danger'; break;
                                            default: echo 'secondary';
                                        }
                                    ?>">
                                        <?php echo ucfirst($request['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                                            Change Status
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="test_drives.php?update_status&id=<?php echo $request['id']; ?>&status=pending">Pending</a></li>
                                            <li><a class="dropdown-item" href="test_drives.php?update_status&id=<?php echo $request['id']; ?>&status=confirmed">Confirmed</a></li>
                                            <li><a class="dropdown-item" href="test_drives.php?update_status&id=<?php echo $request['id']; ?>&status=completed">Completed</a></li>
                                            <li><a class="dropdown-item" href="test_drives.php?update_status&id=<?php echo $request['id']; ?>&status=cancelled">Cancelled</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>