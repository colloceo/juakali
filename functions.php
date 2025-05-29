<?php
require_once 'config.php';

// Login a user by email and password
function loginUser($email, $password) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        return true;
    }
    return false;
}

// Register a new user
function registerUser($name, $email, $password, $phone = null) {
    global $pdo;
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password, phone) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$name, $email, $hashed_password, $phone]);
}

// Add a product to the cart
function addToCart($user_id, $product_id, $quantity) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE quantity = quantity + ?");
    return $stmt->execute([$user_id, $product_id, $quantity, $quantity]);
}

// Fetch cart items for a user
function getCartItems($user_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT c.*, p.name, p.price FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = ?");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Remove a product from the cart
function removeFromCart($user_id, $product_id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
    return $stmt->execute([$user_id, $product_id]);
}

// Create a new order
function createOrder($user_id, $total, $payment_method, $delivery_option) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO orders (user_id, total, payment_method, delivery_option) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $total, $payment_method, $delivery_option]);
    return $pdo->lastInsertId();
}

// Add an item to an order
function addOrderItem($order_id, $product_id, $quantity, $price) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$order_id, $product_id, $quantity, $price]);
}

// Fetch all orders for a user
function getUserOrders($user_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT o.*, oi.product_id, oi.quantity, p.name FROM orders o JOIN order_items oi ON o.id = oi.order_id JOIN products p ON oi.product_id = p.id WHERE o.user_id = ?");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Approve a product
function approveProduct($product_id) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE products SET status = 'Approved' WHERE id = ?");
    return $stmt->execute([$product_id]);
}

// Create a new artisan
function createArtisan($name, $bio, $location, $image_url = null) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO artisans (name, bio, location, image_url) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$name, $bio, $location, $image_url]);
}

// Fetch all artisans
function getAllArtisans() {
    global $pdo;
    return $pdo->query("SELECT * FROM artisans")->fetchAll(PDO::FETCH_ASSOC);
}

// Fetch an artisan by ID
function getArtisanById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM artisans WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Update an artisan's details
function updateArtisan($id, $name, $bio, $location, $image_url = null) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE artisans SET name = ?, bio = ?, location = ?, image_url = ? WHERE id = ?");
    return $stmt->execute([$name, $bio, $location, $image_url, $id]);
}

// Delete an artisan
function deleteArtisan($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM artisans WHERE id = ?");
    return $stmt->execute([$id]);
}

// Fetch products for an artisan
function getArtisanProducts($artisan_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM products WHERE artisan_id = ? AND status = 'Approved'");
    $stmt->execute([$artisan_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Add a rating for an artisan
function addRating($artisan_id, $user_id, $rating, $comment = null) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO ratings (artisan_id, user_id, rating, comment) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$artisan_id, $user_id, $rating, $comment])) {
        updateArtisanRating($artisan_id);
        return true;
    }
    return false;
}

// Fetch ratings for an artisan
function getRatings($artisan_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT r.*, u.name FROM ratings r JOIN users u ON r.user_id = u.id WHERE r.artisan_id = ?");
    $stmt->execute([$artisan_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Update an artisan's average rating
function updateArtisanRating($artisan_id) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE artisans a SET average_rating = (SELECT AVG(rating) FROM ratings WHERE artisan_id = ?) WHERE a.id = ?");
    $stmt->execute([$artisan_id, $artisan_id]);
}

// Upload an image and return the file path
function uploadImage($file) {
    $root_dir = dirname(__DIR__);
    $target_dir = $root_dir . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR;
    
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }
    
    $target_file = $target_dir . basename($file["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    
    if (!in_array($imageFileType, $allowed_types)) {
        return null;
    }
    
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return "uploads/" . basename($file["name"]);
    }
    return null;
}

// Create a new product
function createProduct($artisan_id, $name, $description, $price, $image_url = null) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO products (artisan_id, name, description, price, image_url, status) VALUES (?, ?, ?, ?, ?, 'Pending')");
    return $stmt->execute([$artisan_id, $name, $description, $price, $image_url]);
}

// Fetch an artisan by user ID
function getArtisanByUserId($user_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM artisans WHERE user_id = ?");
    $stmt->execute([$user_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Fetch featured artisans with detailed info
function getFeaturedArtisansDetailed(int $limit = 3): array {
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT
            u.id,
            u.name,
            a.bio,
            a.image_url AS profile_image_url,
            COUNT(p.id) AS product_count
        FROM users u
        JOIN artisans a ON u.id = a.user_id
        LEFT JOIN products p ON a.user_id = p.artisan_id AND p.approval_status = 'approved'
        WHERE a.is_featured = 1
        GROUP BY u.id, u.name, a.bio, a.image_url
        ORDER BY u.name
        LIMIT :limit
    ");
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fetch popular products
function getPopularProducts(int $limit = 8): array {
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT
            p.id,
            p.name,
            p.description,
            p.price,
            p.image_url
        FROM products p
        WHERE p.approval_status = 'approved'
        ORDER BY p.created_at DESC
        LIMIT :limit
    ");
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fetch product categories
function getProductCategories(int $limit = 6): array {
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT id, name, image_url
        FROM categories
        LIMIT :limit
    ");
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fetch recent artisan spotlights
function getRecentArtisanSpotlights(int $limit = 3): array {
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT
            s.id,
            s.title,
            s.content,
            s.created_at,
            u.name AS author_name
        FROM spotlights s
        LEFT JOIN users u ON s.author_id = u.id
        ORDER BY s.created_at DESC
        LIMIT :limit
    ");
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addToWishlist($user_id, $product_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM wishlist WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$user_id, $product_id]);
    if (!$stmt->fetch()) {
        $stmt = $pdo->prepare("INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)");
        return $stmt->execute([$user_id, $product_id]);
    }
    return true;
}

function removeFromWishlist($user_id, $product_id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM wishlist WHERE user_id = ? AND product_id = ?");
    return $stmt->execute([$user_id, $product_id]);
}

function getWishlistItems($user_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT w.*, p.name, p.price FROM wishlist w JOIN products p ON w.product_id = p.id WHERE w.user_id = ?");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getProductById($productId) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$productId]);
    return $stmt->fetch();
}

function updateProduct($productId, $name, $description, $price, $category, $image_url) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("UPDATE products SET name = ?, description = ?, price = ?, category = ?, image_url = ? WHERE id = ?");
        return $stmt->execute([$name, $description, $price, $category, $image_url, $productId]);
    } catch (PDOException $e) {
        error_log("Product update error: " . $e->getMessage());
        return false;
    }
}

function deleteProduct($productId) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$productId]);
    } catch (PDOException $e) {
        error_log("Product deletion error: " . $e->getMessage());
        return false;
    }
}

function getArtisanOrdersDetailed($artisanId) {
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT
            o.id AS order_id,
            o.created_at AS order_date,
            o.total,
            o.payment_status,
            o.delivery_option,
            o.status AS order_status, -- Assuming 'status' column exists in orders table
            o.tracking_number,        -- Assuming 'tracking_number' column exists in orders table
            u.name AS customer_name,
            u.email AS customer_email,
            a.street,
            a.city,
            a.state,
            a.postal_code,
            a.country,
            GROUP_CONCAT(CONCAT(oi.quantity, ' x ', p.name) SEPARATOR '; ') AS products_summary
        FROM orders o
        JOIN order_items oi ON o.id = oi.order_id
        JOIN products p ON oi.product_id = p.id
        JOIN users u ON o.user_id = u.id
        LEFT JOIN addresses a ON u.id = a.user_id -- LEFT JOIN to include orders even if address is missing
        WHERE p.artisan_id = ?
        GROUP BY o.id
        ORDER BY o.created_at DESC
    ");
    $stmt->execute([$artisanId]);
    return $stmt->fetchAll();
}

function updateOrderStatus($orderId, $status) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $orderId]);
    } catch (PDOException $e) {
        error_log("Order status update error: " . $e->getMessage());
        return false;
    }
}

function updateOrderTracking($orderId, $trackingNumber) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("UPDATE orders SET tracking_number = ? WHERE id = ?");
        return $stmt->execute([$trackingNumber, $orderId]);
    } catch (PDOException $e) {
        error_log("Order tracking update error: " . $e->getMessage());
        return false;
    }
}

function getArtisanProductReviews($artisanId) {
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT
            r.id AS review_id,
            r.rating,
            r.comment,
            r.created_at AS review_date,
            r.artisan_response, -- Assuming this column exists
            u.name AS customer_name,
            p.name AS product_name,
            p.id AS product_id
        FROM ratings r
        JOIN products p ON r.product_id = p.id
        JOIN users u ON r.user_id = u.id
        WHERE p.artisan_id = ?
        ORDER BY r.created_at DESC
    ");
    $stmt->execute([$artisanId]);
    return $stmt->fetchAll();
}

function updateArtisanReviewResponse($reviewId, $response) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("UPDATE ratings SET artisan_response = ? WHERE id = ?");
        return $stmt->execute([$response, $reviewId]);
    } catch (PDOException $e) {
        error_log("Artisan review response update error: " . $e->getMessage());
        return false;
    }
}

?>