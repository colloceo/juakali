<?php
session_start();
require_once 'functions.php';

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header("Location: login.php");
    exit();
}

$orders = getUserOrders($user_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JuaKali - My Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;700&family=Lora:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Ubuntu', sans-serif; background-color: #f8f1e9; }
        .navbar { background-color: #FF5733; padding: 1rem; }
        .navbar-brand, .nav-link { color: #FFD700 !important; font-weight: bold; }
        .account-container { padding: 2rem; }
        .nav-tabs .nav-link { color: #FF5733; }
        .nav-tabs .nav-link.active { background-color: #FFA500; color: #fff; }
        .btn-custom { background-color: #FFA500; color: #fff; border: none; padding: 0.75rem; font-size: 1rem; min-height: 48px; }
        @media (max-width: 768px) { .account-container { padding: 1rem; } .navbar-brand, .nav-link { font-size: 0.9rem; } .btn-custom { font-size: 0.9rem; padding: 0.5rem; } }
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
                    <li class="nav-item"><a class="nav-link" href="index-after-login.html#products">Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="index-after-login.html#artisans">Artisans</a></li>
                    <li class="nav-item"><a class="nav-link" href="cart.php">Cart</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="account-container">
        <h2 class="text-center my-4" style="font-family: 'Lora', serif; color: #FF5733;">My Account</h2>
        <ul class="nav nav-tabs mb-4" id="accountTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab">Profile</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders" type="button" role="tab">Orders</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="addresses-tab" data-bs-toggle="tab" data-bs-target="#addresses" type="button" role="tab">Addresses</button>
            </li>
        </ul>
        <div class="tab-content" id="accountTabContent">
            <div class="tab-pane fade show active" id="profile" role="tabpanel">
                <h5>Profile Details</h5>
                <p>Name: <?php echo $_SESSION['name']; ?></p>
                <p>Email: <?php echo $user['email']; ?></p>
                <p>Phone: <?php echo $user['phone'] ?? 'Not provided'; ?></p>
                <button class="btn btn-custom">Edit Profile</button>
            </div>
            <div class="tab-pane fade" id="orders" role="tabpanel">
                <h5>Order History</h5>
                <?php if (empty($orders)): ?>
                    <p>No orders yet. <a href="index-after-login.html">Start Shopping</a></p>
                <?php else: ?>
                    <?php foreach ($orders as $order): ?>
                        <p>Order #<?php echo $order['id']; ?> - <?php echo $order['name']; ?> (x<?php echo $order['quantity']; ?>) - KES <?php echo number_format($order['total'], 2); ?> - <?php echo $order['status']; ?> on <?php echo $order['created_at']; ?></p>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="tab-pane fade" id="addresses" role="tabpanel">
                <h5>Saved Addresses</h5>
                <p>Primary: Westlands, Nairobi, Kenya</p>
                <p>Secondary: CBD, Nairobi, Kenya</p>
                <button class="btn btn-custom">Add Address</button>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.btn-custom').click(function() {
                alert('Edit profile/address functionality to be implemented with PHP backend');
            });
        });
    </script>
</body>
</html>