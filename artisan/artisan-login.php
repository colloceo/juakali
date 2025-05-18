<?php
require_once '../functions.php';

if (isset($_SESSION['user_id'])) {
    header("Location: artisan-dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (loginUser($email, $password)) {
        $artisan = getArtisanByUserId($_SESSION['user_id']);
        if ($artisan) {
            header("Location: artisan-dashboard.php");
        } else {
            $error = "This account is not registered as an artisan.";
        }
    } else {
        $error = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JuaKali - Artisan Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;700&family=Lora:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Ubuntu', sans-serif; background-color: #f8f1e9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-container { background: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        .section-title { font-family: 'Lora', serif; color: #FF5733; text-align: center; }
        .btn-custom { background-color: #FFA500; color: #fff; border: none; width: 100%; padding: 0.75rem; font-size: 1rem; min-height: 48px; }
        .error { color: red; text-align: center; }
        @media (max-width: 768px) { .login-container { margin: 1rem; padding: 1rem; } .btn-custom { font-size: 0.9rem; padding: 0.5rem; } }
    </style>
</head>
<body>
    <div class="login-container">
        <h2 class="section-title">Artisan Login</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-custom">Login</button>
            <p class="text-center mt-3">New artisan? <a href="artisan-signup.php">Sign Up</a></p>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>