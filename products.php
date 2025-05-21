<?php
session_start();
require_once 'functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$category = isset($_GET['category']) ? $_GET['category'] : '';
$query = "SELECT * FROM products WHERE status = 'Approved'";
if ($category) {
    $query .= " AND category = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$category]);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $products = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    $product_id = (int)$_POST['product_id'];
    $stmt = $pdo->prepare("SELECT id FROM products WHERE id = ? AND status = 'Approved'");
    $stmt->execute([$product_id]);
    if ($stmt->fetchColumn() && addToCart($user_id, $product_id, 1)) {
        header("Location: products.php?added=true" . ($category ? "&category=$category" : ''));
        exit();
    } else {
        header("Location: products.php?error=failed" . ($category ? "&category=$category" : ''));
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['wishlist_id'])) {
    $product_id = (int)$_POST['wishlist_id'];
    $stmt = $pdo->prepare("SELECT id FROM products WHERE id = ? AND status = 'Approved'");
    $stmt->execute([$product_id]);
    if ($stmt->fetchColumn() && addToWishlist($user_id, $product_id)) {
        header("Location: products.php?wishlisted=true" . ($category ? "&category=$category" : ''));
        exit();
    } else {
        header("Location: products.php?error=wishlist_failed" . ($category ? "&category=$category" : ''));
        exit();
    }
}

$success = isset($_GET['added']) && $_GET['added'] === 'true' ? "Product added to cart successfully!" : '';
$wishlisted = isset($_GET['wishlisted']) && $_GET['wishlisted'] === 'true' ? "Product added to wishlist successfully!" : '';
$error = isset($_GET['error']) && $_GET['error'] === 'failed' ? "Failed to add product to cart. Please try again." : '';
$wishlist_error = isset($_GET['error']) && $_GET['error'] === 'wishlist_failed' ? "Failed to add product to wishlist. Please try again." : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JuaKali - Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;700&family=Lora:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body { font-family: 'Ubuntu', sans-serif; background-color: #f8f9fa; margin: 0; }
        .navbar { background-color: #FF5733; padding: 1rem; z-index: 1000; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .navbar-brand, .nav-link { color: #FFD700 !important; font-weight: bold; }
        .hero-section { background: url('https://via.placeholder.com/1200x300?text=Explore+Products') no-repeat center; background-size: cover; color: #fff; padding: 4rem 0; text-align: center; margin-top: 60px; }
        .hero-section h1 { font-family: 'Lora', serif; font-size: 2.5rem; }
        .product-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; padding: 2rem; }
        .product-card { background: #fff; border: 1px solid #ddd; border-radius: 8px; padding: 1rem; text-align: center; transition: transform 0.2s; }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 5px 15px rgba(0,0,0,0.2); }
        .product-card img { width: 100%; height: 200px; object-fit: contain; border-bottom: 1px solid #ddd; }
        .btn-custom { background-color: #FFA500; color: #fff; border: none; padding: 0.5rem 1rem; font-size: 1rem; border-radius: 5px; }
        .btn-wishlist { background-color: #FF5733; color: #fff; border: none; padding: 0.5rem 1rem; font-size: 1rem; border-radius: 5px; }
        .section-title { font-family: 'Lora', serif; color: #FF5733; text-align: center; margin: 2rem 0; }
        .alert { margin: 1rem 0; }
        footer { background-color: #FF5733; color: #FFD700; padding: 1rem; text-align: center; margin-top: 2rem; }
        .category-nav { margin: 1rem 0; }
        .category-nav a { color: #FF5733; margin: 0 0.5rem; text-decoration: none; }
        .category-nav a:hover { text-decoration: underline; }
        .btn-group { display: flex; gap: 0.5rem; justify-content: center; }
        @media (max-width: 768px) {
            .hero-section { padding: 2rem 0; }
            .product-grid { padding: 1rem; }
            .product-card { padding: 0.5rem; }
            .btn-custom, .btn-wishlist { font-size: 0.9rem; padding: 0.4rem 0.8rem; }
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
                        <a class="nav-link dropdown-toggle" href="#" id="categoryDropdown" data-bs-toggle="dropdown">Categories</a>
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
                    <li class="nav-item"><a class="nav-link" href="wishlist.php"><i class="fas fa-heart"></i> Wishlist</a></li>
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

    <div class="hero-section">
        <h1>Explore Our Products</h1>
        <p>Discover handcrafted items from Kenyan artisans.</p>
        <a href="#products" class="btn btn-custom">Shop Now</a>
    </div>

    <div class="container">
        <?php if ($success): ?>
            <div class="alert alert-success text-center" role="alert"><?php echo $success; ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-danger text-center" role="alert"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($wishlisted): ?>
            <div class="alert alert-success text-center" role="alert"><?php echo $wishlisted; ?></div>
        <?php endif; ?>
        <?php if ($wishlist_error): ?>
            <div class="alert alert-danger text-center" role="alert"><?php echo $wishlist_error; ?></div>
        <?php endif; ?>

        <div class="category-nav">
            <a href="products.php">All</a> |
            <a href="products.php?category=Decor">Decor</a> |
            <a href="products.php?category=Textiles">Textiles</a> |
            <a href="products.php?category=Food">Food</a> |
            <a href="products.php?category=Personal Care">Personal Care</a>
        </div>
        <h2 class="section-title" id="products">Featured Products</h2>
        <div class="product-grid">
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <img src="https://via.placeholder.com/250x200?text=<?php echo urlencode($product['name']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <h5><?php echo htmlspecialchars($product['name']); ?></h5>
                    <p class="text-muted">KES <?php echo number_format($product['price'], 2); ?></p>
                    <div class="btn-group">
                        <form method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <button type="submit" class="btn btn-custom"><i class="fas fa-shopping-cart"></i> Add to Cart</button>
                        </form>
                        <form method="POST">
                            <input type="hidden" name="wishlist_id" value="<?php echo $product['id']; ?>">
                            <button type="submit" class="btn btn-wishlist"><i class="fas fa-heart"></i> Add to Wishlist</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
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
</body>
</html>