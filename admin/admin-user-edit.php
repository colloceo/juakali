<?php
session_start();
require_once '../functions.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

$user = null;
$error = null;
$success = null;

// Fetch user details if an ID is provided
if (isset($_GET['id'])) {
    $user_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if ($user_id) {
        $user = getUserByIdAdmin($user_id); // Use the admin-specific user fetch
        if (!$user) {
            $_SESSION['error_message'] = "User not found.";
            header("Location: admin-dashboard.php?tab=users");
            exit();
        }
    } else {
        $_SESSION['error_message'] = "Invalid user ID.";
        header("Location: admin-dashboard.php?tab=users");
        exit();
    }
} else {
    $_SESSION['error_message'] = "No user ID provided for editing.";
    header("Location: admin-dashboard.php?tab=users");
    exit();
}

// Handle form submission for updating user
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password']; // Get plain password for hashing
    $confirm_password = $_POST['confirm_password'];

    // Basic validation
    if (empty($name) || empty($email)) {
        $error = "Name and Email are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    }

    // Password validation if provided
    if (!empty($password)) {
        if (strlen($password) < 8) {
            $error = "Password must be at least 8 characters long.";
        } elseif ($password !== $confirm_password) {
            $error = "Passwords do not match.";
        }
    }

    if (!$error) {
        // Check if email already exists for another user (only if email is changed)
        if ($email !== $user['email']) {
            $stmt_check_email = $pdo->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
            $stmt_check_email->execute([$email, $user_id]);
            if ($stmt_check_email->fetch()) {
                $error = "This email address is already registered to another user.";
            }
        }
    }

    if (!$error) {
        if (updateUser($user_id, $name, $email, !empty($password) ? $password : null)) {
            $_SESSION['success_message'] = "User updated successfully!";
            header("Location: admin-dashboard.php?tab=users");
            exit();
        } else {
            $error = "Failed to update user. Please try again.";
        }
    }
    // Refresh user data in case of error to keep form pre-filled
    $user = getUserByIdAdmin($user_id);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JuaKali - Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;700&family=Lora:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Ubuntu', sans-serif; background-color: #f8f1e9; color: #333; }
        .navbar { background-color: #FF5733; padding: 1rem 0; }
        .navbar-brand { color: #FFD700 !important; font-family: 'Lora', serif; font-size: 1.8rem; font-weight: bold; }
        .navbar-nav .nav-link { color: #fff !important; margin-right: 15px; }
        .navbar-nav .nav-link:hover { color: #FFD700 !important; }
        .form-container { background-color: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); margin-top: 2rem; max-width: 600px; margin-left: auto; margin-right: auto; }
        h2 { font-family: 'Lora', serif; color: #FF5733; text-align: center; margin-bottom: 2rem; }
        .btn-custom { background-color: #FFA500; color: #fff; border: none; width: 100%; padding: 0.75rem; font-size: 1rem; min-height: 48px; }
        .btn-custom:hover { background-color: #e69500; color: #fff; }
        .error { color: red; text-align: center; margin-bottom: 1rem; }
        .success { color: green; text-align: center; margin-bottom: 1rem; }
        footer { background-color: #333; color: #fff; padding: 1.5rem 0; text-align: center; margin-top: 3rem; }
        footer a { color: #FFD700; text-decoration: none; margin: 0 10px; }
        footer a:hover { text-decoration: underline; }
        .social-icons a { color: #fff; font-size: 1.5rem; margin: 0 10px; }
        .social-icons a:hover { color: #FFD700; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="admin-dashboard.php">JuaKali Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="admin-dashboard.php?tab=overview">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin-dashboard.php?tab=artisans">Manage Artisans</a></li>
                    <li class="nav-item"><a class="nav-link" href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container form-container">
        <h2>Edit User: <?php echo htmlspecialchars($user['name'] ?? ''); ?></h2>

        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>

        <?php if ($user): ?>
            <form method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">User Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">New Password (leave blank to keep current)</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm New Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                </div>
                <button type="submit" class="btn btn-custom">Save Changes</button>
            </form>
        <?php else: ?>
            <p class="text-center">User details could not be loaded. Please return to the <a href="admin-dashboard.php?tab=users">users list</a>.</p>
        <?php endif; ?>
    </div>

    <footer>
        <div class="container">
            <p>© 2025 JuaKali. All rights reserved.</p>
            <div class="mt-2">
                <a href="terms.php">Terms</a> |
                <a href="privacy.php">Privacy</a> |
                <a href="contact.php">Contact</a>
            </div>
            <div class="social-icons mt-3">
                <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
