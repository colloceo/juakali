<?php
session_start();
require_once 'functions.php';

if (!isset($_GET['id'])) {
    header("Location: 404.php");
    exit();
}

$artisan_id = (int)$_GET['id'];
$artisan = getArtisanById($artisan_id);
if (!$artisan) {
    header("Location: 404.php");
    exit();
}

$products = getArtisanProducts($artisan_id);
$ratings = getRatings($artisan_id);
$user_id = $_SESSION['user_id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($user_id && isset($_POST['rating'])) {
        $rating = (int)$_POST['rating'];
        $comment = $_POST['comment'] ?? null;
        if ($rating >= 1 && $rating <= 5) {
            addRating($artisan_id, $user_id, $rating, $comment);
        }
        header("Location: artisan-profile.php?id=$artisan_id");
        exit();
    } elseif ($user_id && isset($_POST['product_id'])) {
        addToCart($user_id, $_POST['product_id'], 1);
        header("Location: cart.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JuaKali - Artisan Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;700&family=Lora:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Ubuntu', sans-serif; background-color: #f8f1e9; }
        .navbar { background-color: #FF5733; padding: 1rem;}
        .navbar-brand, .nav-link { color: #FFD700 !important; font-weight: bold; }
        .profile-container { padding: 2rem; }
        .profile-header { text-align: center; margin-bottom: 2rem; }
        .profile-image { width: 100%; max-width: 300px; height: auto; border-radius: 8px; }
        .product-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; padding: 2rem; }
        .product-card { background: #fff; border: 1px solid #ddd; border-radius: 8px; padding: 1rem; text-align: center; }
        .product-card img { width: 100%; height: 200px; object-fit: contain; }
        .rating-section, .products-section { margin: 2rem 0; }
        .btn-custom { background-color: #FFA500; color: #fff; border: none; padding: 0.75rem; font-size: 1rem; min-height: 48px; width: 100%; }
        .section-title { font-family: 'Lora', serif; color: #FF5733; text-align: center; margin: 2rem 0; }
        .rating-form { max-width: 500px; margin: 0 auto; }
        .rating-stars { display: flex; justify-content: center; gap: 0.5rem; }
        .rating-stars input { display: none; }
        .rating-stars label { font-size: 1.5rem; color: #ddd; cursor: pointer; }
        .rating-stars input:checked ~ label, .rating-stars label:hover, .rating-stars label:hover ~ label { color: #FFA500; }
        footer { background-color: #FF5733; color: #FFD700; padding: 1rem; text-align: center; }
        @media (max-width: 768px) {
            .profile-container, .product-grid { padding: 1rem; }
            .profile-image { max-width: 200px; }
            .navbar-brand, .nav-link { font-size: 0.9rem; }
            .btn-custom { font-size: 0.9rem; padding: 0.5rem; }
        }
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
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="categoryDropdown" data-bs-toggle="dropdown">Products</a>
                        <ul class="dropdown-menu">
                             <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                             <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                             <li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
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
                            <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="signup.php">Sign Up</a></li>
                    <?php endif; ?>
                        </ul>
            </div>
        </div>
    </nav>

    <div class="profile-container">
        <div class="profile-header">
            <h2 class="section-title"><?php echo htmlspecialchars($artisan['name']); ?>'s Profile</h2>
            <img src="<?php echo htmlspecialchars($artisan['image_url'] ?? 'https://via.placeholder.com/300x200?text=Artisan+Photo'); ?>" alt="Artisan Photo" class="profile-image">
            <p><strong>Location:</strong> <?php echo htmlspecialchars($artisan['location'] ?? 'Not specified'); ?></p>
            <p><strong>Bio:</strong> <?php echo htmlspecialchars($artisan['bio'] ?? 'No bio available.'); ?></p>
            <p><strong>Average Rating:</strong> 
                <?php
                $average_rating = $artisan['average_rating'] ?? 0;
                $stars = floor($average_rating);
                for ($i = 0; $i < 5; $i++) {
                    echo $i < $stars ? '★' : '☆';
                }
                echo " (" . number_format($average_rating, 1) . ")";
                ?>
            </p>
        </div>

        <div class="products-section">
            <h3 class="section-title">Products by <?php echo htmlspecialchars($artisan['name']); ?></h3>
            <div class="product-grid">
                <?php if (empty($products)): ?>
                    <p>No products available.</p>
                <?php else: ?>
                    <?php foreach ($products as $product): ?>
                        <div class="product-card">
                            <img src="https://via.placeholder.com/250x200?text=<?php echo urlencode($product['name']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                            <h5><?php echo htmlspecialchars($product['name']); ?></h5>
                            <p>KES <?php echo number_format($product['price'], 2); ?></p>
                            <?php if ($user_id): ?>
                                <form method="POST">
                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                    <button type="submit" class="btn btn-custom">Add to Cart</button>
                                </form>
                            <?php else: ?>
                                <a href="login.php" class="btn btn-custom">Login to Add to Cart</a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="rating-section">
            <h3 class="section-title">Ratings & Reviews</h3>
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="rating-form">
                    <form method="POST">
                        <div class="mb-3 rating-stars">
                            <input type="radio" id="star5" name="rating" value="5" required><label for="star5">★</label>
                            <input type="radio" id="star4" name="rating" value="4"><label for="star4">★</label>
                            <input type="radio" id="star3" name="rating" value="3"><label for="star3">★</label>
                            <input type="radio" id="star2" name="rating" value="2"><label for="star2">★</label>
                            <input type="radio" id="star1" name="rating" value="1"><label for="star1">★</label>
                        </div>
                        <div class="mb-3">
                            <label for="comment" class="form-label">Comment (optional)</label>
                            <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-custom">Submit Rating</button>
                    </form>
                </div>
            <?php else: ?>
                <p><a href="login.php">Login</a> to leave a rating.</p>
            <?php endif; ?>

            <div class="ratings-list mt-4">
                <?php if (empty($ratings)): ?>
                    <p>No ratings yet.</p>
                <?php else: ?>
                    <?php foreach ($ratings as $rating): ?>
                        <div class="card mb-3">
                            <div class="card-body">
                                <p><strong><?php echo htmlspecialchars($rating['name']); ?>:</strong> 
                                    <?php for ($i = 0; $i < 5; $i++) echo $i < $rating['rating'] ? '★' : '☆'; ?>
                                    (<?php echo $rating['rating']; ?>/5)
                                </p>
                                <p><?php echo htmlspecialchars($rating['comment'] ?? 'No comment.'); ?></p>
                                <p><small>Posted on <?php echo date('F j, Y', strtotime($rating['created_at'])); ?></small></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <footer>
        <p>© 2025 JuaKali. All rights reserved.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>