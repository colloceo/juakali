<?php
session_start();
require_once 'functions.php'; // Assuming this file contains your PDO connection ($pdo) and addToCart/addToWishlist functions

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Products to display on the home page (fixed limit)
$products_limit = 12;

// Search query from GET request (still applies to the limited set)
$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';

// Category filter from GET request (still applies to the limited set)
$selected_category = isset($_GET['category']) ? trim($_GET['category']) : '';

// Base SQL query for approved products
$sql_base = "SELECT * FROM products WHERE status = 'Approved'";
$params = []; // Parameters for WHERE clause

// Add search condition if search query is present
if (!empty($search_query)) {
    $sql_base .= " AND (name LIKE ? OR description LIKE ?)";
    $params[] = '%' . $search_query . '%';
    $params[] = '%' . $search_query . '%';
}

// Add category condition if a category is selected (and not 'All')
if (!empty($selected_category) && $selected_category !== 'All') {
    $sql_base .= " AND category = ?";
    $params[] = $selected_category;
}

// Order products (e.g., by creation date, newest first)
$sql_base .= " ORDER BY created_at DESC";

// Final SQL query for fetching products with a fixed LIMIT
// Direct concatenation of integers for LIMIT to avoid PDO quoting issues
$sql_products_query = $sql_base . " LIMIT " . (int)$products_limit;

// Fetch products for the home page
$stmt_products = $pdo->prepare($sql_products_query);
$stmt_products->execute($params);
$products = $stmt_products->fetchAll(PDO::FETCH_ASSOC);

// Fetch total count for the "Showing X of Y results" text (optional, but good for context)
$sql_count_base = "SELECT COUNT(*) FROM products WHERE status = 'Approved'";
$params_count = [];
if (!empty($search_query)) {
    $sql_count_base .= " AND (name LIKE ? OR description LIKE ?)";
    $params_count[] = '%' . $search_query . '%';
    $params_count[] = '%' . $search_query . '%';
}
if (!empty($selected_category) && $selected_category !== 'All') {
    $sql_count_base .= " AND category = ?";
    $params_count[] = $selected_category;
}
$stmt_count = $pdo->prepare($sql_count_base);
$stmt_count->execute($params_count);
$total_products_matching_criteria = $stmt_count->fetchColumn();


// --- Handle Add to Cart/Wishlist Actions (POST requests) ---
$message = '';
$message_type = ''; // 'success' or 'error'

if (isset($_POST['add_to_cart'])) {
    $product_id = (int)$_POST['product_id'];
    if (addToCart($user_id, $product_id, 1)) { // Assuming addToCart handles quantity and existing items
        $message = "Product added to cart successfully!";
        $message_type = 'success';
    } else {
        $message = "Failed to add product to cart. It might already be in your cart or out of stock.";
        $message_type = 'error';
    }
    // Redirect back to the same page, preserving current search/category
    header("Location: index-after-login.php?" . http_build_query(array_merge($_GET, ['message' => $message, 'message_type' => $message_type])));
    exit();
}

if (isset($_POST['add_to_wishlist'])) {
    $product_id = (int)$_POST['product_id'];
    if (addToWishlist($user_id, $product_id)) { // Assuming addToWishlist handles uniqueness
        $message = "Product added to wishlist successfully!";
        $message_type = 'success';
    } else {
        $message = "Failed to add product to wishlist. It might already be in your wishlist.";
        $message_type = 'error';
    }
    // Redirect back, preserving current state
    header("Location: index-after-login.php?" . http_build_query(array_merge($_GET, ['message' => $message, 'message_type' => $message_type])));
    exit();
}

// Display messages from redirect (if any)
if (isset($_GET['message']) && isset($_GET['type'])) {
    $message = htmlspecialchars($_GET['message']);
    $message_type = htmlspecialchars($_GET['type']);
}

// Define available categories (can be fetched dynamically from DB in a real app)
$categories = ['All', 'Decor', 'Textiles', 'Food', 'Personal Care'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JuaKali - Handcrafted Products</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        /* Import Inter font from Google Fonts */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f1e9; /* Retained user's custom background color */
            padding-top: 112px; /* Space for fixed header + categories */
            padding-bottom: 56px; /* Space for fixed mobile bottom navigation */
        }
        /* Styling for individual product cards */
        .product-card-home { /* Specific class for home page product cards */
            transition: all 0.2s ease-in-out; /* Smooth transition for hover effects */
            border-radius: 0.5rem; /* rounded-lg */
            border: 1px solid #e5e7eb; /* border-gray-200 */
            padding: 0.5rem; /* p-2 */
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); /* shadow-sm */
        }
        .product-card-home:hover {
            transform: translateY(-3px); /* Slight lift on hover */
            box-shadow: 0 4px 12px rgba(0,0,0,0.1); /* Subtle shadow on hover */
            border-color: #4f46e5; /* Indigo-600 border on hover */
        }
        /* Custom scrollbar for horizontal categories on mobile */
        .overflow-x-auto::-webkit-scrollbar {
            height: 4px; /* Height of the scrollbar */
        }
        .overflow-x-auto::-webkit-scrollbar-thumb {
            background-color: #cbd5e0; /* Gray-300 color for the scrollbar thumb */
            border-radius: 2px; /* Rounded corners for the thumb */
        }
        .overflow-x-auto::-webkit-scrollbar-track {
            background-color: #f7fafc; /* Gray-50 color for the scrollbar track */
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-900">
    <header class="fixed top-0 left-0 right-0 bg-white border-b border-gray-200 z-50">
        <div class="max-w-7xl mx-auto flex items-center justify-center py-3 px-4 sm:px-6 lg:px-8 border-b border-gray-200">
            <form aria-label="Search products" class="w-full max-w-3xl" role="search" action="index-after-login.php" method="GET">
                <label class="sr-only" for="search-input">Search products</label>
                <div class="relative text-gray-600 focus-within:text-gray-900">
                    <input aria-describedby="search-desc" class="block w-full rounded-md border border-gray-300 py-2 pl-10 pr-4 text-sm placeholder-gray-400 focus:border-indigo-600 focus:outline-none focus:ring-1 focus:ring-indigo-600" id="search-input" name="search" placeholder="Search products..." type="search" value="<?php echo htmlspecialchars($search_query); ?>">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fas fa-search text-gray-400 text-sm"></i>
                    </div>
                </div>
                <p class="sr-only" id="search-desc">Enter product name or description to search</p>
            </form>
        </div>
        <div class="max-w-7xl mx-auto flex items-center justify-between py-3 px-4 sm:px-6 lg:px-8">
            <div class="text-lg font-semibold truncate flex-shrink-0">
                JuaKali
            </div>
            <nav class="hidden sm:flex flex-wrap gap-6 text-xs font-semibold text-gray-600 justify-center flex-1 px-6">
                <?php foreach ($categories as $category): ?>
                    <a class="<?php echo ($selected_category === $category || (empty($selected_category) && $category === 'All')) ? 'text-indigo-900 border-b-2 border-indigo-900 pb-1' : 'hover:text-indigo-900'; ?>"
                       href="index-after-login.php?category=<?php echo urlencode($category); ?><?php echo !empty($search_query) ? '&search=' . urlencode($search_query) : ''; ?>">
                        <?php echo htmlspecialchars($category); ?>
                    </a>
                <?php endforeach; ?>
            </nav>
            <div class="hidden sm:flex items-center space-x-6 flex-shrink-0 text-gray-600 text-sm">
                <a href="index-after-login.php" aria-label="Home" class="flex items-center space-x-1 hover:text-indigo-900 focus:outline-none rounded-md px-2 py-1">
                    <i class="fas fa-home text-lg"></i>
                    <span></span>
                </a>
                <a href="products.php" aria-label="Store" class="flex items-center space-x-1 hover:text-indigo-900 focus:outline-none rounded-md px-2 py-1">
                    <i class="fas fa-store text-lg"></i>
                    <span></span>
                </a>
                <a href="cart.php" aria-label="Cart" class="flex items-center space-x-1 hover:text-indigo-900 focus:outline-none rounded-md px-2 py-1">
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
            </div>
        </div>
        <nav class="sm:hidden flex flex-nowrap gap-3 text-xs font-semibold text-gray-600 justify-center border-t border-gray-200 py-2 overflow-x-auto px-4">
            <?php foreach ($categories as $category): ?>
                <a class="flex-shrink-0 <?php echo ($selected_category === $category || (empty($selected_category) && $category === 'All')) ? 'text-indigo-900 border-b-2 border-indigo-900 pb-1' : 'hover:text-indigo-900'; ?>"
                   href="index-after-login.php?category=<?php echo urlencode($category); ?><?php echo !empty($search_query) ? '&search=' . urlencode($search_query) : ''; ?>">
                    <?php echo htmlspecialchars($category); ?>
                </a>
            <?php endforeach; ?>
        </nav>
    </header>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6 mt-2">
        <div class="relative w-full max-w-4xl mx-auto overflow-hidden rounded-lg border border-gray-200 shadow-sm">
            <div class="flex transition-transform duration-700 ease-in-out" id="ads-carousel" style="transform: translateX(0%)">
                <img alt="Ad image showing handcrafted decor items" class="w-full flex-shrink-0 object-cover h-40 sm:h-56" height="224" src="https://placehold.co/600x224/e0e7ff/4338ca?text=Handcrafted+Decor" width="600">
                <img alt="Ad image showing artisan textiles" class="w-full flex-shrink-0 object-cover h-40 sm:h-56" height="224" src="https://placehold.co/600x224/d1e7dd/15803d?text=Artisan+Textiles" width="600">
                <img alt="Ad image showing local food products" class="w-full flex-shrink-0 object-cover h-40 sm:h-56" height="224" src="https://placehold.co/600x224/ffe4e6/be123c?text=Local+Food+Products" width="600">
                <img alt="Ad image showing personal care items" class="w-full flex-shrink-0 object-cover h-40 sm:h-56" height="224" src="https://placehold.co/600x224/e0f2fe/0369a1?text=Personal+Care+Items" width="600">
            </div>
        </div>
    </section>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php if (!empty($message)): ?>
            <div class="mb-4 p-3 rounded-md text-sm <?php echo $message_type === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="flex flex-col sm:flex-row justify-between items-center mb-4 text-xs text-gray-600 space-y-2 sm:space-y-0">
            <div>
                Showing <?php echo count($products); ?> of <?php echo $total_products_matching_criteria; ?> results
            </div>
            <div class="flex items-center space-x-2">
                <button aria-label="Grid view" class="border border-gray-300 rounded-md px-2 py-1 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1 transition-colors duration-150">
                    <i class="fas fa-th-large"></i>
                </button>
                <button aria-label="List view" class="border border-gray-300 rounded-md px-2 py-1 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1 transition-colors duration-150">
                    <i class="fas fa-list"></i>
                </button>
            </div>
        </div>

        <?php if (empty($products)): ?>
            <div class="text-center py-10">
                <p class="text-lg text-gray-700 mb-4">No products found matching your criteria.</p>
                <a href="index-after-login.php" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Clear Filters and View All Products
                </a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                <?php
                // Include product card template for each product on initial load
                foreach ($products as $product) {
                    // Pass a flag to the template if you want subtle differences
                    // For now, styling differences are handled by the parent div class (product-card-home)
                    include 'product_card_template.php'; 
                }
                ?>
            </div>
        <?php endif; ?>
    </main>

    <nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 z-50 sm:hidden">
        <ul class="flex justify-around text-xs text-gray-600">
            <li class="flex flex-col items-center justify-center py-1.5 w-full text-indigo-900 font-semibold transition-colors duration-200">
                <a href="index-after-login.php" aria-label="Home" class="flex flex-col items-center space-y-0.5 focus:outline-none">
                    <i class="fas fa-home text-lg"></i>
                    <span>Home</span>
                </a>
            </li>
            <li class="flex flex-col items-center justify-center py-1.5 w-full hover:text-indigo-900 transition-colors duration-200">
                <a href="products.php" aria-label="Categories" class="flex flex-col items-center space-y-0.5 focus:outline-none">
                    <i class="fas fa-th-large text-lg"></i>
                    <span>Categories</span>
                </a>
            </li>
            <li class="flex flex-col items-center justify-center py-1.5 w-full hover:text-indigo-900 transition-colors duration-200">
                <a href="cart.php" aria-label="Cart" class="flex flex-col items-center space-y-0.5 focus:outline-none">
                    <i class="fas fa-shopping-cart text-lg"></i>
                    <span>Cart</span>
                </a>
            </li>
            <li class="flex flex-col items-center justify-center py-1.5 w-full hover:text-indigo-900 transition-colors duration-200">
                <a href="account.php" aria-label="Account" class="flex flex-col items-center space-y-0.5 focus:outline-none">
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

    <script>
        // Carousel logic for ads
        const carousel = document.getElementById('ads-carousel');
        const totalSlides = carousel.children.length;
        let currentAdIndex = 0;

        function showNextSlide() {
            currentAdIndex++;
            if (currentAdIndex >= totalSlides) {
                currentAdIndex = 0;
            }
            carousel.style.transform = `translateX(-${currentAdIndex * 100}%)`;
        }
        setInterval(showNextSlide, 3000); // Change slide every 3 seconds
    </script>
</body>
</html>
