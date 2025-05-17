<?php
require_once 'config.php';

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

function registerUser($name, $email, $password, $phone = null) {
    global $pdo;
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password, phone) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$name, $email, $hashed_password, $phone]);
}

function addToCart($user_id, $product_id, $quantity) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE quantity = quantity + ?");
    return $stmt->execute([$user_id, $product_id, $quantity, $quantity]);
}

function getCartItems($user_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT c.*, p.name, p.price FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = ?");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function removeFromCart($user_id, $product_id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
    return $stmt->execute([$user_id, $product_id]);
}

function createOrder($user_id, $total, $payment_method, $delivery_option) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO orders (user_id, total, payment_method, delivery_option) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $total, $payment_method, $delivery_option]);
    return $pdo->lastInsertId();
}

function addOrderItem($order_id, $product_id, $quantity, $price) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$order_id, $product_id, $quantity, $price]);
}

function getUserOrders($user_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT o.*, oi.product_id, oi.quantity, p.name FROM orders o JOIN order_items oi ON o.id = oi.order_id JOIN products p ON oi.product_id = p.id WHERE o.user_id = ?");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function approveProduct($product_id) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE products SET status = 'Approved' WHERE id = ?");
    return $stmt->execute([$product_id]);
}

function createArtisan($name, $bio, $location, $image_url = null) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO artisans (name, bio, location, image_url) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$name, $bio, $location, $image_url]);
}

function getAllArtisans() {
    global $pdo;
    return $pdo->query("SELECT * FROM artisans")->fetchAll(PDO::FETCH_ASSOC);
}

function getArtisanById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM artisans WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateArtisan($id, $name, $bio, $location, $image_url = null) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE artisans SET name = ?, bio = ?, location = ?, image_url = ? WHERE id = ?");
    return $stmt->execute([$name, $bio, $location, $image_url, $id]);
}

function deleteArtisan($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM artisans WHERE id = ?");
    return $stmt->execute([$id]);
}

function getArtisanProducts($artisan_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM products WHERE artisan_id = ? AND status = 'Approved'");
    $stmt->execute([$artisan_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addRating($artisan_id, $user_id, $rating, $comment = null) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO ratings (artisan_id, user_id, rating, comment) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$artisan_id, $user_id, $rating, $comment])) {
        updateArtisanRating($artisan_id);
        return true;
    }
    return false;
}

function getRatings($artisan_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT r.*, u.name FROM ratings r JOIN users u ON r.user_id = u.id WHERE r.artisan_id = ?");
    $stmt->execute([$artisan_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function updateArtisanRating($artisan_id) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE artisans a SET average_rating = (SELECT AVG(rating) FROM ratings WHERE artisan_id = ?) WHERE a.id = ?");
    $stmt->execute([$artisan_id, $artisan_id]);
}

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

function createProduct($artisan_id, $name, $description, $price, $image_url = null) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO products (artisan_id, name, description, price, image_url, status) VALUES (?, ?, ?, ?, ?, 'Pending')");
    return $stmt->execute([$artisan_id, $name, $description, $price, $image_url]);
}

function getArtisanByUserId($user_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM artisans WHERE user_id = ?");
    $stmt->execute([$user_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>