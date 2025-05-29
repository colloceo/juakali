<?php
session_start();
require_once '../functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: artisan-login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$artisan = getArtisanByUserId($user_id);
if (!$artisan) {
    header("Location: artisan-index.php"); // Or redirect to a page prompting them to register as an artisan
    exit();
}

$success_message = null;
$error_message = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $location = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_STRING);
    $bio = filter_input(INPUT_POST, 'bio', FILTER_SANITIZE_STRING);
    $image_url = $artisan['image_url']; // Start with current image URL

    // Handle image upload if a new file is provided
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $uploaded_image_url = uploadImage($_FILES['image']);
        if ($uploaded_image_url) {
            $image_url = $uploaded_image_url;
            // Optionally, delete old image file if it exists and is not a default/placeholder
            // This would require more sophisticated file path handling
        } else {
            $error_message = $_SESSION['error_message']; // Get error from uploadImage function
            unset($_SESSION['error_message']); // Clear it for this session
        }
    }

    // Only attempt to update if no image upload errors occurred
    if (!$error_message) {
        if (updateArtisan($artisan['id'], $name, $bio, $location, $image_url)) {
            $success_message = "Profile updated successfully!";
            $artisan = getArtisanByUserId($user_id); // Refresh artisan data to display updated info
        } else {
            $error_message = "Failed to update profile. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JuaKali - Artisan Profile Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;700&family=Lora:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body { font-family: 'Ubuntu', sans-serif; background-color: #f8f1e9; color: #333; }
        .navbar { background-color: #FF5733; padding: 1rem 0; }
        .navbar-brand { color: #FFD700 !important; font-family: 'Lora', serif; font-size: 1.8rem; font-weight: bold; }
        .navbar-nav .nav-link { color: #fff !important; margin-right: 15px; }
        .navbar-nav .nav-link:hover { color: #FFD700 !important; }
        .profile-container { background-color: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); margin-top: 2rem; max-width: 700px; margin-left: auto; margin-right: auto; }
        h2 { font-family: 'Lora', serif; color: #FF5733; text-align: center; margin-bottom: 1.5rem; }
        .btn-custom { background-color: #FFA500; color: #fff; border: none; padding: 10px 20px; border-radius: 5px; text-decoration: none; display: inline-block; }
        .btn-custom:hover { background-color: #e69500; color: #fff; }
        .form-label { font-weight: bold; }
        footer { background-color: #333; color: #fff; padding: 1.5rem 0; text-align: center; margin-top: 3rem; }
        footer a { color: #FFD700; text-decoration: none; margin: 0 10px; }
        footer a:hover { text-decoration: underline; }
        .social-icons a { color: #fff; font-size: 1.5rem; margin: 0 10px; }
        .social-icons a:hover { color: #FFD700; }
        .message-box {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 5px;
            text-align: center;
        }
        .message-box.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .message-box.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="artisan-dashboard.php">JuaKali Artisan</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="artisan-dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="artisan-product-upload.php">Upload Product</a></li>
                    <li class="nav-item"><a class="nav-link" href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container profile-container">
        <h2>Profile Settings for <?php echo htmlspecialchars($artisan['name']); ?></h2>

        <?php if ($success_message): ?>
            <div class="message-box success">
                <?php echo htmlspecialchars($success_message); ?>
            </div>
        <?php endif; ?>

        <?php if ($error_message): ?>
            <div class="message-box error">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Artisan Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($artisan['name'] ?? ''); ?>" required>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" class="form-control" id="location" name="location" value="<?php echo htmlspecialchars($artisan['location'] ?? ''); ?>">
            </div>
            <div class="mb-3">
                <label for="bio" class="form-label">Bio</label>
                <textarea class="form-control" id="bio" name="bio" rows="3"><?php echo htmlspecialchars($artisan['bio'] ?? ''); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Profile Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                <?php if ($artisan['image_url']): ?>
                    <p class="mt-2">Current Image:</p>
                    <img src="<?php echo htmlspecialchars($artisan['image_url']); ?>" alt="Current Profile Image" style="max-width: 200px; height: auto; border-radius: 8px; margin-top: 0.5rem; border: 1px solid #ddd;">
                <?php else: ?>
                    <p class="mt-2 text-muted">No profile image uploaded yet.</p>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-custom">Save Changes</button>
        </form>
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
