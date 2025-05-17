<?php
session_start();
require_once 'functions.php';

$products = $pdo->query("SELECT * FROM products WHERE status = 'Approved' LIMIT 6")->fetchAll(PDO::FETCH_ASSOC);
$artisans = getAllArtisans();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JuaKali - Discover Kenyan Artisans</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;700&family=Lora:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Ubuntu', sans-serif; background-color: #f8f1e9; }
        .navbar { background-color: #FF5733; padding: 1rem; }
        .navbar-brand, .nav-link { color: #FFD700 !important; font-weight: bold; }
        .hero-section { background: url('https://via.placeholder.com/1200x400?text=Kenyan+Craftsmanship') no-repeat center; background-size: cover; color: #fff; padding: 5rem 0; text-align: center; }
        .hero-section h1 { font-family: 'Lora', serif; font-size: 3rem; text-shadow: 2px 2px 4px rgba(0,0,0,0.5); }
        .product-grid, .artisan-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; padding: 2rem; }
        .product-card, .artisan-card { background: #fff; border: 1px solid #ddd; border-radius: 8px; padding: 1rem; text-align: center; }
        .product-card img, .artisan-card img { width: 100%; height: 200px; object-fit: contain; }
        .btn-custom { background-color: #FFA500; color: #fff; border: none; padding: 0.75rem; font-size: 1rem; width: 100%; min-height: 48px; }
        .section-title { font-family: 'Lora', serif; color: #FF5733; text-align: center; margin: 2rem 0; }
        footer { background-color: #FF5733; color: #FFD700; padding: 1rem; text-align: center; }
       
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">JuaKali</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                 <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    <!-- <li class="nav-item"><a class="nav-link" href="signup.html">Sign Up</a></li> -->
                </ul>
            </div>
        </div>
    </nav>

    <div class="hero-section">
        <h1>Discover Authentic Kenyan Craftsmanship</h1>
        <p>Support local artisans by shopping handcrafted products on JuaKali.</p>
        <a href="signup.php" class="btn btn-custom">Get Started</a>
    </div>

    <h2 class="section-title" id="products">Featured Products</h2>
    <div class="product-grid">
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <img src="https://via.placeholder.com/250x200?text=<?php echo urlencode($product['name']); ?>" alt="<?php echo $product['name']; ?>">
                <h5><?php echo $product['name']; ?></h5>
                <p>KES <?php echo number_format($product['price'], 2); ?></p>
                <a href="login.php" class="btn btn-custom">Login to Add to Cart</a>
            </div>
        <?php endforeach; ?>
    </div>

    <h2 class="section-title" id="artisans">Meet Our Artisans</h2>
    <div class="artisan-grid">
        <?php foreach ($artisans as $artisan): ?>
            <div class="artisan-card">
                <img src="<?php echo $artisan['image_url'] ?? 'https://via.placeholder.com/250x200?text=Artisan+Photo'; ?>" alt="<?php echo $artisan['name']; ?>">
                <h5><?php echo $artisan['name']; ?></h5>
                <p><?php echo $artisan['location'] ?? 'Location not specified'; ?></p>
                <a href="artisan-profile.php?id=<?php echo $artisan['id']; ?>" class="btn btn-custom">View Profile</a>
            </div>
        <?php endforeach; ?>
    </div>

    <footer>
        <p>&copy; 2025 JuaKali. All rights reserved.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>