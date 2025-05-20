<?php
session_start();
require_once 'functions.php';

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header("Location: login.php");
    exit();
}

$cart_items = getCartItems($user_id);
if (empty($cart_items)) {
    header("Location: cart.php?error=" . urlencode("Your cart is empty."));
    exit();
}

$total = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart_items));
if ($total <= 0) {
    header("Location: cart.php?error=" . urlencode("Invalid cart total."));
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $payment_method = $_POST['payment'] ?? '';
    $delivery_option = $_POST['delivery_option'] ?? '';
    $mpesa_number = $_POST['mpesa_number'] ?? '';

    if (empty($payment_method) || empty($delivery_option)) {
        $error = "Please select both a payment method and delivery option.";
    } elseif ($payment_method === 'mpesa' && empty($mpesa_number)) {
        $error = "Please enter a valid M-Pesa number.";
    } else {
        // Create order
        $order_id = createOrder($user_id, $total, $payment_method, $delivery_option);
        foreach ($cart_items as $item) {
            addOrderItem($order_id, $item['product_id'], $item['quantity'], $item['price']);
        }

        if ($payment_method === 'mpesa') {
            // Store necessary data in session for mpesa.php
            $_SESSION['totalAmount'] = $total;
            $_SESSION['mpesa_number'] = $mpesa_number;
            $_SESSION['order_id'] = $order_id;
            $_SESSION['cart_items'] = $cart_items;
            $_SESSION['email'] = $_SESSION['email'] ?? 'default@example.com'; // Replace with actual user email retrieval
            header("Location: mpesa.php");
            exit();
        } else {
            // For other payment methods (e.g., cash on delivery), clear cart and redirect
            $pdo->prepare("DELETE FROM cart WHERE user_id = ?")->execute([$user_id]);
            header("Location: payment_success.php?order_id=$order_id");
            exit();
        }
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
        .alert { margin: 1rem 0; }
        footer { background-color: #FF5733; color: #FFD700; padding: 1rem; text-align: center; }
        @media (max-width: 768px) { .checkout-container { padding: 1rem; } }
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
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="categoryDropdown" data-bs-toggle="dropdown">Products</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Decor</a></li>
                            <li><a class="dropdown-item" href="#">Textiles</a></li>
                            <li><a class="dropdown-item" href="#">Food</a></li>
                            <li><a class="dropdown-item" href="#">Personal Care</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#artisans">Artisans</a></li>
                    <li class="nav-item"><a class="nav-link" href="cart.php">Cart</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" data-bs-toggle="dropdown">Account</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="account.php">My Account</a></li>
                            <li><a class="dropdown-item" href="wishlist.php">Wishlist</a></li>
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="checkout-container">
        <h2 class="text-center my-4" style="font-family: 'Lora', serif; color: #FF5733;">Checkout</h2>
        <div class="progress">
            <div class="progress-bar" style="width: 100%;">Payment</div>
        </div>
        <?php if ($error): ?>
            <div class="alert alert-danger text-center" role="alert"><?php echo $error; ?></div>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-6">
                <h5>Order Summary</h5>
                <?php foreach ($cart_items as $item): ?>
                    <p><?php echo htmlspecialchars($item['name']); ?> - KES <?php echo number_format($item['price'] * $item['quantity'], 2); ?></p>
                <?php endforeach; ?>
                <p><strong>Total: KES <?php echo number_format($total, 2); ?></strong></p>
            </div>
            <div class="col-md-6">
                <form method="POST" id="checkoutForm">

                    <h5>Delivery Option</h5>
                    <select class="form-select mb-3" name="delivery_option" required>
                        <option value="">Select "Mtaani" Pick-up Point</option>
                        <option value="Nairobi - Westlands Shop">Nairobi - Westlands Shop</option>
                        <option value="Nairobi - CBD Shop">Nairobi - CBD Shop</option>
                        <option value="Kisumu - CBD Shop">Kisumu -CBD Shop</option>
                        <option value="MOmbasa - CBD Shop">Mombasa - CBD Shop</option>
                    </select>
                    
                    <h5>Payment Method</h5>
                    <select class="form-select mb-3" name="payment" id="paymentMethod" required>
                        <option value="">Select Payment Method</option>
                        <option value="mpesa">M-Pesa</option>
                        <option value="cod">Cash on Delivery</option>
                    </select>

                    <!-- M-Pesa Modal Trigger -->
                    <div id="mpesaButton" style="display: none;">
                        <button type="button" class="btn btn-custom w-100 mb-3" data-bs-toggle="modal" data-bs-target="#payWithMpesaModal">Pay with M-Pesa</button>
                    </div>
                    <button type="submit" class="btn btn-custom w-100" id="confirmButton">Confirm Order</button>
                </form>

                <!-- Pay with M-Pesa Modal -->
                <div class="modal fade" id="payWithMpesaModal" tabindex="-1" aria-labelledby="payWithMpesaModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="payWithMpesaModalLabel">Pay with M-Pesa</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Enter M-Pesa Number</label>
                                    <input type="text" class="form-control" id="phone" name="mpesa_number" required placeholder="+254123456789">
                                </div>
                                <button type="button" class="btn btn-custom w-100" onclick="submitCheckoutForm()">Proceed to Pay</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div class="container">
            <p>© <?php echo date("Y"); ?> JuaKali. All rights reserved.</p>
            <div class="mt-2">
                <a href="terms.php">Terms</a> |
                <a href="privacy.php">Privacy</a> |
                <a href="contact.php">Contact</a>
            </div>
            <div class="social-icons mt-3">
                <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script>
        // Show/Hide M-Pesa button based on payment method selection
        document.getElementById('paymentMethod').addEventListener('change', function() {
            const mpesaButton = document.getElementById('mpesaButton');
            const confirmButton = document.getElementById('confirmButton');
            if (this.value === 'mpesa') {
                mpesaButton.style.display = 'block';
                confirmButton.style.display = 'none';
            } else {
                mpesaButton.style.display = 'none';
                confirmButton.style.display = 'block';
            }
        });

        // Function to append M-Pesa number to form and submit
        function submitCheckoutForm() {
            const mpesaNumber = document.getElementById('phone').value;
            if (!mpesaNumber) {
                alert("Please enter your M-Pesa number.");
                return;
            }
            const form = document.getElementById('checkoutForm');
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'mpesa_number';
            input.value = mpesaNumber;
            form.appendChild(input);
            form.submit();
        }
    </script>
</body>
</html>