<?php
session_start();
require_once 'functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    $error = "User not found.";
    $user = ['name' => 'Unknown', 'email' => 'Not provided', 'phone' => 'Not provided', 'address' => 'Not provided'];
}

$orders = getUserOrders($user_id);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, phone = ? WHERE id = ?");
    $stmt->execute([$name, $email, $phone, $user_id]);
    header("Location: account.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_address'])) {
    $address = $_POST['address'];
    $stmt = $pdo->prepare("UPDATE users SET address = ? WHERE id = ?");
    $stmt->execute([$address, $user_id]);
    header("Location: account.php");
    exit();
}
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
        .section-title { font-family: 'Lora', serif; color: #FF5733; margin: 2rem 0 1rem; }
        .card { margin-bottom: 1.5rem; }
        .btn-custom { background-color: #FFA500; color: #fff; border: none; padding: 0.75rem; font-size: 1rem; min-height: 48px; }
        .order-table { width: 100%; border-collapse: collapse; margin: 1rem 0; }
        .order-table th, .order-table td { border: 1px solid #ddd; padding: 0.5rem; text-align: left; }
        .error { color: red; text-align: center; }
        @media (max-width: 768px) {
            .account-container { padding: 1rem; }
            .navbar-brand, .nav-link { font-size: 0.9rem; }
            .btn-custom { font-size: 0.9rem; padding: 0.5rem; }
            .order-table th, .order-table td { font-size: 0.8rem; }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="index-after-login.php">JuaKali</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index-after-login.php#products">Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="index-after-login.php#artisans">Artisans</a></li>
                    <li class="nav-item"><a class="nav-link" href="cart.php">Cart</a></li>
                    <li class="nav-item"><a class="nav-link" href="account.php">Account</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="account-container">
        <h2 class="section-title">My Account</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

        <!-- Profile Details -->
        <div class="card">
            <div class="card-body">
                <h5 class="section-title">Profile Details</h5>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']) ?: 'Not provided'; ?></p>
                <button class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#editProfileModal">Edit Profile</button>
            </div>
        </div>

        <!-- Edit Profile Modal -->
        <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST">
                            <input type="hidden" name="update_profile" value="1">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>">
                            </div>
                            <button type="submit" class="btn btn-custom">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders -->
        <div class="card">
            <div class="card-body">
                <h5 class="section-title">Orders</h5>
                <?php if (empty($orders)): ?>
                    <p>No orders found.</p>
                <?php else: ?>
                    <table class="order-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Items</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td>#<?php echo $order['id']; ?></td>
                                    <td>KES <?php echo number_format($order['total'], 2); ?></td>
                                    <td><?php echo $order['status']; ?></td>
                                    <td><?php echo $order['name'] . " (Qty: " . $order['quantity'] . ")"; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>

        <!-- Addresses -->
        <div class="card">
            <div class="card-body">
                <h5 class="section-title">Addresses</h5>
                <p><strong>Address:</strong> <?php echo htmlspecialchars($user['address']) ?: 'Not provided'; ?></p>
                <button class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#editAddressModal">Edit Address</button>
            </div>
        </div>

        <!-- Edit Address Modal -->
        <div class="modal fade" id="editAddressModal" tabindex="-1" aria-labelledby="editAddressModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editAddressModalLabel">Edit Address</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST">
                            <input type="hidden" name="update_address" value="1">
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control" id="address" name="address" rows="3"><?php echo htmlspecialchars($user['address']); ?></textarea>
                            </div>
                            <button type="submit" class="btn btn-custom">Save Address</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>