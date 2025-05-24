<?php
session_start();
require_once 'functions.php'; // Assumes this file contains PDO connection and other necessary functions

// Determine if the user is logged in
$is_logged_in = isset($_SESSION['user_id']);
$user_id = $is_logged_in ? $_SESSION['user_id'] : null; // Get user ID if logged in

// Redirect if product ID is not provided
if (!isset($_GET['id'])) {
    header("Location: index.php"); // Redirect to generic index page
    exit();
}

$product_id = (int)$_GET['id'];

// Fetch product details and artisan information
$stmt = $pdo->prepare("SELECT p.*, a.id AS artisan_id, a.name AS artisan_name 
                        FROM products p 
                        JOIN artisans a ON p.artisan_id = a.id 
                        WHERE p.id = ? AND p.status = 'Approved'");
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

// Redirect if product not found or not approved
if (!$product) {
    header("Location: index.php"); // Redirect to generic index page
    exit();
}

// Fetch related products (same category, exclude current product, limit to 4)
$category = $product['category'];
$stmt = $pdo->prepare("SELECT * FROM products 
                        WHERE category = ? AND id != ? AND status = 'Approved' 
                        LIMIT 4");
$stmt->execute([$category, $product_id]);
$related_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JuaKali - <?php echo htmlspecialchars($product['name']); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            padding-top: 112px; /* height of fixed navbar + categories */
            padding-bottom: 56px; /* height of fixed bottom nav on mobile */
        }
        .product-card:hover {
            cursor: pointer;
            border-color: #4f46e5; /* Indigo-600 */
        }
    </style>
</head>
<body class="bg-white text-gray-900">
    <header class="fixed top-0 left-0 right-0 bg-white border-b border-gray-200 z-50">
        <div class="max-w-7xl mx-auto flex items-center justify-center py-3 px-4 sm:px-6 lg:px-8 border-b border-gray-200">
            <form aria-label="Search products" class="w-full max-w-3xl" role="search" action="products.php" method="GET">
                <label class="sr-only" for="search-input">Search products</label>
                <div class="relative text-gray-600 focus-within:text-gray-900">
                    <input aria-describedby="search-desc" class="block w-full rounded border border-gray-300 py-2 pl-10 pr-4 text-sm placeholder-gray-400 focus:border-indigo-600 focus:outline-none focus:ring-1 focus:ring-indigo-600" id="search-input" name="search" placeholder="Search products..." type="search">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fas fa-search text-gray-400 text-sm"></i>
                    </div>
                </div>
                <p class="sr-only" id="search-desc">Enter product name to search</p>
            </form>
        </div>
        <div class="max-w-7xl mx-auto flex items-center justify-between py-3 px-4 sm:px-6 lg:px-8">
            <div class="text-lg font-semibold truncate flex-shrink-0">
                JuaKali
            </div>
            <nav class="hidden sm:flex flex-wrap gap-6 text-xs font-semibold text-gray-600 justify-center flex-1 px-6">
                <a class="text-indigo-900 border-b-2 border-indigo-900 pb-1" href="index.php">All</a>
                <a class="hover:text-indigo-900" href="index.php?category=Decor">Decor</a>
                <a class="hover:text-indigo-900" href="index.php?category=Textiles">Textiles</a>
                <a class="hover:text-indigo-900" href="index.php?category=Food">Food</a>
                <a class="hover:text-indigo-900" href="index.php?category=Personal Care">Personal Care</a>
            </nav>
            <div class="hidden sm:flex items-center space-x-6 flex-shrink-0 text-gray-600 text-sm">
                <?php if ($is_logged_in): ?>
                    <a href="index-after-login.php" aria-label="Home" class="flex items-center space-x-1 hover:text-indigo-900 focus:outline-none">
                    <i class="fas fa-home text-lg"></i>
                    <span></span>
                </a>
                <a href="products.php" aria-label="Store" class="flex items-center space-x-1 hover:text-indigo-900 focus:outline-none">
                    <i class="fas fa-store text-lg"></i>
                    <span></span>
                </a>
                <a href="cart.php" aria-label="Cart" class="flex items-center space-x-1 hover:text-indigo-900 focus:outline-none">
                    <i class="fas fa-shopping-cart text-lg"></i>
                    <span></span>
                </a>
                 <div class="relative group">
    <a href="#" aria-label="Account" class="flex items-center space-x-1 hover:text-indigo-900 focus:outline-none rounded-md px-2 py-1" id="account-dropdown-toggle">
        <i class="fas fa-user text-lg"></i>
        <span></span>
    </a>

    <div id="account-dropdown-menu" class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg py-1 z-10 hidden group-hover:block">
        <a href="account.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Profile</a>
        <a href="logout.php" class="block px-4 py-2 text-red-600 hover:bg-red-50">Logout</a>
    </div>
</div>
                <?php else: ?>
                    <a href="login.php" aria-label="Login" class="flex items-center space-x-1 hover:text-indigo-900 focus:outline-none">
                        <i class="fas fa-user text-lg"></i>
                        <span>Login</span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <nav class="sm:hidden flex flex-wrap gap-3 text-xs font-semibold text-gray-600 justify-center border-t border-gray-200 py-2">
            <a class="text-indigo-900 border-b-2 border-indigo-900 pb-1" href="index.php">All</a>
            <a class="hover:text-indigo-900" href="index.php?category=Decor">Decor</a>
            <a class="hover:text-indigo-900" href="index.php?category=Textiles">Textiles</a>
            <a class="hover:text-indigo-900" href="index.php?category=Food">Food</a>
            <a class="hover:text-indigo-900" href="index.php?category=Personal Care">Personal Care</a>
        </nav>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex flex-col sm:flex-row gap-6">
            <div class="w-full sm:w-1/2">
                <img alt="<?php echo htmlspecialchars($product['name']); ?>" class="w-full h-64 object-contain rounded-lg border border-gray-200" src="https://placehold.co/400x400/E0E7FF/4338CA?text=<?php echo urlencode($product['name']); ?>">
            </div>
            <div class="w-full sm:w-1/2">
                <h1 class="text-xl font-semibold text-gray-900 mb-2"><?php echo htmlspecialchars($product['name']); ?></h1>
                <p class="text-lg text-gray-600 mb-2">KES <?php echo number_format($product['price'], 2); ?></p>
                <p class="text-sm text-gray-600 mb-4"><?php echo htmlspecialchars($product['description'] ?? 'No description available.'); ?></p>
                <p class="text-sm text-gray-600 mb-4">
                    Artisan: <a href="artisan_profile.php?id=<?php echo $product['artisan_id']; ?>" class="text-indigo-600 hover:text-indigo-900"><?php echo htmlspecialchars($product['artisan_name']); ?></a>
                </p>
                <div class="flex space-x-4">
                    <?php if ($is_logged_in): ?>
                        <a href="cart.php?action=add&product_id=<?php echo $product['id']; ?>" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                            <i class="fas fa-shopping-cart mr-2"></i><!--Add to Cart-->
                        </a>
                        <a href="wishlist.php?action=add&product_id=<?php echo $product['id']; ?>" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                            <i class="fas fa-heart mr-2"></i><!--Add to Wishlist-->
                        </a>
                    <?php else: ?>
                        <a href="login.php?redirect=cart&product_id=<?php echo $product['id']; ?>" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                            <i class="fas fa-shopping-cart mr-2"></i><!--Add to Cart-->
                        </a>
                        <a href="login.php?redirect=wishlist&product_id=<?php echo $product['id']; ?>" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                            <i class="fas fa-heart mr-2"></i><!--Add to Wishlist-->
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php if (!empty($related_products)): ?>
            <section class="mt-10">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Related Products</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                    <?php foreach ($related_products as $related_product): ?>
                        <div class="product-card border border-gray-200 rounded p-2 relative flex flex-col items-center" onclick="window.location.href='product_details.php?id=<?php echo $related_product['id']; ?>'">
                            <?php
                            // Determine badge based on product status
                            $badge = '';
                            $badge_class = '';
                            $quantity = isset($related_product['quantity']) ? (int)$related_product['quantity'] : 0;
                            $created_at = isset($related_product['created_at']) ? strtotime($related_product['created_at']) : time();
                            $price = isset($related_product['price']) ? (float)$related_product['price'] : 0;

                            if ($quantity <= 0) {
                                $badge = 'Sold Out';
                                $badge_class = 'bg-red-600 text-white';
                            } elseif ($created_at > strtotime('-7 days')) {
                                $badge = 'New';
                                $badge_class = 'bg-green-600 text-white';
                            } elseif ($price < 50) { // Example condition for 'Sale'
                                $badge = 'Sale';
                                $badge_class = 'bg-indigo-700 text-white';
                            } else {
                                $badge = 'Hot'; // Default badge
                                $badge_class = 'bg-yellow-400 text-gray-900';
                            }
                            ?>
                            <span class="absolute top-1 left-1 <?php echo $badge_class; ?> text-[9px] font-semibold px-1 rounded z-10">
                                <?php echo $badge; ?>
                            </span>
                            <img alt="<?php echo htmlspecialchars($related_product['name']); ?>" class="mb-2 w-20 h-20 object-contain" src="https://placehold.co/80x80/E0E7FF/4338CA?text=<?php echo urlencode($related_product['name']); ?>">
                            <div class="text-xs font-semibold text-gray-900 mb-1 text-center truncate w-full">
                                <?php echo htmlspecialchars($related_product['name']); ?>
                            </div>
                            <div class="text-xs text-gray-600 text-center w-full">
                                KES <?php echo number_format($related_product['price'], 2); ?>
                            </div>
                            <div class="mt-2 flex space-x-2">
                                <?php if ($is_logged_in): ?>
                                    <a href="cart.php?action=add&product_id=<?php echo $related_product['id']; ?>" class="text-indigo-600 hover:text-indigo-900 text-xs"><i class="fas fa-shopping-cart mr-1"></i>Add to Cart</a>
                                    <a href="wishlist.php?action=add&product_id=<?php echo $related_product['id']; ?>" class="text-indigo-600 hover:text-indigo-900 text-xs"><i class="fas fa-heart mr-1"></i>Add to Wishlist</a>
                                <?php else: ?>
                                    <a href="login.php?redirect=cart&product_id=<?php echo $related_product['id']; ?>" class="text-indigo-600 hover:text-indigo-900 text-xs"><i class="fas fa-shopping-cart mr-1"></i>Add to Cart</a>
                                    <a href="login.php?redirect=wishlist&product_id=<?php echo $related_product['id']; ?>" class="text-indigo-600 hover:text-indigo-900 text-xs"><i class="fas fa-heart mr-1"></i>Add to Wishlist</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>
    </main>

    <nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 z-50 sm:hidden">
        <ul class="flex justify-between text-xs text-gray-600">
            <li class="flex flex-col items-center justify-center py-1.5 w-full hover:text-indigo-900">
                <a href="index.php" aria-label="Home" class="flex flex-col items-center space-y-0.5 focus:outline-none">
                    <i class="fas fa-home text-lg"></i>
                    <span>Home</span>
                </a>
            </li>
            <li class="flex flex-col items-center justify-center py-1.5 w-full hover:text-indigo-900">
                <a href="products.php" aria-label="Categories" class="flex flex-col items-center space-y-0.5 focus:outline-none">
                    <i class="fas fa-th-large text-lg"></i>
                    <span>Categories</span>
                </a>
            </li>
            <li class="flex flex-col items-center justify-center py-1.5 w-full hover:text-indigo-900">
                <a href="cart.php" aria-label="Cart" class="flex flex-col items-center space-y-0.5 focus:outline-none">
                    <i class="fas fa-shopping-cart text-lg"></i>
                    <span>Cart</span>
                </a>
            </li>
            <?php if ($is_logged_in): ?>
                <li class="flex flex-col items-center justify-center py-1.5 w-full hover:text-indigo-900">
                    <a href="profile.php" aria-label="Account" class="flex flex-col items-center space-y-0.5 focus:outline-none">
                        <i class="fas fa-user text-lg"></i>
                        <span>Account</span>
                    </a>
                </li>
                <li class="flex flex-col items-center justify-center py-1.5 w-full hover:text-red-600 transition-colors duration-200">
                <a href="logout.php" aria-label="Logout" class="flex flex-col items-center space-y-0.5 focus:outline-none">
                    <i class="fas fa-sign-out-alt text-lg"></i>
                    <span>Logout</span>
                </a>
            </li>
            <?php else: ?>
                <li class="flex flex-col items-center justify-center py-1.5 w-full hover:text-indigo-900">
                    <a href="login.php" aria-label="Login" class="flex flex-col items-center space-y-0.5 focus:outline-none">
                        <i class="fas fa-user text-lg"></i>
                        <span>Login</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>

    <footer class="max-w-7xl mx-auto px-4 py-6 border-t border-gray-200 text-xs text-gray-500 sm:px-6 lg:px-8 mt-6">
        <div class="flex flex-col sm:flex-row justify-between items-center space-y-2 sm:space-y-0">
            <div class="truncate">
                © <?php echo date("Y"); ?> JuaKali
            </div>
            <div class="space-x-3">
                <a class="hover:text-indigo-900" href="privacy.php">Privacy</a>
                <a class="hover:text-indigo-900" href="terms.php">Terms</a>
                <a class="hover:text-indigo-900" href="contact.php">Contact</a>
            </div>
        </div>
    </footer>
</body>
</html>
