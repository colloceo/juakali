<?php
session_start();
require_once '../functions.php';

if (isset($_SESSION['admin_id'])) {
    header("Location: admin-dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } elseif (strlen($password) < 8) {
        $error = "Password must be at least 8 characters long.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO admins (username, password, created_at) VALUES (?, ?, NOW())");
        if ($stmt->execute([$username, $hashed_password])) {
            header("Location: admin-login.php");
            exit();
        } else {
            $error = "Username already exists or an error occurred.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JuaKali - Admin Signup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;700&family=Lora:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Ubuntu', sans-serif; background-color: #f8f1e9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .signup-container { background: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        .signup-container h2 { font-family: 'Lora', serif; color: #FF5733; text-align: center; }
        .btn-custom { background-color: #FFA500; color: #fff; border: none; width: 100%; padding: 0.75rem; font-size: 1rem; min-height: 48px; margin-bottom: 1rem; }
        .error { color: red; text-align: center; }
        @media (max-width: 768px) { .signup-container { margin: 1rem; padding: 1rem; } .btn-custom { font-size: 0.9rem; padding: 0.5rem; } }
    </style>
</head>
<body>
    <div class="signup-container">
        <h2>Admin Signup</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn btn-custom">Sign Up</button>
            <p class="text-center mt-3">Already have an account? <a href="admin-login.php">Login</a></p>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>