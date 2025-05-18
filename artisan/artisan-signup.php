<?php
session_start();
require_once '../functions.php'; // Ensure $pdo is correctly initialized in this file

if (isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password']; // You'll check its length later
    $location = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_STRING);
    $bio = filter_input(INPUT_POST, 'bio', FILTER_SANITIZE_STRING);
    $image_url = null;
    $error = null; // Initialize error variable

    // --- START: Email Existence Check ---
    if (empty($email)) {
        $error = "Email is required.";
    } else {
        $stmt_check_email = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt_check_email->execute([$email]);
        if ($stmt_check_email->fetch()) {
            $error = "This email address is already registered. Please use a different email or login.";
        }
    }
    // --- END: Email Existence Check ---

    // Proceed only if there was no email error
    if (!$error) {
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $image_url = uploadImage($_FILES['image']);
            if ($image_url === false) { // Assuming uploadImage returns false on failure
                $error = "Failed to upload image.";
            }
        }
    }

    // Proceed only if there was no email or image upload error
    if (!$error) {
        if ($password && strlen($password) >= 8) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $pdo->beginTransaction();
            try {
                // Insert into users table
                $stmt_user = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
                $stmt_user->execute([$name, $email, $hashed_password]);
                $user_id = $pdo->lastInsertId();

                // Insert into artisans table (Corrected query)
                $stmt_artisan = $pdo->prepare("INSERT INTO artisans (user_id, bio, location, image_url) VALUES (?, ?, ?, ?)");
                $stmt_artisan->execute([$user_id, $bio, $location, $image_url]);

                $pdo->commit();
                header("Location: artisan-login.php"); // Or a success page
                exit();

            } catch (PDOException $e) {
                $pdo->rollBack();
                error_log("Signup PDOException: " . $e->getMessage() . " Code: " . $e->getCode());

                if ($e->getCode() == '23000') {
                    $error = "Signup failed. The email address might already be in use, or another unique field is duplicated.";
                } else {
                    $error = "Signup failed due to a database error. Please try again later.";
                }
            }
        } else {
            $error = "Password must be at least 8 characters long.";
        }
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
        body { font-family: 'Ubuntu', sans-serif; background-color: #f8f1e9; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; padding: 1rem 0; } /* Added min-height and padding for scroll */
        .signup-container { background: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 100%; max-width: 450px; } /* Increased max-width slightly */
        .section-title { font-family: 'Lora', serif; color: #FF5733; text-align: center; margin-bottom: 1.5rem; }
        .btn-custom { background-color: #FFA500; color: #fff; border: none; width: 100%; padding: 0.75rem; font-size: 1rem; min-height: 48px; }
        .btn-custom:hover { background-color: #cc8400; }
        .error { color: red; text-align: center; margin-bottom: 1rem; background-color: #ffe0e0; border: 1px solid red; padding: 0.5rem; border-radius: 4px;}
        .form-label { font-weight: 500; }
        @media (max-width: 768px) { .signup-container { margin: 1rem; padding: 1.5rem; } .btn-custom { font-size: 0.9rem; padding: 0.6rem; } }
    </style>
</head>
<body>
    <div class="signup-container">
        <h2 class="section-title">Artisan Signup</h2>
        <?php if (!empty($error)): ?> {/* Changed isset to !empty for better practice and display it */}
            <p class='error'><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password (min. 8 characters)</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Location (e.g., City, Area)</label>
                <input type="text" class="form-control" id="location" name="location" value="<?php echo isset($_POST['location']) ? htmlspecialchars($_POST['location']) : ''; ?>">
            </div>
            <div class="mb-3">
                <label for="bio" class="form-label">Bio (Tell us about your craft)</label>
                <textarea class="form-control" id="bio" name="bio" rows="3"><?php echo isset($_POST['bio']) ? htmlspecialchars($_POST['bio']) : ''; ?></textarea>
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