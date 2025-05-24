<?php
session_start();
require_once 'functions.php'; // Assumes this file contains PDO connection and other necessary functions

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=checkout");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch cart items
$stmt = $pdo->prepare("SELECT c.id AS cart_id, c.quantity, p.id AS product_id, p.name, p.price, p.quantity AS stock 
                        FROM cart c 
                        JOIN products p ON c.product_id = p.id 
                        WHERE c.user_id = ?");
$stmt->execute([$user_id]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate total
$total = 0;
foreach ($cart_items as $item) {
    $total += $item['price'] * $item['quantity'];
}

// Fetch user address
$stmt = $pdo->prepare("SELECT * FROM addresses WHERE user_id = ? LIMIT 1");
$stmt->execute([$user_id]);
$address = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle checkout form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['place_order'])) {
    $street = filter_input(INPUT_POST, 'street', FILTER_SANITIZE_STRING);
    $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
    $state = filter_input(INPUT_POST, 'state', FILTER_SANITIZE_STRING);
    $postal_code = filter_input(INPUT_POST, 'postal-code', FILTER_SANITIZE_STRING);
    $country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING);
    $payment_method = filter_input(INPUT_POST, 'payment_method', FILTER_SANITIZE_STRING);
    $mpesa_phone_number = null;

    // Validate M-Pesa phone number if selected
    if ($payment_method === 'mobile_money') {
        $mpesa_phone_number = filter_input(INPUT_POST, 'mpesa_phone_number', FILTER_SANITIZE_STRING);
        // Basic validation for M-Pesa number (e.g., starts with 07 or +2547, 9-12 digits)
        if (!preg_match('/^(07|\+2547)\d{8,12}$/', $mpesa_phone_number)) { // Added 8-12 digits for flexibility
            $_SESSION['error_message'] = "Invalid M-Pesa phone number format. Please use a valid Safaricom number (e.g., 0712345678 or +254712345678).";
            header("Location: checkout.php"); // Redirect back to checkout with error
            exit();
        }
    }

    $use_saved_address = isset($_POST['use_saved_address']) && $address;

    $address_to_use = $use_saved_address ? $address : [
        'street' => $street,
        'city' => $city,
        'state' => $state,
        'postal_code' => $postal_code,
        'country' => $country
    ];

    // Insert order into the database with a 'Pending' status and payment method details
    // Ensure your 'orders' table has 'payment_method' and 'mpesa_phone_number' columns
    $stmt = $pdo->prepare("INSERT INTO orders (user_id, total, status, payment_method, mpesa_phone_number) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $total, 'Pending', $payment_method, $mpesa_phone_number]);

    $order_id = $pdo->lastInsertId();

    // Insert order details
    foreach ($cart_items as $item) {
        $stmt = $pdo->prepare("INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt->execute([$order_id, $item['product_id'], $item['quantity'], $item['price']]);
    }

    // Clear cart (This is done here, but in a robust system, you might clear it after payment confirmation)
    $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ?");
    $stmt->execute([$user_id]);

    // Save or update address if new or changed
    if (!$use_saved_address && !$address) {
        $stmt = $pdo->prepare("INSERT INTO addresses (user_id, street, city, state, postal_code, country) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $address_to_use['street'], $address_to_use['city'], $address_to_use['state'], $address_to_use['postal_code'], $address_to_use['country']]);
    } elseif (!$use_saved_address && $address) {
        $stmt = $pdo->prepare("UPDATE addresses SET street = ?, city = ?, state = ?, postal_code = ?, country = ? WHERE user_id = ?");
        $stmt->execute([$address_to_use['street'], $address_to_use['city'], $address_to_use['state'], $address_to_use['postal_code'], $address_to_use['country'], $user_id]);
    }

    // --- REDIRECTION LOGIC BASED ON PAYMENT METHOD ---
    if ($payment_method === 'mobile_money') {
        // Store order ID in session for mpesa.php to pick up
        $_SESSION['current_order_id'] = $order_id;
        // mpesa.php will fetch total and phone number from the order record using this ID
        header("Location: mpesa.php");
        exit();
    } else {
        // Default redirection for other payment methods (e.g., credit card)
        header("Location: order_confirmation.php?order_id=$order_id");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout - JuaKali</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
            padding-top: 112px; /* Adjusted from 72px to match other pages' header height */
            padding-bottom: 56px; /* mobile bottom nav height */
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
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
                <a href="cart.php" aria-label="Cart" class="flex items-center space-x-1 hover:text-indigo-900 focus:outline-none">
                    <i class="fas fa-shopping-cart text-lg"></i>
                    <span>Cart</span>
                </a>
                <a href="profile.php" aria-label="Account" class="flex items-center space-x-1 hover:text-indigo-900 focus:outline-none">
                    <i class="fas fa-user text-lg"></i>
                    <span>Account</span>
                </a>
                <a href="logout.php" aria-label="Logout" class="flex items-center space-x-1 hover:text-indigo-900 focus:outline-none">
                    <i class="fas fa-sign-out-alt text-lg"></i>
                    <span>Logout</span>
                </a>
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

    <main class="flex-grow max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-6 sm:pt-24 sm:pb-24">
        <h1 class="text-2xl font-semibold text-gray-900 mb-6">Checkout</h1>

        <?php 
        // Display error message if redirected from M-Pesa validation
        if (isset($_SESSION['error_message'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline"><?php echo htmlspecialchars($_SESSION['error_message']); ?></span>
                <?php unset($_SESSION['error_message']); // Clear the message after displaying ?>
            </div>
        <?php endif; ?>

        <?php if (empty($cart_items)): ?>
            <p class="text-gray-600 text-sm">Your cart is empty. <a href="index.php" class="text-indigo-600 hover:text-indigo-900">Continue shopping</a>.</p>
        <?php else: ?>
            <section class="bg-white rounded-lg shadow p-6 space-y-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Review Your Cart</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                <th scope="col" class="hidden sm:table-cell px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                <th scope="col" class="hidden sm:table-cell px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($cart_items as $item): ?>
                                <tr>
                                    <td class="px-4 py-3 whitespace-nowrap flex items-center space-x-4">
                                        <img alt="<?php echo htmlspecialchars($item['name']); ?>" class="h-16 w-16 object-contain rounded" src="https://placehold.co/64x64/E0E7FF/4338CA?text=<?php echo urlencode($item['name']); ?>">
                                        <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($item['name']); ?></div>
                                    </td>
                                    <td class="hidden sm:table-cell px-4 py-3 whitespace-nowrap text-sm text-gray-700">
                                        KES <?php echo number_format($item['price'], 2); ?>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600"><?php echo $item['quantity']; ?></td>
                                    <td class="hidden sm:table-cell px-4 py-3 whitespace-nowrap text-sm font-semibold text-gray-900">
                                        KES <?php echo number_format($item['price'] * $item['quantity'], 2); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="text-lg font-semibold text-gray-900 text-right">
                    Total: KES <?php echo number_format($total, 2); ?>
                </div>

                <h2 class="text-xl font-semibold text-gray-900 mb-4 mt-6">Shipping Address</h2>
                <form method="POST" class="space-y-6">
                    <div class="flex items-center space-x-2 mb-4">
                        <?php if ($address): ?>
                            <label class="text-sm text-gray-700">
                                <input type="checkbox" name="use_saved_address" id="use_saved_address" value="1" <?php echo $address ? 'checked' : ''; ?> class="focus:ring-indigo-600 h-4 w-4 text-indigo-600 border-gray-300"> Use saved address
                            </label>
                        <?php endif; ?>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6" id="address-form-fields">
                        <div class="sm:col-span-2">
                            <label for="street" class="block text-sm font-medium text-gray-700 mb-1">Street Address</label>
                            <input class="block w-full rounded border border-gray-300 px-3 py-2 placeholder-gray-400 focus:border-indigo-600 focus:outline-none focus:ring-1 focus:ring-indigo-600 text-sm" id="street" name="street" placeholder="123 Main St" required type="text" value="<?php echo $address ? htmlspecialchars($address['street']) : ''; ?>" <?php echo $address ? 'disabled' : ''; ?>>
                        </div>
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                            <input class="block w-full rounded border border-gray-300 px-3 py-2 placeholder-gray-400 focus:border-indigo-600 focus:outline-none focus:ring-1 focus:ring-indigo-600 text-sm" id="city" name="city" placeholder="Nairobi" required type="text" value="<?php echo $address ? htmlspecialchars($address['city']) : ''; ?>" <?php echo $address ? 'disabled' : ''; ?>>
                        </div>
                        <div>
                            <label for="state" class="block text-sm font-medium text-gray-700 mb-1">State/Province</label>
                            <input class="block w-full rounded border border-gray-300 px-3 py-2 placeholder-gray-400 focus:border-indigo-600 focus:outline-none focus:ring-1 focus:ring-indigo-600 text-sm" id="state" name="state" placeholder="Nairobi County" type="text" value="<?php echo $address ? htmlspecialchars($address['state']) : ''; ?>" <?php echo $address ? 'disabled' : ''; ?>>
                        </div>
                        <div>
                            <label for="postal-code" class="block text-sm font-medium text-gray-700 mb-1">Postal Code</label>
                            <input class="block w-full rounded border border-gray-300 px-3 py-2 placeholder-gray-400 focus:border-indigo-600 focus:outline-none focus:ring-1 focus:ring-indigo-600 text-sm" id="postal-code" name="postal-code" placeholder="00100" type="text" value="<?php echo $address ? htmlspecialchars($address['postal_code']) : ''; ?>" <?php echo $address ? 'disabled' : ''; ?>>
                        </div>
                        <div>
                            <label for="country" class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                            <input class="block w-full rounded border border-gray-300 px-3 py-2 placeholder-gray-400 focus:border-indigo-600 focus:outline-none focus:ring-1 focus:ring-indigo-600 text-sm" id="country" name="country" placeholder="Kenya" required type="text" value="<?php echo $address ? htmlspecialchars($address['country']) : ''; ?>" <?php echo $address ? 'disabled' : ''; ?>>
                        </div>
                    </div>

                    <h2 class="text-xl font-semibold text-gray-900 mb-4 mt-6">Payment Method</h2>
                    <div class="space-y-4">
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="payment_method" value="credit_card" id="payment_credit_card" checked class="focus:ring-indigo-600 h-4 w-4 text-indigo-600 border-gray-300">
                            <span class="text-sm text-gray-700">Credit/Debit Card</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="payment_method" value="mobile_money" id="payment_mobile_money" class="focus:ring-indigo-600 h-4 w-4 text-indigo-600 border-gray-300">
                            <span class="text-sm text-gray-700">Mobile Money (M-Pesa)</span>
                        </label>
                    </div>

                    <div id="mpesa_phone_number_field" class="hidden mt-4">
                        <label for="mpesa_phone_number" class="block text-sm font-medium text-gray-700 mb-1">M-Pesa Phone Number</label>
                        <input type="tel" id="mpesa_phone_number" name="mpesa_phone_number" placeholder="e.g., 0712345678 or +254712345678" class="block w-full rounded border border-gray-300 px-3 py-2 placeholder-gray-400 focus:border-indigo-600 focus:outline-none focus:ring-1 focus:ring-indigo-600 text-sm">
                        <p class="mt-1 text-xs text-gray-500">Please enter the phone number registered with M-Pesa.</p>
                    </div>

                    <button type="submit" name="place_order" class="w-full bg-indigo-600 text-white py-2 rounded text-sm font-semibold hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-1 mt-6">
                        Place Order
                    </button>
                </form>
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
                <a href="profile.php" aria-label="Account" class="flex flex-col items-center space-y-0.5 focus:outline-none">
                    <i class="fas fa-user text-lg"></i>
                    <span>Account</span>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const useSavedAddressCheckbox = document.getElementById('use_saved_address');
            const addressFormFields = document.getElementById('address-form-fields');
            const addressInputs = addressFormFields.querySelectorAll('input');

            // Function to toggle address input fields disabled state
            function toggleAddressFields() {
                const isDisabled = useSavedAddressCheckbox.checked;
                addressInputs.forEach(input => {
                    input.disabled = isDisabled;
                    // Toggle 'required' attribute based on disabled state
                    if (isDisabled) {
                        input.removeAttribute('required'); 
                    } else {
                        input.setAttribute('required', 'required');
                    }
                });
            }

            // Initial state based on checkbox
            if (useSavedAddressCheckbox) { // Check if the checkbox exists
                toggleAddressFields();
                useSavedAddressCheckbox.addEventListener('change', toggleAddressFields);
            }

            const paymentMethodRadios = document.querySelectorAll('input[name="payment_method"]');
            const mpesaPhoneNumberField = document.getElementById('mpesa_phone_number_field');
            const mpesaPhoneNumberInput = document.getElementById('mpesa_phone_number');

            // Function to toggle M-Pesa phone number field visibility
            function toggleMpesaField() {
                if (document.getElementById('payment_mobile_money').checked) {
                    mpesaPhoneNumberField.classList.remove('hidden');
                    mpesaPhoneNumberInput.setAttribute('required', 'required');
                } else {
                    mpesaPhoneNumberField.classList.add('hidden');
                    mpesaPhoneNumberInput.removeAttribute('required');
                }
            }

            // Add event listeners to payment method radios
            paymentMethodRadios.forEach(radio => {
                radio.addEventListener('change', toggleMpesaField);
            });

            // Initial state based on default checked radio button
            toggleMpesaField();
        });
    </script>
</body>
</html>
