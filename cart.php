<?php
session_start();
require_once 'functions.php'; // Assuming this file contains your PDO connection ($pdo)

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=cart");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch cart items, including product image_url and current stock
$stmt = $pdo->prepare("SELECT c.id AS cart_id, c.quantity, p.id AS product_id, p.name, p.price, p.quantity AS stock, p.image_url
                       FROM cart c
                       JOIN products p ON c.product_id = p.id
                       WHERE c.user_id = ?");
$stmt->execute([$user_id]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate total cart value
$total = 0;
foreach ($cart_items as $item) {
    $total += $item['price'] * $item['quantity'];
}

// Initialize feedback message variables
$feedback_message = '';
$feedback_type = ''; // 'success' or 'error'

// Handle quantity update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_cart'])) {
    $cart_id = (int)$_POST['cart_id'];
    $new_quantity = (int)$_POST['quantity'];
    
    // Validate quantity against available stock
    $stmt = $pdo->prepare("SELECT p.quantity FROM cart c JOIN products p ON c.product_id = p.id WHERE c.id = ? AND c.user_id = ?");
    $stmt->execute([$cart_id, $user_id]);
    $stock = $stmt->fetchColumn();
    
    if ($stock === false) { // Item not found in cart or not for this user
        $feedback_message = "Error: Item not found in your cart.";
        $feedback_type = 'error';
    } elseif ($new_quantity <= 0) {
        // If quantity is 0 or less, remove the item
        $stmt = $pdo->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
        $stmt->execute([$cart_id, $user_id]);
        $feedback_message = "Item removed from cart.";
        $feedback_type = 'success';
    } elseif ($new_quantity > $stock) {
        $feedback_message = "Cannot update quantity. Only " . $stock . " units are available for this product.";
        $feedback_type = 'error';
    } else {
        // Update quantity
        $stmt = $pdo->prepare("UPDATE cart SET quantity = ? WHERE id = ? AND user_id = ?");
        $stmt->execute([$new_quantity, $cart_id, $user_id]);
        $feedback_message = "Cart quantity updated successfully!";
        $feedback_type = 'success';
    }
    // Redirect to prevent form resubmission and display message
    header("Location: cart.php?message=" . urlencode($feedback_message) . "&type=" . urlencode($feedback_type));
    exit();
}

// Handle remove item
if (isset($_GET['remove'])) {
    $cart_id = (int)$_GET['remove'];
    $stmt = $pdo->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
    if ($stmt->execute([$cart_id, $user_id])) {
        $feedback_message = "Item removed from cart successfully!";
        $feedback_type = 'success';
    } else {
        $feedback_message = "Failed to remove item from cart.";
        $feedback_type = 'error';
    }
    // Redirect to prevent re-removal and display message
    header("Location: cart.php?message=" . urlencode($feedback_message) . "&type=" . urlencode($feedback_type));
    exit();
}

// Display messages from GET parameters after a redirect
if (isset($_GET['message']) && isset($_GET['type'])) {
    $feedback_message = htmlspecialchars($_GET['message']);
    $feedback_type = htmlspecialchars($_GET['type']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cart - JuaKali</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
            padding-top: 72px; /* header height */
            padding-bottom: 56px; /* mobile bottom nav height */
        }
        /* Custom styling for quantity input to make it slightly wider */
        .quantity-input {
            width: 70px; /* Adjust as needed */
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
            </nav>
        </div>
    </header>

    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-6 sm:pt-24 sm:pb-24">
        <h1 class="text-2xl font-semibold text-gray-900 mb-6">Your Shopping Cart</h1>

        <?php if (!empty($feedback_message)): ?>
            <div class="mb-4 p-3 rounded-md text-sm <?php echo $feedback_type === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>" role="alert">
                <?php echo $feedback_message; ?>
            </div>
        <?php endif; ?>

        <?php if (empty($cart_items)): ?>
            <p class="text-gray-600 text-sm">Your cart is empty. <a href="index-after-login.php" class="text-indigo-600 hover:text-indigo-900 font-medium">Start shopping now!</a></p>
        <?php else: ?>
            <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tl-lg">Product</th>
                                <th scope="col" class="hidden sm:table-cell px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                <th scope="col" class="hidden sm:table-cell px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                <th scope="col" class="relative px-4 py-3 rounded-tr-lg"><span class="sr-only">Remove</span></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($cart_items as $item): ?>
                                <tr>
                                    <td class="px-4 py-3 whitespace-nowrap flex items-center space-x-4">
                                        <img alt="<?php echo htmlspecialchars($item['name']); ?>" class="h-16 w-16 object-contain rounded-md border border-gray-100" src="<?php echo htmlspecialchars($item['image_url'] ?? 'https://placehold.co/64x64/f3f4f6/6b7280?text=Product'); ?>">
                                        <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($item['name']); ?></div>
                                    </td>
                                    <td class="hidden sm:table-cell px-4 py-3 whitespace-nowrap text-sm text-gray-700">
                                        KES <?php echo number_format($item['price'], 2); ?>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <form method="POST" class="flex items-center">
                                            <input type="hidden" name="cart_id" value="<?php echo htmlspecialchars($item['cart_id']); ?>">
                                            <input aria-label="Quantity for <?php echo htmlspecialchars($item['name']); ?>" name="quantity" class="quantity-input border border-gray-300 rounded-md text-sm text-center py-1 focus:border-indigo-600 focus:outline-none focus:ring-1 focus:ring-indigo-600" min="0" max="<?php echo htmlspecialchars($item['stock']); ?>" type="number" value="<?php echo htmlspecialchars($item['quantity']); ?>">
                                            <button type="submit" name="update_cart" class="ml-2 text-indigo-600 hover:text-indigo-900 text-xs font-medium focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-1 rounded-md px-2 py-1 transition-colors duration-150">Update</button>
                                        </form>
                                        <?php if ($item['stock'] == 0): ?>
                                            <p class="text-red-500 text-xs mt-1">Out of Stock!</p>
                                        <?php elseif ($item['quantity'] > $item['stock']): ?>
                                            <p class="text-orange-500 text-xs mt-1">Quantity exceeds stock (<?php echo htmlspecialchars($item['stock']); ?> available)</p>
                                        <?php endif; ?>
                                    </td>
                                    <td class="hidden sm:table-cell px-4 py-3 whitespace-nowrap text-sm font-semibold text-gray-900">
                                        KES <?php echo number_format($item['price'] * $item['quantity'], 2); ?>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="cart.php?remove=<?php echo htmlspecialchars($item['cart_id']); ?>" aria-label="Remove <?php echo htmlspecialchars($item['name']); ?> from cart" class="text-red-600 hover:text-red-900 focus:outline-none p-2 rounded-md hover:bg-red-50 transition-colors duration-150">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-6 flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                <a href="index-after-login.php" class="w-full sm:w-auto bg-gray-200 text-gray-700 px-6 py-2 rounded-md text-sm font-semibold hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-1 transition duration-150 ease-in-out">
                    Continue Shopping
                </a>
                <div class="text-lg font-semibold text-gray-900">
                    Total: KES <?php echo number_format($total, 2); ?>
                </div>
                <a href="checkout.php" class="w-full sm:w-auto bg-indigo-600 text-white px-6 py-2 rounded-md text-sm font-semibold hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-1 transition duration-150 ease-in-out">
                    Proceed to Checkout
                </a>
            </div>
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
            <li class="flex flex-col items-center justify-center py-1.5 w-full text-indigo-900 font-semibold transition-colors duration-200">
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

    <footer class="bg-white border-t border-gray-200 text-xs text-gray-500 py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row justify-between items-center space-y-2 sm:space-y-0">
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
