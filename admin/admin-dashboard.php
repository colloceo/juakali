<?php
session_start();
require_once '../functions.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'approve' && isset($_POST['product_id'])) {
    approveProduct($_POST['product_id']);
    header("Location: admin-dashboard.php");
    exit();
}

$products = $pdo->query("SELECT * FROM products WHERE status = 'Pending'")->fetchAll(PDO::FETCH_ASSOC);
$orders = $pdo->query("SELECT o.*, u.name AS customer FROM orders o JOIN users u ON o.user_id = u.id")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JuaKali - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;700&family=Lora:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Ubuntu', sans-serif; background-color: #f8f1e9; }
        .navbar { background-color: #FF5733; padding: 1rem; }
        .navbar-brand, .nav-link { color: #FFD700 !important; font-weight: bold; }
        .dashboard-container { padding: 2rem; }
        .dashboard-table { width: 100%; border-collapse: collapse; margin: 1rem 0; }
        .dashboard-table th, .dashboard-table td { border: 1px solid #ddd; padding: 0.5rem; text-align: center; }
        .btn-custom { background-color: #FFA500; color: #fff; border: none; padding: 0.75rem; font-size: 1rem; min-height: 48px; }
        @media (max-width: 768px) { .dashboard-container { padding: 1rem; } .dashboard-table th, .dashboard-table td { font-size: 0.8rem; } .navbar-brand, .nav-link { font-size: 0.9rem; } .btn-custom { font-size: 0.9rem; padding: 0.5rem; } }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="index-after-login.html">JuaKali</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="admin-dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="manage-artisans.php">Manage Artisans</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="dashboard-container">
        <h2 class="text-center my-4" style="font-family: 'Lora', serif; color: #FF5733;">Admin Dashboard</h2>
        <h5>Manage Products</h5>
        <table class="dashboard-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo $product['name']; ?></td>
                        <td>KES <?php echo number_format($product['price'], 2); ?></td>
                        <td><?php echo $product['status']; ?></td>
                        <td>
                            <form method="POST" style="margin: 0;">
                                <input type="hidden" name="action" value="approve">
                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                <button type="submit" class="btn btn-custom">Approve</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h5>Manage Orders</h5>
        <table class="dashboard-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td>#<?php echo $order['id']; ?></td>
                        <td><?php echo $order['customer']; ?></td>
                        <td>KES <?php echo number_format($order['total'], 2); ?></td>
                        <td><?php echo $order['status']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>