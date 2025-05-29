<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details - Juakali</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
    <?php
    session_start();
    // Database connection
    $conn = new mysqli("127.0.0.1", "root", "", "juakali_db");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get product ID from URL
    $product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $product = null;
    $related_products = [];

    if ($product_id > 0) {
        // Fetch product details
        $sql = "SELECT p.*, a.name AS artisan_name, a.bio, a.location, a.average_rating, a.image_url AS artisan_image
                FROM products p
                LEFT JOIN artisans a ON p.artisan_id = a.id
                WHERE p.id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        $stmt->close();

        // Fetch related products (same artisan, exclude current product)
        if ($product && $product['artisan_id']) {
            $sql = "SELECT id, name, price, image_url
                    FROM products
                    WHERE artisan_id = ? AND id != ?
                    LIMIT 4";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $product['artisan_id'], $product_id);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $related_products[] = $row;
            }
            $stmt->close();
        }
    }

    // Handle add to cart
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart']) && isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $quantity = 1; // Default quantity
        $sql = "INSERT INTO cart (user_id, product_id, quantity, created_at) VALUES (?, ?, ?, NOW())
                ON DUPLICATE KEY UPDATE quantity = quantity + 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $user_id, $product_id, $quantity);
        $stmt->execute();
        $stmt->close();
        $cart_message = "Product added to cart!";
    }

    // Handle add to wishlist
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_wishlist']) && isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $sql = "INSERT IGNORE INTO wishlist (user_id, product_id, created_at) VALUES (?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
        $stmt->close();
        $wishlist_message = "Product added to wishlist!";
    }

    $conn->close();
    ?>

    <!-- Navbar -->
    <nav class="bg-white shadow-md py-4">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <a href="/" class="text-2xl font-bold text-gray-800">Juakali</a>
            <div class="space-x-4">
                <a href="/cart.php" class="text-gray-600 hover:text-gray-800">Cart</a>
                <a href="/wishlist.php" class="text-gray-600 hover:text-gray-800">Wishlist</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="/logout.php" class="text-gray-600 hover:text-gray-800">Logout</a>
                <?php else: ?>
                    <a href="/login.php" class="text-gray-600 hover:text-gray-800">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <?php if ($product): ?>
            <div class="bg-white rounded-lg shadow-md p-6 flex flex-col md:flex-row gap-8">
                <!-- Product Image -->
                <div class="md:w-1/2">
                    <img src="<?php echo htmlspecialchars($product['image_url'] ?: 'https://via.placeholder.com/400'); ?>" 
                         alt="<?php echo htmlspecialchars($product['name']); ?>" 
                         class="w-full h-96 object-cover rounded-lg">
                </div>

                <!-- Product Details -->
                <div class="md:w-1/2">
                    <h1 class="text-3xl font-bold text-gray-800 mb-4"><?php echo htmlspecialchars($product['name']); ?></h1>
                    <p class="text-gray-600 mb-4"><?php echo htmlspecialchars($product['description']); ?></p>
                    <p class="text-2xl font-semibold text-green-600 mb-4">KSh <?php echo number_format($product['price'], 2); ?></p>
                    <p class="text-gray-600 mb-4"><strong>Availability:</strong> In Stock</p>

                    <!-- Artisan Info -->
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-gray-800">Artisan: <?php echo htmlspecialchars($product['artisan_name'] ?: 'Unknown'); ?></h2>
                        <p class="text-gray-600"><?php echo htmlspecialchars($product['bio'] ?: 'No bio available.'); ?></p>
                        <p class="text-gray-600"><strong>Location:</strong> <?php echo htmlspecialchars($product['location'] ?: 'N/A'); ?></p>
                        <p class="text-gray-600"><strong>Rating:</strong> <?php echo number_format($product['average_rating'] ?: 0, 1); ?> / 5</p>
                        <?php if ($product['artisan_image']): ?>
                            <img src="<?php echo htmlspecialchars($product['artisan_image']); ?>" 
                                 alt="<?php echo htmlspecialchars($product['artisan_name']); ?>" 
                                 class="w-16 h-16 rounded-full mt-2">
                        <?php endif; ?>
                    </div>

                    <!-- Action Buttons -->
                    <form method="POST" class="flex gap-4">
                        <button type="submit" name="add_to_cart" 
                                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 <?php echo !isset($_SESSION['user_id']) ? 'opacity-50 cursor-not-allowed' : ''; ?>" 
                                <?php echo !isset($_SESSION['user_id']) ? 'disabled' : ''; ?>>
                            Add to Cart
                        </button>
                        <button type="submit" name="add_to_wishlist" 
                                class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700 <?php echo !isset($_SESSION['user_id']) ? 'opacity-50 cursor-not-allowed' : ''; ?>" 
                                <?php echo !isset($_SESSION['user_id']) ? 'disabled' : ''; ?>>
                            Add to Wishlist
                        </button>
                    </form>
                    <?php if (isset($cart_message)): ?>
                        <p class="text-green-600 mt-4"><?php echo $cart_message; ?></p>
                    <?php endif; ?>
                    <?php if (isset($wishlist_message)): ?>
                        <p class="text-green-600 mt-4"><?php echo $wishlist_message; ?></p>
                    <?php endif; ?>
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <p class="text-red-600 mt-4">Please <a href="/login.php" class="underline">log in</a> to add items to cart or wishlist.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Related Products Section -->
            <div class="mt-12">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">More from This Artisan</h2>
                <?php if (!empty($related_products)): ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                        <?php foreach ($related_products as $related): ?>
                            <div class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition">
                                <img src="<?php echo htmlspecialchars($related['image_url'] ?: 'https://via.placeholder.com/200'); ?>" 
                                     alt="<?php echo htmlspecialchars($related['name']); ?>" 
                                     class="w-full h-48 object-cover rounded-md mb-4">
                                <h3 class="text-lg font-semibold text-gray-800"><?php echo htmlspecialchars($related['name']); ?></h3>
                                <p class="text-green-600 font-semibold mb-4">KSh <?php echo number_format($related['price'], 2); ?></p>
                                <a href="product_details.php?id=<?php echo $related['id']; ?>" 
                                   class="block text-center bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                                    View Details
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-600">No other products from this artisan.</p>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <h2 class="text-2xl font-bold text-gray-800">Product Not Found</h2>
                <p class="text-gray-600 mt-4">The product you are looking for does not exist or has been removed.</p>
                <a href="/products.php" class="mt-4 inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Browse Products</a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6">
        <div class="container mx-auto px-4 text-center">
            <p>© 2025 Juakali. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>