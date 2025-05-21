<?php
session_start();
require_once 'functions.php';

if (!isset($_GET['id'])) {
    header("Location: index-before-login.php");
    exit();
}

$artisan_id = (int)$_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM artisans WHERE id = ?");
$stmt->execute([$artisan_id]);
$artisan = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$artisan) {
    header("Location: index-before-login.php");
    exit();
}

// Fetch other products by this artisan
$stmt = $pdo->prepare("SELECT * FROM products WHERE artisan_id = ? AND status = 'Approved' LIMIT 4");
$stmt->execute([$artisan_id]);
$artisan_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JuaKali - Artisan Profile: <?php echo htmlspecialchars($artisan['name']); ?></title>
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
    <!-- Fixed top header -->
    <header class="fixed top-0 left-0 right-0 bg-white border-b border-gray-200 z-50">
        <!-- Top row: Search bar -->
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
        <!-- Second row: Logo left, categories center, cart/account right -->
        <div class="max-w-7xl mx-auto flex items-center justify-between py-3 px-4 sm:px-6 lg:px-8">
            <!-- Logo -->
            <div class="text-lg font-semibold truncate flex-shrink-0">
                JuaKali
            </div>
            <!-- Categories nav (desktop only) -->
            <nav class="hidden sm:flex flex-wrap gap-6 text-xs font-semibold text-gray-600 justify-center flex-1 px-6">
                <a class="text-indigo-900 border-b-2 border-indigo-900 pb-1" href="index-before-login.php">All</a>
                <a class="hover:text-indigo-900" href="index-before-login.php?category=Decor">Decor</a>
                <a class="hover:text-indigo-900" href="index-before-login.php?category=Textiles">Textiles</a>
                <a class="hover:text-indigo-900" href="index-before-login.php?category=Food">Food</a>
                <a class="hover:text-indigo-900" href="index-before-login.php?category=Personal Care">Personal Care</a>
            </nav>
            <!-- Cart and Account -->
            <div class="hidden sm:flex items-center space-x-6 flex-shrink-0 text-gray-600 text-sm">
                <a href="cart.php" aria-label="Cart" class="flex items-center space-x-1 hover:text-indigo-900 focus:outline-none">
                    <i class="fas fa-shopping-cart text-lg"></i>
                    <span>Cart</span>
                </a>
                <a href="login.php" aria-label="Account" class="flex items-center space-x-1 hover:text-indigo-900 focus:outline-none">
                    <i class="fas fa-user text-lg"></i>
                    <span>Login</span>
                </a>
            </div>
        </div>
        <!-- Mobile categories below search bar -->
        <nav class="sm:hidden flex flex-wrap gap-3 text-xs font-semibold text-gray-600 justify-center border-t border-gray-200 py-2">
            <a class="text-indigo-900 border-b-2 border-indigo-900 pb-1" href="index-before-login.php">All</a>
            <a class="hover:text-indigo-900" href="index-before-login.php?category=Decor">Decor</a>
            <a class="hover:text-indigo-900" href="index-before-login.php?category=Textiles">Textiles</a>
            <a class="hover:text-indigo-900" href="index-before-login.php?category=Food">Food</a>
            <a class="hover:text-indigo-900" href="index-before-login.php?category=Personal Care">Personal Care</a>
        </nav>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <h1 class="text-xl font-semibold text-gray-900 mb-4">Artisan Profile: <?php echo htmlspecialchars($artisan['name']); ?></h1>
        <div class="flex flex-col sm:flex-row gap-6">
            <div class="w-full sm:w-1/3">
                <img alt="Artisan profile image" class="w-full h-48 object-cover rounded-lg border border-gray-200" src="https://via.placeholder.com/200x200?text=Artisan+Photo">
            </div>
            <div class="w-full sm:w-2/3">
                <p class="text-sm text-gray-600 mb-4"><?php echo htmlspecialchars($artisan['bio'] ?? 'No bio available.'); ?></p>
            </div>
        </div>

        <!-- Other Products by Artisan -->
        <?php if (!empty($artisan_products)): ?>
            <section class="mt-10">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Other Products by <?php echo htmlspecialchars($artisan['name']); ?></h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                    <?php foreach ($artisan_products as $product): ?>
                        <div class="product-card border border-gray-200 rounded p-2 relative flex flex-col items-center" onclick="window.location.href='product_details.php?id=<?php echo $product['id']; ?>'">
                            <?php
                            $badge = '';
                            $badge_class = '';
                            $quantity = isset($product['quantity']) ? (int)$product['quantity'] : 0;
                            $created_at = isset($product['created_at']) ? strtotime($product['created_at']) : time();
                            $price = isset($product['price']) ? (float)$product['price'] : 0;

                            if ($quantity <= 0) {
                                $badge = 'Sold Out';
                                $badge_class = 'bg-red-600 text-white';
                            } elseif ($created_at > strtotime('-7 days')) {
                                $badge = 'New';
                                $badge_class = 'bg-green-600 text-white';
                            } elseif ($price < 50) {
                                $badge = 'Sale';
                                $badge_class = 'bg-indigo-700 text-white';
                            } else {
                                $badge = 'Hot';
                                $badge_class = 'bg-yellow-400 text-gray-900';
                            }
                            ?>
                            <span class="absolute top-1 left-1 <?php echo $badge_class; ?> text-[9px] font-semibold px-1 rounded z-10">
                                <?php echo $badge; ?>
                            </span>
                            <img alt="<?php echo htmlspecialchars($product['name']); ?>" class="mb-2 w-20 h-20 object-contain" src="https://via.placeholder.com/80x80?text=<?php echo urlencode($product['name']); ?>">
                            <div class="text-xs font-semibold text-gray-900 mb-1 text-center truncate w-full">
                                <?php echo htmlspecialchars($product['name']); ?>
                            </div>
                            <div class="text-xs text-gray-600 text-center w-full">
                                KES <?php echo number_format($product['price'], 2); ?>
                            </div>
                            <div class="mt-2 flex space-x-2">
                                <a href="login.php?redirect=cart&product_id=<?php echo $product['id']; ?>" class="text-indigo-600 hover:text-indigo-900 text-xs"><i class="fas fa-shopping-cart mr-1"></i>Add to Cart</a>
                                <a href="login.php?redirect=wishlist&product_id=<?php echo $product['id']; ?>" class="text-indigo-600 hover:text-indigo-900 text-xs"><i class="fas fa-heart mr-1"></i>Add to Wishlist</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>
    </main>

    <!-- Mobile bottom navigation -->
    <nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 z-50 sm:hidden">
        <ul class="flex justify-between text-xs text-gray-600">
            <li class="flex flex-col items-center justify-center py-1.5 w-full hover:text-indigo-900">
                <a href="index-before-login.php" aria-label="Home" class="flex flex-col items-center space-y-0.5 focus:outline-none">
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
                <a href="contact.php" aria-label="Message" class="flex flex-col items-center space-y-0.5 focus:outline-none">
                    <i class="fas fa-comment-alt text-lg"></i>
                    <span>Contact</span>
                </a>
            </li>
            <li class="flex flex-col items-center justify-center py-1.5 w-full hover:text-indigo-900">
                <a href="cart.php" aria-label="Cart" class="flex flex-col items-center space-y-0.5 focus:outline-none">
                    <i class="fas fa-shopping-cart text-lg"></i>
                    <span>Cart</span>
                </a>
            </li>
            <li class="flex flex-col items-center justify-center py-1.5 w-full hover:text-indigo-900">
                <a href="login.php" aria-label="Account" class="flex flex-col items-center space-y-0.5 focus:outline-none">
                    <i class="fas fa-user text-lg"></i>
                    <span>Login</span>
                </a>
            </li>
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