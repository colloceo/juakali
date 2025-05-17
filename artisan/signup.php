<?php
session_start();
require_once '../functions.php';

if (isset($_SESSION['user_id'])) {
    header("Location: artisan-dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $location = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_STRING);
    $bio = filter_input(INPUT_POST, 'bio', FILTER_SANITIZE_STRING);
    $image_url = null;

    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $image_url = uploadImage($_FILES['image']);
    }

    if ($password && strlen($password) >= 8) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $hashed_password]);
            $user_id = $pdo->lastInsertId();
            $stmt = $pdo->prepare("INSERT INTO artisans (name, bio, location, image_url, user_id) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $bio, $location, $image_url, $user_id]);
            $pdo->commit();
            header("Location: artisan-login.php");
            exit();
        } catch (PDOException $e) {
            $pdo->rollBack();
            $error = "Signup failed. Email may already be in use.";
        }
    } else {
        $error = "Password must be at least 8 characters.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JuaKali - Artisan Signup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;700&family=Lora:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Ubuntu', sans-serif; background-color: #f8f1e9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .signup-container { background: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        .section-title { font-family: 'Lora', serif; color: #FF5733; text-align: center; }
        .btn-custom { background-color: #FFA500; color: #fff; border: none; width: 100%; padding: 0.75rem; font-size: 1rem; min-height: 48px; }
        .error { color: red; text-align: center; }
        @media (max-width: 768px) { .signup-container { margin: 1rem; padding: 1rem; } .btn-custom { font-size: 0.9rem; padding: 0.5rem; } }
    </style>
</head>
<body>
    <div class="signup-container">
        <h2 class="section-title">Artisan Signup</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" class="form-control" id="location" name="location">
            </div>
            <div class="mb-3">
                <label for="bio" class="form-label">Bio</label>
                <textarea class="form-control" id="bio" name="bio" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Profile Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
            </div>
            <button type="submit" class="btn btn-custom">Sign Up</button>
            <p class="text-center mt-3">Already have an account? <a href="artisan-login.php">Login</a></p>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>