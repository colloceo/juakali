<?php
session_start();
require_once 'functions.php';

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'add' && isset($_POST['product_id'])) {
        addToCart($user_id, $_POST['product_id'], 1);
    } elseif ($_POST['action'] == 'remove' && isset($_POST['product_id'])) {
        removeFromCart($user_id, $_POST['product_id']);
    }
    header("Location: cart.php");
    exit();
}

$cart_items = getCartItems($user_id);
$total = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart_items));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JuaKali - Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;700&family=Lora:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Ubuntu', sans-serif; background-color: #f8f1e9; }
        .navbar { background-color: #FF5733; padding: 1rem; position:}
        .navbar-brand, .nav-link { color: #FFD700 !important; font-weight: bold; }
        .cart-table { width: 100%; border-collapse: collapse; margin: 1rem 0; }
        .cart-table th, .cart-table td { border: 1px solid #ddd; padding: 0.5rem; text-align: center; }
        .cart-table img { width: 100px; height: 100px; object-fit: contain; }
        .btn-custom { background-color: #FFA500; color: #fff; border: none; padding: 0.75rem; font-size: 1rem; min-height: 48px; }
        .btn-danger { padding: 0.75rem; font-size: 1rem; min-height: 48px; }
        footer { background-color: #FF5733; color: #FFD700; padding: 1rem; text-align: center; }
        @media (max-width: 768px) { .cart-table img { width: 50px; height: 50px; } .cart-table th, .cart-table td { font-size: 0.8rem; } .navbar-brand, .nav-link { font-size: 0.9rem; } .btn-custom, .btn-danger { font-size: 0.9rem; padding: 0.5rem; } }
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
                    <li class="nav-item"><a class="nav-link" href="#artisans">Artisans</a></li>
                    <li class="nav-item"><a class="nav-link" href="cart.php">Cart</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" data-bs-toggle="dropdown">Account</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="account.php">My Account</a></li>
                            <li><a class="dropdown-item" href="wishlist.php">Wishlist</a></li>
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <h2 class="text-center my-4" style="font-family: 'Lora', serif; color: #FF5733;">Your Cart</h2>
        <?php if (empty($cart_items)): ?>
            <p>Your cart is empty. <a href="index-after-login.php">Continue Shopping</a></p>
        <?php else: ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_items as $item): ?>
                        <tr>
                            <td><img src="https://via.placeholder.com/100x100?text=<?php echo urlencode($item['name']); ?>" alt="<?php echo $item['name']; ?>"> <?php echo $item['name']; ?></td>
                            <td>KES <?php echo number_format($item['price'], 2); ?></td>
                            <td><input type="number" value="<?php echo $item['quantity']; ?>" min="1" class="form-control quantity" style="width: 60px; margin: 0 auto;" data-product-id="<?php echo $item['product_id']; ?>"></td>
                            <td>KES <?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                            <td>
                                <form method="POST" style="margin: 0;">
                                    <input type="hidden" name="action" value="remove">
                                    <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                                    <button type="submit" class="btn btn-danger">Remove</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="text-end">
                <h5>Total: KES <?php echo number_format($total, 2); ?></h5>
                <a href="checkout.php" class="btn btn-custom">Proceed to Checkout</a>
            </div>
        <?php endif; ?>
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
    <script>
        $(document).ready(function() {
            $('.quantity').change(function() {
                var productId = $(this).data('product-id');
                var quantity = $(this).val();
                $.post('update_cart.php', { product_id: productId, quantity: quantity }, function() {
                    location.reload();
                });
            });
        });
    </script>
</body>
</html>