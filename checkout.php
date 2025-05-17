<?php
session_start();
require_once 'functions.php';

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header("Location: login.php");
    exit();
}

$cart_items = getCartItems($user_id);
$total = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart_items));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $payment_method = $_POST['payment'];
    $delivery_option = $_POST['delivery_option'];
    $order_id = createOrder($user_id, $total, $payment_method, $delivery_option);
    foreach ($cart_items as $item) {
        addOrderItem($order_id, $item['product_id'], $item['quantity'], $item['price']);
    }
    // M-Pesa Daraja API integration placeholder
    $mpesa_response = "M-Pesa payment processing (replace with Daraja API call)";
    if ($payment_method == 'mpesa' && $mpesa_response) {
        // Clear cart after successful payment
        $pdo->prepare("DELETE FROM cart WHERE user_id = ?")->execute([$user_id]);
        header("Location: account.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JuaKali - Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;700&family=Lora:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Ubuntu', sans-serif; background-color: #f8f1e9; }
        .navbar { background-color: #FF5733; padding: 1rem; }
        .navbar-brand, .nav-link { color: #FFD700 !important; font-weight: bold; }
        .checkout-container { padding: 2rem; }
        .progress { margin-bottom: 1rem; }
        .btn-custom { background-color: #FFA500; color: #fff; border: none; padding: 0.75rem; font-size: 1rem; min-height: 48px; }
        .qr-code { width: 150px; height: 150px; margin: 1rem auto; }
        @media (max-width: 768px) { .checkout-container { padding: 1rem; } .qr-code { width: 100px; height: 100px; } .navbar-brand, .nav-link { font-size: 0.9rem; } .btn-custom { font-size: 0.9rem; padding: 0.5rem; } }
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
    <div class="checkout-container">
        <h2 class="text-center my-4" style="font-family: 'Lora', serif; color: #FF5733;">Checkout</h2>
        <div class="progress">
            <div class="progress-bar" style="width: 100%;">Payment</div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h5>Order Summary</h5>
                <?php foreach ($cart_items as $item): ?>
                    <p><?php echo $item['name']; ?> - KES <?php echo number_format($item['price'] * $item['quantity'], 2); ?></p>
                <?php endforeach; ?>
                <p>Total: KES <?php echo number_format($total, 2); ?></p>
            </div>
            <div class="col-md-6">
                <form method="POST">
                    <h5>Payment Method</h5>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="payment" id="mpesa" value="mpesa" checked>
                        <label class="form-check-label" for="mpesa">M-Pesa</label>
                    </div>
                    <img src="https://via.placeholder.com/150x150?text=M-Pesa+QR+Code" alt="M-Pesa QR Code" class="qr-code d-block">
                    <h5>Delivery Option</h5>
                    <select class="form-select" name="delivery_option" required>
                        <option value="">Select "Mtaani" Pick-up Point</option>
                        <option value="Nairobi - Westlands Shop">Nairobi - Westlands Shop</option>
                        <option value="Nairobi - CBD Shop">Nairobi - CBD Shop</option>
                    </select>
                    <button type="submit" class="btn btn-custom mt-3 w-100">Confirm Order</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>