<?php
session_start(); // This MUST be the very first line in your PHP file. No output before it.
require_once 'functions.php'; // Ensure functions.php does not output any content before session_start() is called.

// Determine if the user is logged in
$is_logged_in = isset($_SESSION['user_id']);
$user_id = $is_logged_in ? $_SESSION['user_id'] : null; // Get user ID if logged in

// Redirect if artisan ID is not provided
if (!isset($_GET['id'])) {
    header("Location: index.php"); // Redirect to generic index page
    exit();
}

$artisan_id = (int)$_GET['id'];
$artisan = getArtisanById($artisan_id);

// Redirect if artisan not found
if (!$artisan) {
    header("Location: index.php"); // Redirect to generic index page
    exit();
}

    // --- START: Fetch cart item count for the navigation bar ---
$cart_item_count = 0;
try {
    $stmt = $pdo->prepare("SELECT SUM(quantity) AS total_quantity FROM cart WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result && $result['total_quantity'] !== null) {
        $cart_item_count = (int)$result['total_quantity'];
    }
} catch (PDOException $e) {
    error_log("Error fetching cart item count for navigation: " . $e->getMessage());
    $cart_item_count = 0; // Default to 0 if there's an error
}
// --- END: Fetch cart item count ---


$products = getArtisanProducts($artisan_id);
$ratings = getRatings($artisan_id); // Assuming getRatings also fetches user names for display

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle rating submission
    if ($user_id && isset($_POST['rating'])) {
        $rating = (int)$_POST['rating'];
        $comment = $_POST['comment'] ?? null;
        if ($rating >= 1 && $rating <= 5) {
            addRating($artisan_id, $user_id, $rating, $comment);
        }
        header("Location: artisan-profile.php?id=$artisan_id");
        exit();
    } 

    // Handle add to cart submission
    elseif ($user_id && isset($_POST['product_id'])) {
        addToCart($user_id, $_POST['product_id'], 1);
        header("Location: cart.php"); // Redirect to cart after adding
        exit();
    }

    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JuaKali - <?php echo htmlspecialchars($artisan['name']); ?>'s Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f1e9; /* Light background */
            padding-top: 112px; /* height of fixed navbar + categories */
            padding-bottom: 56px; /* height of fixed bottom nav on mobile */
        }
        .profile-image {
            width: 100%;
            max-width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 9999px; /* Tailwind's full rounded for circle */
            border: 4px solid #4f46e5; /* Indigo-600 border */
        }
        .product-card {
            background: #fff;
            border: 1px solid #e5e7eb; /* Gray-200 */
            border-radius: 0.5rem; /* Rounded-lg */
            padding: 1rem;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: all 0.2s ease-in-out;
        }
        .product-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border-color: #4f46e5; /* Indigo-600 */
        }
        .product-card img {
            width: 100%;
            height: 160px; /* Adjusted height for better consistency */
            object-fit: contain;
            margin-bottom: 0.75rem;
            border-radius: 0.25rem;
        }
        .btn-primary {
            background-color: #4f46e5; /* Indigo-600 */
            color: #fff;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem; /* Rounded-md */
            font-weight: 600; /* Font-semibold */
            transition: background-color 0.2s ease-in-out;
        }
        .btn-primary:hover {
            background-color: #4338ca; /* Indigo-700 */
        }
        .rating-stars label {
            font-size: 1.75rem; /* Larger stars */
            color: #d1d5db; /* Gray-300 */
            cursor: pointer;
            transition: color 0.2s ease-in-out;
        }
        .rating-stars input:checked ~ label,
        .rating-stars label:hover,
        .rating-stars label:hover ~ label {
            color: #f59e0b; /* Amber-500 */
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
                <!-- <a href="cart.php" aria-label="Cart" class="flex items-center space-x-1 hover:text-indigo-900 focus:outline-none">
                    <i class="fas fa-shopping-cart text-lg"></i>
                    <span>Cart</span>
                </a> -->
                <?php if ($is_logged_in): ?>
                    <a href="index-after-login.php" aria-label="Home" class="flex items-center space-x-1 hover:text-indigo-900 focus:outline-none">
                    <i class="fas fa-home text-lg"></i>
                    <span></span>
                </a>
                <a href="products.php" aria-label="Store" class="flex items-center space-x-1 hover:text-indigo-900 focus:outline-none">
                    <i class="fas fa-store text-lg"></i>
                    <span></span>
                </a>
                <a href="cart.php" aria-label="Cart" class="relative flex items-center space-x-1 hover:text-indigo-900 focus:outline-none rounded-md px-2 py-1">
                    <i class="fas fa-shopping-cart text-lg"></i>
                    <?php if ($cart_item_count > 0): ?>
                        <span class="absolute -top-2 -right-2 bg-red-600 text-white rounded-full text-xs px-2 py-1 flex items-center justify-center min-w-[1.5rem] h-[1.5rem] leading-none">
                            <?php echo $cart_item_count; ?>
                        </span>
                    <?php endif; ?>
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
        <div class="profile-container bg-white rounded-lg shadow-md p-6 my-6">
            <div class="profile-header flex flex-col items-center text-center mb-8">
                <img src="<?php echo htmlspecialchars($artisan['image_url'] ?? 'https://placehold.co/200x200/E0E7FF/4338CA?text=Artisan'); ?>" alt="Artisan Photo" class="profile-image mb-4">
                <h2 class="text-3xl font-bold text-gray-900 mb-2"><?php echo htmlspecialchars($artisan['name']); ?>'s Profile</h2>
                <p class="text-gray-700 mb-1"><strong>Location:</strong> <?php echo htmlspecialchars($artisan['location'] ?? 'Not specified'); ?></p>
                <p class="text-gray-600 text-sm italic mb-4"><?php echo htmlspecialchars($artisan['bio'] ?? 'No bio available.'); ?></p>
                <div class="flex items-center text-lg text-gray-800">
                    <strong>Average Rating:</strong> 
                    <span class="ml-2 text-amber-500">
                        <?php
                        $average_rating = $artisan['average_rating'] ?? 0;
                        $stars = floor($average_rating);
                        for ($i = 0; $i < 5; $i++) {
                            echo $i < $stars ? '★' : '☆';
                        }
                        ?>
                    </span>
                    <span class="ml-1 text-gray-600">(<?php echo number_format($average_rating, 1); ?>/5)</span>
                </div>
            </div>

            <section class="products-section mt-10">
                <h3 class="text-2xl font-bold text-gray-900 text-center mb-6">Products by <?php echo htmlspecialchars($artisan['name']); ?></h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <?php if (empty($products)): ?>
                        <p class="col-span-full text-center text-gray-600">No products available from this artisan yet.</p>
                    <?php else: ?>
                        <?php foreach ($products as $product): ?>
                            <div class="product-card">
                                <a href="product_details.php?id=<?php echo $product['id']; ?>" class="block">
                                    <img src="https://placehold.co/250x160/E0E7FF/4338CA?text=<?php echo urlencode($product['name']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                                    <h5 class="text-lg font-semibold text-gray-900 mb-1 truncate w-full"><?php echo htmlspecialchars($product['name']); ?></h5>
                                    <p class="text-gray-700 font-medium mb-3">KES <?php echo number_format($product['price'], 2); ?></p>
                                </a>
                                <?php if ($is_logged_in): ?>
                                    <form method="POST" class="w-full">
                                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                        <button type="submit" class="btn-primary w-full">Add to Cart</button>
                                    </form>
                                <?php else: ?>
                                    <a href="login.php?redirect=cart&product_id=<?php echo $product['id']; ?>" class="btn-primary w-full text-center">Login to Add to Cart</a>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </section>

            <section class="rating-section mt-10">
                <h3 class="text-2xl font-bold text-gray-900 text-center mb-6">Ratings & Reviews</h3>
                <?php if ($is_logged_in): ?>
                    <div class="bg-gray-50 p-6 rounded-lg shadow-inner mb-6">
                        <h4 class="text-xl font-semibold text-gray-800 mb-4 text-center">Leave a Rating</h4>
                        <form method="POST" class="max-w-md mx-auto">
                            <div class="mb-4 flex justify-center rating-stars">
                                <input type="radio" id="star5" name="rating" value="5" class="hidden" required><label for="star5" class="cursor-pointer text-gray-300 hover:text-amber-500 transition-colors duration-200">★</label>
                                <input type="radio" id="star4" name="rating" value="4" class="hidden"><label for="star4" class="cursor-pointer text-gray-300 hover:text-amber-500 transition-colors duration-200">★</label>
                                <input type="radio" id="star3" name="rating" value="3" class="hidden"><label for="star3" class="cursor-pointer text-gray-300 hover:text-amber-500 transition-colors duration-200">★</label>
                                <input type="radio" id="star2" name="rating" value="2" class="hidden"><label for="star2" class="cursor-pointer text-gray-300 hover:text-amber-500 transition-colors duration-200">★</label>
                                <input type="radio" id="star1" name="rating" value="1" class="hidden"><label for="star1" class="cursor-pointer text-gray-300 hover:text-amber-500 transition-colors duration-200">★</label>
                            </div>
                            <div class="mb-4">
                                <label for="comment" class="block text-gray-700 text-sm font-bold mb-2">Comment (optional)</label>
                                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-indigo-500" id="comment" name="comment" rows="3" placeholder="Share your thoughts..."></textarea>
                            </div>
                            <button type="submit" class="btn-primary w-full">Submit Rating</button>
                        </form>
                    </div>
                <?php else: ?>
                    <p class="text-center text-gray-600 text-lg">
                        <a href="login.php" class="text-indigo-600 hover:text-indigo-800 font-semibold">Login</a> to leave a rating.
                    </p>
                <?php endif; ?>

                <div class="ratings-list mt-8">
                    <?php if (empty($ratings)): ?>
                        <p class="text-center text-gray-600">No ratings yet for this artisan.</p>
                    <?php else: ?>
                        <?php foreach ($ratings as $rating_item): ?>
                            <div class="bg-white border border-gray-200 rounded-lg p-4 mb-4 shadow-sm">
                                <p class="text-gray-900 font-semibold mb-1">
                                    <?php echo htmlspecialchars($rating_item['name']); ?>:
                                    <span class="ml-2 text-amber-500">
                                        <?php for ($i = 0; $i < 5; $i++) echo $i < $rating_item['rating'] ? '★' : '☆'; ?>
                                    </span>
                                    <span class="text-gray-600 text-sm">(<?php echo $rating_item['rating']; ?>/5)</span>
                                </p>
                                <p class="text-gray-700 text-sm mb-2"><?php echo htmlspecialchars($rating_item['comment'] ?? 'No comment.'); ?></p>
                                <p class="text-gray-500 text-xs">Posted on <?php echo date('F j, Y', strtotime($rating_item['created_at'])); ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </section>
        </div>
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
