<?php
session_start();
require_once 'functions.php';


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JuaKali Hub: Discover Authentic Kenyan Crafts</title>
    <meta name="description" content="Explore a curated collection of unique, handcrafted goods made by talented Kenyan artisans. Support local craftsmanship and discover authentic JuaKali creations. Join our community of makers and buyers.">
    <meta name="keywords" content="JuaKali, artisans, Kenya, handcrafted, unique, crafts, local, makers, buy, sell, marketplace, art, jewelry, clothing, home decor">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;700&family=Lora:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body { font-family: 'Ubuntu', sans-serif; background-color: #f8f1e9; color: #333; }
        .navbar { background-color: #FF5733; padding: 1rem 0; }
        .navbar-brand { color: #FFD700 !important; font-weight: bold; font-size: 1.5rem; }
        .nav-link { color: #FFD700 !important; font-weight: 500; margin-left: 1rem; }
        .hero { padding: 5rem 2rem; text-align: center; background-color: #fff; margin-bottom: 4rem; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
        .hero h1 { font-family: 'Lora', serif; color: #FF5733; margin-bottom: 1.5rem; font-size: 2.5rem; }
        .hero p { font-size: 1.1rem; color: #555; line-height: 1.7; margin-bottom: 2rem; }
        .section-title { font-family: 'Lora', serif; color: #FF5733; text-align: center; margin-bottom: 3rem; font-size: 2rem; }
        .btn-custom { background-color: #FFA500; color: #fff; border: none; padding: 0.8rem 2rem; font-size: 1.2rem; min-height: 50px; border-radius: 6px; transition: background-color 0.3s ease; }
        .btn-custom:hover { background-color: #cc8400; }
        .featured-section, .popular-section, .categories-section, .spotlights-section, .benefits-section { padding: 4rem 2rem; background-color: #fff; margin-bottom: 4rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
        .featured-item, .popular-item { text-align: center; margin-bottom: 2.5rem; }
        .featured-item img, .popular-item img { max-width: 100%; height: auto; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); transition: transform 0.2s ease-in-out; }
        .featured-item img:hover, .popular-item img:hover { transform: scale(1.05); }
        .featured-artisans img { width: 120px; height: 120px; border-radius: 50%; object-fit: cover; margin-bottom: 1rem; box-shadow: 0 2px 6px rgba(0,0,0,0.15); }
        .category-item { text-align: center; margin-bottom: 2rem; }
        .category-item a { text-decoration: none; color: #333; transition: color 0.2s ease-in-out; display: block; }
        .category-item a:hover { color: #FF5733; }
        .category-item img { max-width: 100px; height: 100px; object-fit: cover; border-radius: 50%; margin-bottom: 0.75rem; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
        .spotlight-item { margin-bottom: 3rem; border-bottom: 1px solid #eee; padding-bottom: 2.5rem; }
        .spotlight-item:last-child { border-bottom: none; }
        .spotlight-item h4 { color: #FF5733; margin-bottom: 0.75rem; }
        .spotlight-item p.author { color: #777; font-size: 0.9rem; margin-bottom: 0.5rem; }
        .benefits-list { list-style: none; padding-left: 0; }
        .benefits-list li { display: flex; align-items: center; margin-bottom: 1.5rem; }
        .benefits-list li i { font-size: 1.5rem; color: #FFA500; margin-right: 1rem; } /* You might need to include a font awesome or similar library for icons */
        .benefits-list li span { font-weight: bold; color: #333; }
        footer { background-color: #FF5733; color: #FFD700; padding: 2rem 0; text-align: center; font-size: 0.9rem; }
        footer p { margin-bottom: 0.5rem; }
        footer a { color: #FFD700; text-decoration: underline; }
        @media (max-width: 768px) {
            .hero { padding: 3rem 1rem; }
            .hero h1 { font-size: 2rem; }
            .hero p { font-size: 1rem; }
            .navbar-brand { font-size: 1.2rem; }
            .nav-link { font-size: 0.9rem; margin-left: 0.5rem; }
            .section-title { font-size: 1.75rem; margin-bottom: 2.5rem; }
            .featured-item, .popular-item, .category-item, .spotlight-item { margin-bottom: 2rem; }
            .benefits-list li { flex-direction: column; align-items: flex-start; }
            .benefits-list li i { margin-bottom: 0.5rem; margin-right: 0; }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="index.php">JuaKali</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="products.php">Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>
                        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="artisan/artisan-signup.php">Become an Artisan</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="hero container">
        <h1 class="hero-title">Discover the Soul of Kenyan Craftsmanship</h1>
        <p class="hero-subtitle">Immerse yourself in a vibrant marketplace connecting you with the skilled hands and creative hearts of Kenyan artisans. Explore unique, handcrafted treasures made with passion and tradition.</p>
        <div class="d-flex justify-content-center mt-4">
            <a href="products.php" class="btn btn-custom me-3">Explore Unique Products</a>
            <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="artisan-signup.php" class="btn btn-outline-secondary">Join Our Artisan Community</a>
            <?php endif; ?>
        </div>
    </header>

    <section class="featured-section container">
        <h2 class="section-title">Meet Some of Our Featured Artisans</h2>
        <p class="lead text-center mb-4">Get to know the talented individuals behind the exceptional crafts you'll find on JuaKali Hub.</p>
        <div class="row justify-content-center">
            <?php if (!empty($featuredArtisans)): ?>
                <?php foreach ($featuredArtisans as $artisan): ?>
                    <div class="col-md-4 col-lg-3 featured-item">
                        <img src="<?php echo htmlspecialchars($artisan['profile_image_url'] ?? 'images/default_profile.png'); ?>" alt="<?php echo htmlspecialchars($artisan['name']); ?>" class="img-fluid rounded-circle shadow-sm mb-3">
                        <h4><?php echo htmlspecialchars($artisan['name']); ?></h4>
                        <p class="text-muted"><?php echo htmlspecialchars(substr($artisan['bio'] ?? 'No bio available.', 0, 80)) . '...'; ?></p>
                        <p><a href="artisan-profile.php?id=<?php echo $artisan['id']; ?>" class="btn btn-sm btn-outline-info">View Artisan Profile</a></p>
                    </div>
                <?php endforeach; ?>
                <div class="text-center mt-4">
                    <a href="artisans.php" class="btn btn-outline-secondary">Discover All Artisans</a>
                </div>
            <?php else: ?>
                <p class="text-center">No featured artisans currently available. Stay tuned for updates!</p>
            <?php endif; ?>
        </div>
    </section>

    <section class="popular-section bg-light container">
        <h2 class="section-title">Trending Handcrafted Products</h2>
        <p class="lead text-center mb-4">Discover some of the most loved and sought-after creations from our community of artisans.</p>
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
            <?php if (!empty($popularProducts)): ?>
                <?php foreach ($popularProducts as $product): ?>
                    <div class="col popular-item">
                        <div class="card h-100 shadow-sm">
                            <img src="<?php echo htmlspecialchars($product['image_url'] ?? 'images/default_product.png'); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                                <p class="card-text text-muted"><?php echo htmlspecialchars(substr($product['description'] ?? 'A beautiful handcrafted item.', 0, 60)) . '...'; ?></p>
                                <p class="card-text fw-bold">KES <?php echo number_format($product['price'], 2); ?></p>
                                <a href="product-details.php?id=<?php echo $product['id']; ?>" class="btn btn-sm btn-outline-primary">View Product Details</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="text-center mt-4">
                    <a href="products.php" class="btn btn-outline-secondary">Explore Our Full Product Range</a>
                </div>
            <?php else: ?>
                <p class="text-center">No trending products available at the moment. Check back soon for new arrivals!</p>
            <?php endif; ?>
        </div>
    </section>

    <section class="categories-section container">
        <h2 class="section-title">Explore Crafts by Category</h2>
        <p class="lead text-center mb-4">Browse our diverse selection of handcrafted goods, organized by category to help you find exactly what you're looking for.</p>
        <div class="row justify-content-center">
            <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $category): ?>
                    <div class="col-md-4 col-lg-2 category-item">
                        <a href="category.php?id=<?php echo $category['id']; ?>">
                            <img src="<?php echo htmlspecialchars($category['image_url'] ?? 'images/default_category.png'); ?>" alt="<?php echo htmlspecialchars($category['name']); ?>" class="img-fluid rounded-circle shadow-sm">
                            <h4><?php echo htmlspecialchars($category['name']); ?></h4>
                        </a>
                    </div>
                <?php endforeach; ?>
                <div class="text-center mt-4">
                    <a href="categories.php" class="btn btn-outline-secondary">View All Categories</a>
                </div>
            <?php else: ?>
                <p class="text-center">No product categories available yet. We are constantly adding new crafts!</p>
            <?php endif; ?>
        </div>
    </section>

    <section class="spotlights-section bg-light container">
        <h2 class="section-title">Artisan Spotlights & Stories</h2>
        <p class="lead text-center mb-4">Discover the inspiring stories, creative processes, and unique journeys of the artisans who bring JuaKali Hub to life.</p>
        <div class="row">
            <?php if (!empty($spotlights)): ?>
                <?php foreach ($spotlights as $spotlight): ?>
                    <div class="col-md-6 spotlight-item">
                        <h4><?php echo htmlspecialchars($spotlight['title']); ?></h4>
                        <p class="author">By <?php echo htmlspecialchars($spotlight['author_name'] ?? 'JuaKali Team'); ?> | Published on <?php echo date('F j, Y', strtotime($spotlight['created_at'])); ?></p>
                        <p><?php echo htmlspecialchars(substr($spotlight['content'], 0, 200)) . '...'; ?></p>
                        <a href="spotlight.php?id=<?php echo $spotlight['id']; ?>" class="btn btn-sm btn-outline-info">Read Full Story</a>
                    </div>
                <?php endforeach; ?>
                <div class="text-center mt-4">
                    <a href="stories.php" class="btn btn-outline-secondary">Explore More Artisan Stories</a>
                </div>
            <?php else: ?>
                <p class="text-center">No artisan spotlights or stories available at this time.  Check back soon!</p>
            <?php endif; ?>
        </div>
    </section>

    <section class="benefits-section container">
        <h2 class="section-title">Why Choose JuaKali?</h2>
        <p class="lead text-center mb-4">We offer a platform that empowers artisans and connects you with truly special, handcrafted goods.</p>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <ul class="benefits-list">
                    <li><i class="bi bi-heart-fill"></i> <span>Support Local Artisans:</span> Directly contribute to the livelihoods and growth of talented Kenyan craftspeople.</li>
                    <li><i class="bi bi-unique-fill"></i> <span>Discover Unique Creations:</span> Find one-of-a-kind items you won't find in mass-produced retail.</li>
                    <li><i class="bi bi-hand-heart-fill"></i><span>Ethical and Sustainable:</span>  Connect with artisans who prioritize sustainable practices and ethical sourcing.</li>
                    <li><i class="bi bi-globe"></i> <span>Kenyan Craftsmanship, Global Reach:</span>  Bringing the best of Kenyan artistry to a worldwide audience.</li>
                    <li><i class="bi bi-people-fill"></i> <span>Connect with Creators:</span>  Build relationships with the artisans behind your cherished items.</li>
                </ul>
            </div>
        </div>
    </section>

    <footer class="mt-5">
        <p>© 2025 JuaKali Hub. All rights reserved.</p>
        <p>
            <a href="terms.php">Terms of Service</a> | <a href="privacy.php">Privacy Policy</a> | <a href="contact.html">Contact Us</a>
        </p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    
        $(document).ready(function(){
            
             $('.category-item img').hover(
                function(){
                    $(this).css('transform', 'scale(1.1)'); 
                    $(this).css('box-shadow', '0 4px 12px rgba(0,0,0,0.2)');
                },
                function(){
                    $(this).css('transform', 'scale(1)');
                    $(this).css('box-shadow', '0 2px 6px rgba(0,0,0,0.1)');
                }
             );
        });
    </script>
</body>
</html>
