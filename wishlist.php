<?php
session_start();
require_once 'functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$wishlist_items = getWishlistItems($user_id); // Assumes this function returns wishlist items with product details

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_id'])) {
    $remove_id = (int)$_POST['remove_id'];
    removeFromWishlist($user_id, $remove_id);
    header("Location: wishlist.php?removed=true");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['move_to_cart'])) {
    $product_id = (int)$_POST['move_to_cart'];
    if (addToCart($user_id, $product_id, 1)) {
        removeFromWishlist($user_id, $product_id);
        header("Location: wishlist.php?added_to_cart=true");
        exit();
    }
}

$success = isset($_GET['added_to_cart']) && $_GET['added_to_cart'] === 'true' ? "Item moved to cart successfully!" : '';
$removed = isset($_GET['removed']) && $_GET['removed'] === 'true' ? "Item removed from wishlist successfully!" : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JuaKali - Wishlist</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;700&family=Lora:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body { font-family: 'Ubuntu', sans-serif; background-color: #f8f9fa; margin: 0; }
        .navbar { background-color: #FF5733; padding: 1rem; position: fixed; width: 100%; z-index: 1000; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .navbar-brand, .nav-link { color: #FFD700 !important; font-weight: bold; }
        .container { padding-top: 80px; padding-bottom: 2rem; }
        .wishlist-table { width: 100%; border-collapse: collapse; margin: 1rem 0; }
        .wishlist-table th, .wishlist-table td { border: 1px solid #ddd; padding: 0.75rem; text-align: center; }
        .btn-custom { background-color: #FFA500; color: #fff; border: none; padding: 0.5rem 1rem; font-size: 1rem; border-radius: 5px; }
        .section-title { font-family: 'Lora', serif; color: #FF5733; text-align: center; margin: 2rem 0; }
        .alert { margin: 1rem 0; }
        footer { background-color: #FF5733; color: #FFD700; padding: 1rem; text-align: center; margin-top: 2rem; }
        @media (max-width: 768px) {
            .container { padding-top: 60px; }
            .wishlist-table th, .wishlist-table td { font-size: 0.8rem; padding: 0.5rem; }
            .btn-custom { font-size: 0.9rem; padding: 0.4rem 0.8rem; }
            .navbar-brand, .nav-link { font-size: 0.9rem; }
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
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="products.php" id="categoryDropdown" data-bs-toggle="dropdown">Categories</a>
                        <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                            <li><a class="dropdown-item" href="products.php?category=Decor">Decor</a></li>
                            <li><a class="dropdown-item" href="products.php?category=Textiles">Textiles</a></li>
                            <li><a class="dropdown-item" href="products.php?category=Food">Food</a></li>
                            <li><a class="dropdown-item" href="products.php?category=Personal Care">Personal Care</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart"></i> Cart</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" data-bs-toggle="dropdown">Account</a>
                        <ul class="dropdown-menu" aria-labelledby="accountDropdown">
                            <li><a class="dropdown-item" href="account.php">My Account</a></li>
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2 class="section-title">Your Wishlist</h2>
        <?php if ($success): ?>
            <div class="alert alert-success text-center" role="alert"><?php echo $success; ?></div>
        <?php endif; ?>
        <?php if ($removed): ?>
            <div class="alert alert-success text-center" role="alert"><?php echo $removed; ?></div>
        <?php endif; ?>
        <?php if (empty($wishlist_items)): ?>
            <div class="alert alert-info text-center" role="alert">Your wishlist is empty.</div>
        <?php else: ?>
            <table class="wishlist-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($wishlist_items as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td>KES <?php echo number_format($item['price'], 2); ?></td>
                            <td>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="move_to_cart" value="<?php echo $item['product_id']; ?>">
                                    <button type="submit" class="btn btn-custom"><i class="fas fa-shopping-cart"></i> Add to Cart</button>
                                </form>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="remove_id" value="<?php echo $item['product_id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Remove</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
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
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>