<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

include '../includes/db.php';

// Handle delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM car_models WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: manage_cars.php?msg=deleted');
    exit();
}

// Fetch all cars
$stmt = $pdo->query("SELECT * FROM car_models ORDER BY created_at DESC");
$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Cars</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-car-front"></i> Manage Car Models</h2>
            <a href="add_car.php" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add New Car
            </a>
        </div>

        <?php if (isset($_GET['msg'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php 
                if ($_GET['msg'] == 'added') echo "Car added successfully!";
                if ($_GET['msg'] == 'updated') echo "Car updated successfully!";
                if ($_GET['msg'] == 'deleted') echo "Car deleted successfully!";
                ?>
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
                                <th>Image</th>
                                <th>Name</th>
                                <th>Brand</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($cars) > 0): ?>
                                <?php foreach ($cars as $car): ?>
                                <tr>
                                    <td><?php echo $car['id']; ?></td>
                                    <td>
                                        <?php if (!empty($car['image'])): ?>
                                            <img src="../uploads/<?php echo $car['image']; ?>" width="60" height="40" style="object-fit: cover;">
                                        <?php else: ?>
                                            <span class="text-muted">No image</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($car['name']); ?></td>
                                    <td><?php echo htmlspecialchars($car['brand']); ?></td>
                                    <td>$<?php echo number_format($car['price'], 2); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo ($car['status'] == 'active') ? 'success' : 'danger'; ?>">
                                            <?php echo ucfirst($car['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="edit_car.php?id=<?php echo $car['id']; ?>" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <a href="manage_cars.php?delete=<?php echo $car['id']; ?>" 
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('Are you sure you want to delete this car?')">
                                            <i class="bi bi-trash"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        No cars found. <a href="add_car.php">Add your first car</a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>