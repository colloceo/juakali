<?php
session_start();
require_once 'functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get the selected category from URL, default to null (show all)
$selected_category = $_GET['category'] ?? null;

// Fetch products based on category
$query = "SELECT * FROM products WHERE status = 'Approved'";
if ($selected_category) {
    $query .= " AND category = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$selected_category]);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $products = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
}

// Handle Add to Cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    $product_id = (int)$_POST['product_id'];
    $stmt = $pdo->prepare("SELECT id FROM products WHERE id = ? AND status = 'Approved'");
    $stmt->execute([$product_id]);
    if ($stmt->fetchColumn() && addToCart($user_id, $product_id, 1)) {
        header("Location: products.php?category=" . urlencode($selected_category) . "&added=true");
        exit();
    } else {
        header("Location: products.php?category=" . urlencode($selected_category) . "&error=failed");
        exit();
    }
}

$success = isset($_GET['added']) && $_GET['added'] === 'true' ? "Product added to cart successfully!" : '';
$error = isset($_GET['error']) && $_GET['error'] === 'failed' ? "Failed to add product to cart. Please try again." : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JuaKali - Shop Handcrafted Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;700&family=Lora:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Ubuntu', sans-serif; background-color: #f8f1e9; }
        .navbar { background-color: #FF5733; padding: 1rem; position: fixed; width: 100%; z-index: 1000; }
        .navbar-brand, .nav-link { color: #FFD700 !important; font-weight: bold; }
        .category-nav { background-color: #fff; border-bottom: 1px solid #ddd; padding: 0.5rem 0; margin-top: 60px; }
        .category-nav .nav-link { color: #FF5733; }
        .category-nav .nav-link.active { background-color: #FF5733; color: #FFD700 !important; }
        .product-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; padding: 2rem; }
        .product-card { background: #fff; border: 1px solid #ddd; border-radius: 8px; padding: 1rem; text-align: center; }
        .product-card img { width: 100%; height: 200px; object-fit: contain; }
        .btn-custom { background-color: #FFA500; color: #fff; border: none; padding: 0.75rem; font-size: 1rem; width: 100%; min-height: 48px; }
        .section-title { font-family: 'Lora', serif; color: #FF5733; text-align: center; margin: 2rem 0; }
        .alert { margin: 1rem 0; }
        footer { background-color: #FF5733; color: #FFD700; padding: 1rem; text-align: center; }
        @media (max-width: 768px) {
            .category-nav { margin-top: 56px; }
            .product-grid { padding: 1rem; }
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
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="categoryDropdown" data-bs-toggle="dropdown">Products</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="products.php?category=Decor">Decor</a></li>
                            <li><a class="dropdown-item" href="products.php?category=Textiles">Textiles</a></li>
                            <li><a class="dropdown-item" href="products.php?category=Food">Food</a></li>
                            <li><a class="dropdown-item" href="products.php?category=Personal Care">Personal Care</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="index-after-login.php#artisans">Artisans</a></li>
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

    <!-- Category Filter Navigation -->
    <nav class="category-nav">
        <div class="container">
            <ul class="nav justify-content-center">
                <li class="nav-item">
                    <a class="nav-link <?php echo !$selected_category ? 'active' : ''; ?>" href="products.php">All</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $selected_category === 'Decor' ? 'active' : ''; ?>" href="products.php?category=Decor">Decor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $selected_category === 'Textiles' ? 'active' : ''; ?>" href="products.php?category=Textiles">Textiles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $selected_category === 'Food' ? 'active' : ''; ?>" href="products.php?category=Food">Food</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $selected_category === 'Personal Care' ? 'active' : ''; ?>" href="products.php?category=Personal Care">Personal Care</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Product Grid -->
    <h2 class="section-title"><?php echo $selected_category ? htmlspecialchars($selected_category) : 'All Products'; ?></h2>
    <?php if ($success): ?>
        <div class="alert alert-success text-center" role="alert"><?php echo $success; ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert alert-danger text-center" role="alert"><?php echo $error; ?></div>
    <?php endif; ?>
    <?php if (empty($products)): ?>
        <div class="alert alert-info text-center" role="alert">No products found in this category.</div>
    <?php else: ?>
        <div class="product-grid">
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <img src="https://via.placeholder.com/250x200?text=<?php echo urlencode($product['name']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <h5><?php echo htmlspecialchars($product['name']); ?></h5>
                    <p>KES <?php echo number_format($product['price'], 2); ?></p>
                    <form method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <button type="submit" class="btn btn-custom">Add to Cart</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

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