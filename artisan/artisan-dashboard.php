<?php
session_start();
require_once '../functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: artisan-login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$artisan = getArtisanByUserId($user_id);
if (!$artisan) {
    header("Location: artisan-index.php");
    exit();
}

$products = getArtisanProducts($artisan['id']);

// Fetch orders with order date
$ordersStmt = $pdo->prepare("
    SELECT
        o.id AS order_id,
        o.created_at AS order_date,
        oi.quantity,
        p.name AS product_name
    FROM orders o
    JOIN order_items oi ON o.id = oi.order_id
    JOIN products p ON oi.product_id = p.id
    WHERE p.artisan_id = ?
    ORDER BY o.created_at DESC
");
$ordersStmt->execute([$artisan['id']]);
$orders = $ordersStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JuaKali - Artisan Dashboard</title>
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
        .section-title { font-family: 'Lora', serif; color: #FF5733; text-align: center; }
        footer { background-color: #FF5733; color: #FFD700; padding: 1rem; text-align: center; }
        .no-data { text-align: center; color: #777; margin-top: 1rem; }
        @media (max-width: 768px) { .dashboard-container { padding: 1rem; } .dashboard-table th, .dashboard-table td { font-size: 0.8rem; } .navbar-brand, .nav-link { font-size: 0.9rem; } .btn-custom { font-size: 0.9rem; padding: 0.5rem; } }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="artisan-index.php">JuaKali</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                 <ul class="navbar-nav ms-auto">
                     <li class="nav-item"><a class="nav-link" href="artisan-dashboard.php">Dashboard</a></li>
                     <li class="nav-item"><a class="nav-link" href="artisan-product-upload.php">Upload Product</a></li>
                     <li class="nav-item"><a class="nav-link" href="artisan-options.php">Profile</a></li>
                     <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                 </ul>
            </div>
        </div>
    </nav>

    <div class="dashboard-container">
        <h2 class="section-title"><?php echo htmlspecialchars($artisan['name']); ?>'s Dashboard</h2>

        <h5>Approved Products</h5>
        <?php if (!empty($products)): ?>
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td>KES <?php echo number_format($product['price'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-data">No approved products yet.</p>
        <?php endif; ?>

        <h5>Orders</h5>
        <?php if (!empty($orders)): ?>
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Order Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td>#<?php echo $order['order_id']; ?></td>
                            <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                            <td><?php echo $order['quantity']; ?></td>
                            <td><?php echo date('Y-m-d H:i:s', strtotime($order['order_date'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-data">No orders received yet.</p>
        <?php endif; ?>
    </div>

    <footer>
        <p>© 2025 JuaKali. All rights reserved.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>