<?php
session_start();
require_once 'functions.php'; // Assuming this file contains your PDO connection ($pdo)

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch user address (assuming an addresses table)
$stmt = $pdo->prepare("SELECT * FROM addresses WHERE user_id = ? LIMIT 1");
$stmt->execute([$user_id]);
$address = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch user orders
$stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch user wishlist items
// This assumes you have a 'wishlist' table with 'user_id' and 'product_id'
// and a 'products' table with 'id', 'name', 'price', and 'image_url'.
$wishlist_items = [];
try {
    $stmt = $pdo->prepare("SELECT p.id, p.name, p.price, p.image_url FROM wishlist w JOIN products p ON w.product_id = p.id WHERE w.user_id = ? ORDER BY w.added_at DESC");
    $stmt->execute([$user_id]);
    $wishlist_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Handle the case where the wishlist table or products table might not exist yet
    // or if there's a problem with the query.
    // In a production environment, you would log this error.
    error_log("Error fetching wishlist items: " . $e->getMessage());
    $wishlist_items = []; // Ensure it's an empty array if there's an error
}


// Handle profile update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    $first_name = filter_input(INPUT_POST, 'first-name', FILTER_SANITIZE_STRING);
    $last_name = filter_input(INPUT_POST, 'last-name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);

    $full_name = trim("$first_name $last_name"); // Combine first and last name

    $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, phone = ? WHERE id = ?");
    $stmt->execute([$full_name, $email, $phone, $user_id]);
    header("Location: account.php?tab=profile&updated=true");
    exit();
}

// Handle address update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_address'])) {
    $street = filter_input(INPUT_POST, 'street', FILTER_SANITIZE_STRING);
    $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
    $state = filter_input(INPUT_POST, 'state', FILTER_SANITIZE_STRING);
    $postal_code = filter_input(INPUT_POST, 'postal-code', FILTER_SANITIZE_STRING);
    $country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING);

    if ($address) {
        // Update existing address
        $stmt = $pdo->prepare("UPDATE addresses SET street = ?, city = ?, state = ?, postal_code = ?, country = ? WHERE user_id = ?");
        $stmt->execute([$street, $city, $state, $postal_code, $country, $user_id]);
    } else {
        // Insert new address
        $stmt = $pdo->prepare("INSERT INTO addresses (user_id, street, city, state, postal_code, country) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $street, $city, $state, $postal_code, $country]);
    }
    header("Location: account.php?tab=address&updated=true");
    exit();
}

// Determine active tab based on GET parameter, default to 'profile'
$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'profile';

// Split user name for profile form
$user_name_parts = explode(' ', $user['name'], 2); // Split into at most 2 parts
$user_first_name = $user_name_parts[0] ?? '';
$user_last_name = $user_name_parts[1] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Account - JuaKali</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        /* Import Inter font from Google Fonts */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
            padding-top: 72px; /* Adjust for fixed header height */
            padding-bottom: 56px; /* Adjust for fixed mobile bottom navigation height */
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <header class="fixed top-0 left-0 right-0 bg-white border-b border-gray-200 z-50">
        <div class="max-w-7xl mx-auto flex items-center justify-between py-4 px-4 sm:px-6 lg:px-8">
            <div class="text-lg font-semibold text-gray-900">
                JuaKali
            </div>
            <nav class="hidden sm:flex space-x-6 text-sm text-gray-600">
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
                <a href="account.php" aria-label="Account" class="flex items-center space-x-1 hover:text-indigo-900 focus:outline-none rounded-md px-2 py-1">
                    <i class="fas fa-user text-lg"></i>
                    <span></span>
                </a>
                <a href="logout.php" aria-label="Logout" class="flex items-center space-x-1 hover:text-red-600 focus:outline-none rounded-md px-2 py-1">
                    <i class="fas fa-sign-out-alt text-lg"></i>
                    <span></span>
                </a>
            </nav>
        </div>
    </header>

    <main class="flex-grow max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-6 sm:pt-24 sm:pb-24">
        <h1 class="text-2xl font-semibold text-gray-900 mb-6">Your Account</h1>

        <div class="border-b border-gray-200 mb-6">
            <nav class="flex space-x-4 overflow-x-auto pb-2">
                <a href="?tab=profile" class="flex-shrink-0 py-2 px-4 text-sm font-medium rounded-t-md <?php echo $active_tab === 'profile' ? 'border-b-2 border-indigo-600 text-indigo-900' : 'text-gray-600 hover:text-indigo-900'; ?>">Profile</a>
                <a href="?tab=orders" class="flex-shrink-0 py-2 px-4 text-sm font-medium rounded-t-md <?php echo $active_tab === 'orders' ? 'border-b-2 border-indigo-600 text-indigo-900' : 'text-gray-600 hover:text-indigo-900'; ?>">Orders</a>
                <a href="?tab=address" class="flex-shrink-0 py-2 px-4 text-sm font-medium rounded-t-md <?php echo $active_tab === 'address' ? 'border-b-2 border-indigo-600 text-indigo-900' : 'text-gray-600 hover:text-indigo-900'; ?>">Address</a>
                <a href="?tab=wishlist" class="flex-shrink-0 py-2 px-4 text-sm font-medium rounded-t-md <?php echo $active_tab === 'wishlist' ? 'border-b-2 border-indigo-600 text-indigo-900' : 'text-gray-600 hover:text-indigo-900'; ?>">Wishlist</a>
            </nav>
        </div>

        <?php if ($active_tab === 'profile'): ?>
            <section class="bg-white rounded-lg shadow p-6 space-y-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-6">
                    <div class="flex-shrink-0 mx-auto sm:mx-0">
                        <img alt="User profile picture" class="h-24 w-24 rounded-full object-cover border border-gray-200" height="96" src="https://via.placeholder.com/96x96?text=Profile" width="96">
                    </div>
                    <div class="mt-4 sm:mt-0 text-center sm:text-left">
                        <h2 class="text-xl font-semibold text-gray-900"><?php echo htmlspecialchars($user['name']); ?></h2>
                        <p class="text-gray-600"><?php echo htmlspecialchars($user['email']); ?></p>
                    </div>
                </div>
                <form action="account.php?tab=profile" method="POST" class="space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="first-name" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                            <input class="block w-full rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 focus:border-indigo-600 focus:outline-none focus:ring-1 focus:ring-indigo-600 text-sm" id="first-name" name="first-name" placeholder="First Name" required type="text" value="<?php echo htmlspecialchars($user_first_name); ?>">
                        </div>
                        <div>
                            <label for="last-name" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                            <input class="block w-full rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 focus:border-indigo-600 focus:outline-none focus:ring-1 focus:ring-indigo-600 text-sm" id="last-name" name="last-name" placeholder="Last Name" required type="text" value="<?php echo htmlspecialchars($user_last_name); ?>">
                        </div>
                        <div class="sm:col-span-2">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <input autocomplete="email" class="block w-full rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 focus:border-indigo-600 focus:outline-none focus:ring-1 focus:ring-indigo-600 text-sm" id="email" name="email" placeholder="you@example.com" required type="email" value="<?php echo htmlspecialchars($user['email']); ?>">
                        </div>
                        <div class="sm:col-span-2">
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input autocomplete="tel" class="block w-full rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 focus:border-indigo-600 focus:outline-none focus:ring-1 focus:ring-indigo-600 text-sm" id="phone" name="phone" placeholder="+254 123 456 789" type="tel" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                        </div>
                    </div>
                    <button type="submit" name="update_profile" class="w-full bg-indigo-600 text-white py-2 rounded-md text-sm font-semibold hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-1 transition duration-150 ease-in-out">
                        Save Changes
                    </button>
                </form>
            </section>
        <?php endif; ?>

        <?php if ($active_tab === 'orders'): ?>
            <section class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Your Orders</h2>
                <?php if (empty($orders)): ?>
                    <p class="text-gray-600 text-sm">You have no orders yet. <a href="index-after-login.php" class="text-indigo-600 hover:text-indigo-900 font-medium">Start shopping now!</a></p>
                <?php else: ?>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tl-lg">Order ID</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tr-lg">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($order['id']); ?></td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600"><?php echo date('M d, Y', strtotime($order['created_at'])); ?></td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">KES <?php echo number_format($order['total'], 2); ?></td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                <?php
                                                    switch ($order['status']) {
                                                        case 'Pending': echo 'bg-yellow-100 text-yellow-800'; break;
                                                        case 'Processing': echo 'bg-blue-100 text-blue-800'; break;
                                                        case 'Completed': echo 'bg-green-100 text-green-800'; break;
                                                        case 'Cancelled': echo 'bg-red-100 text-red-800'; break;
                                                        default: echo 'bg-gray-100 text-gray-800'; break;
                                                    }
                                                ?>">
                                                <?php echo htmlspecialchars($order['status']); ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </section>
        <?php endif; ?>

        <?php if ($active_tab === 'address'): ?>
            <section class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Your Address</h2>
                <form action="account.php?tab=address" method="POST" class="space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="sm:col-span-2">
                            <label for="street" class="block text-sm font-medium text-gray-700 mb-1">Street Address</label>
                            <input class="block w-full rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 focus:border-indigo-600 focus:outline-none focus:ring-1 focus:ring-indigo-600 text-sm" id="street" name="street" placeholder="123 Main St" required type="text" value="<?php echo htmlspecialchars($address['street'] ?? ''); ?>">
                        </div>
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                            <input class="block w-full rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 focus:border-indigo-600 focus:outline-none focus:ring-1 focus:ring-indigo-600 text-sm" id="city" name="city" placeholder="Nairobi" required type="text" value="<?php echo htmlspecialchars($address['city'] ?? ''); ?>">
                        </div>
                        <div>
                            <label for="state" class="block text-sm font-medium text-gray-700 mb-1">State/Province</label>
                            <input class="block w-full rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 focus:border-indigo-600 focus:outline-none focus:ring-1 focus:ring-indigo-600 text-sm" id="state" name="state" placeholder="Nairobi County" type="text" value="<?php echo htmlspecialchars($address['state'] ?? ''); ?>">
                        </div>
                        <div>
                            <label for="postal-code" class="block text-sm font-medium text-gray-700 mb-1">Postal Code</label>
                            <input class="block w-full rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 focus:border-indigo-600 focus:outline-none focus:ring-1 focus:ring-indigo-600 text-sm" id="postal-code" name="postal-code" placeholder="00100" type="text" value="<?php echo htmlspecialchars($address['postal_code'] ?? ''); ?>">
                        </div>
                        <div>
                            <label for="country" class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                            <input class="block w-full rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 focus:border-indigo-600 focus:outline-none focus:ring-1 focus:ring-indigo-600 text-sm" id="country" name="country" placeholder="Kenya" required type="text" value="<?php echo htmlspecialchars($address['country'] ?? ''); ?>">
                        </div>
                    </div>
                    <button type="submit" name="update_address" class="w-full bg-indigo-600 text-white py-2 rounded-md text-sm font-semibold hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-1 transition duration-150 ease-in-out">
                        Save Address
                    </button>
                </form>
            </section>
        <?php endif; ?>

        <?php if ($active_tab === 'wishlist'): ?>
            <section class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Your Wishlist</h2>
                <?php if (empty($wishlist_items)): ?>
                    <p class="text-gray-600 text-sm">Your wishlist is empty. <a href="products.php" class="text-indigo-600 hover:text-indigo-900 font-medium">Discover products to add!</a></p>
                <?php else: ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach ($wishlist_items as $item): ?>
                            <div class="border border-gray-200 rounded-lg p-4 flex flex-col items-center text-center transition-shadow duration-200 hover:shadow-md">
                                <img src="<?php echo htmlspecialchars($item['image_url'] ?? 'https://via.placeholder.com/150/f3f4f6/6b7280?text=No+Image'); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="w-32 h-32 object-cover rounded-md mb-3 border border-gray-100">
                                <h3 class="text-base font-semibold text-gray-900 mb-1 truncate w-full px-2"><?php echo htmlspecialchars($item['name']); ?></h3>
                                <p class="text-gray-700 text-sm font-medium mb-3">KES <?php echo number_format($item['price'], 2); ?></p>
                                <a href="product_detail.php?id=<?php echo htmlspecialchars($item['id']); ?>" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                                    View Product
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>
        <?php endif; ?>

    </main>

    <nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 z-50 sm:hidden">
        <ul class="flex justify-around text-xs text-gray-600">
            <li class="flex flex-col items-center justify-center py-1.5 w-full hover:text-indigo-900 transition-colors duration-200">
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
            <!-- <li class="flex flex-col items-center justify-center py-1.5 w-full hover:text-indigo-900 transition-colors duration-200">
                <a href="contact.php" aria-label="Message" class="flex flex-col items-center space-y-0.5 focus:outline-none">
                    <i class="fas fa-comment-alt text-lg"></i>
                    <span>Contact</span>
                </a>
            </li> -->
            <li class="flex flex-col items-center justify-center py-1.5 w-full hover:text-indigo-900 transition-colors duration-200">
                <a href="cart.php" aria-label="Cart" class="flex flex-col items-center space-y-0.5 focus:outline-none">
                    <i class="fas fa-shopping-cart text-lg"></i>
                    <span>Cart</span>
                </a>
            </li>
            <li class="flex flex-col items-center justify-center py-1.5 w-full text-indigo-900 font-semibold transition-colors duration-200">
                <a href="account.php" aria-label="Account" class="flex flex-col items-center space-y-0.5 focus:outline-none">
                    <i class="fas fa-user text-lg"></i>
                    <span>Account</span>
                </a>
            </li>
            <!-- <li class="flex flex-col items-center justify-center py-1.5 w-full hover:text-red-600 transition-colors duration-200">
                <a href="logout.php" aria-label="Logout" class="flex flex-col items-center space-y-0.5 focus:outline-none">
                    <i class="fas fa-sign-out-alt text-lg"></i>
                    <span>Logout</span>
                </a>
            </li> -->
        </ul>
    </nav>

    <footer class="bg-white border-t border-gray-200 text-xs text-gray-500 py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row justify-between items-center space-y-2 sm:space-y-0">
            <div class="truncate">
                © <?php echo date("Y"); ?> JuaKali
            </div>
            <div class="space-x-3">
                <a class="hover:text-indigo-900 transition-colors duration-200" href="privacy.php">Privacy</a>
                <a class="hover:text-indigo-900 transition-colors duration-200" href="terms.php">Terms</a>
                <a class="hover:text-indigo-900 transition-colors duration-200" href="contact.php">Contact</a>
            </div>
        </div>
    </footer>
</body>
</html>
