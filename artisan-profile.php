<?php
session_start();
require_once 'functions.php';

if (!isset($_GET['id'])) {
    header("Location: 404.html");
    exit();
}

$artisan = getArtisanById($_GET['id']);
if (!$artisan) {
    header("Location: 404.html");
    exit();
}

$products = getArtisanProducts($artisan['id']);
$ratings = getRatings($artisan['id']);
$user_id = $_SESSION['user_id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($user_id && isset($_POST['rating']) && isset($_POST['comment'])) {
        addRating($artisan['id'], $user_id, $_POST['rating'], $_POST['comment']);
        header("Location: artisan-profile.php?id=" . $artisan['id']);
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
        .navbar { background-color: #FF5733; padding: 1rem; }
        .navbar-brand, .nav-link { color: #FFD700 !important; font-weight: bold; }
        .artisan-profile { padding: 2rem; }
        .artisan-image { width: 100%; height: 200px; object-fit: contain; background: #f0f0f0; padding: 1rem; border-radius: 8px; }
        .product-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; }
        .product-card { background: #fff; border: 1px solid #ddd; border-radius: 8px; padding: 1rem; text-align: center; }
        .product-card img { width: 100%; height: 200px; object-fit: contain; }
        .btn-custom { background-color: #FFA500; color: #fff; border: none; padding: 0.75rem; font-size: 1rem; width: 100%; min-height: 48px; }
        .rating-stars { color: #FFD700; font-size: 1.5rem; }
        @media (max-width: 768px) { .artisan-profile { padding: 1rem; } .artisan-image { height: 150px; } .product-grid { grid-template-columns: 1fr; gap: 1rem; } .navbar-brand, .nav-link { font-size: 0.9rem; } .btn-custom { font-size: 0.9rem; padding: 0.5rem; } }
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
    <div class="artisan-profile">
        <h2 class="text-center my-4" style="font-family: 'Lora', serif; color: #FF5733;"><?php echo $artisan['name']; ?>'s Profile</h2>
        <div class="row">
            <div class="col-md-4">
                <img src="<?php echo $artisan['image_url'] ?? 'https://via.placeholder.com/300x200?text=Artisan+Photo'; ?>" alt="Artisan Photo" class="artisan-image">
            </div>
            <div class="col-md-8">
                <h5>About <?php echo $artisan['name']; ?></h5>
                <p><?php echo $artisan['bio'] ?? 'No bio available.'; ?></p>
                <p><strong>Location:</strong> <?php echo $artisan['location'] ?? 'Not specified'; ?></p>
                <p><strong>Average Rating:</strong> 
                    <?php
                    $stars = floor($artisan['average_rating']);
                    for ($i = 0; $i < 5; $i++) {
                        echo $i < $stars ? '★' : '☆';
                    }
                    echo " ($artisan[average_rating])";
                    ?>
                </p>
            </div>
        </div>
        <h5 class="mt-4">Products by <?php echo $artisan['name']; ?></h5>
        <div class="product-grid">
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <img src="https://via.placeholder.com/250x200?text=<?php echo urlencode($product['name']); ?>" alt="<?php echo $product['name']; ?>">
                    <h5><?php echo $product['name']; ?></h5>
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
        </div>
        <h5 class="mt-4">Ratings & Reviews</h5>
        <?php if (!empty($ratings)): ?>
            <?php foreach ($ratings as $rating): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <p class="card-text"><strong><?php echo $rating['name']; ?>:</strong> 
                            <?php for ($i = 0; $i < 5; $i++) echo $i < $rating['rating'] ? '★' : '☆'; ?>
                            (<?php echo $rating['rating']; ?>)
                        </p>
                        <p class="card-text"><?php echo $rating['comment'] ?? 'No comment.'; ?></p>
                        <p class="card-text"><small><?php echo $rating['created_at']; ?></small></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No ratings yet.</p>
        <?php endif; ?>
        <?php if ($user_id): ?>
            <h5 class="mt-4">Add Your Rating</h5>
            <form method="POST">
                <div class="mb-3">
                    <label for="rating" class="form-label">Rating</label>
                    <select class="form-control" id="rating" name="rating" required>
                        <option value="1">1 ★</option>
                        <option value="2">2 ★★</option>
                        <option value="3">3 ★★★</option>
                        <option value="4">4 ★★★★</option>
                        <option value="5">5 ★★★★★</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="comment" class="form-label">Comment (Optional)</label>
                    <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-custom">Submit Rating</button>
            </form>
        <?php else: ?>
            <p><a href="login.php">Login</a> to rate this artisan.</p>
        <?php endif; ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>