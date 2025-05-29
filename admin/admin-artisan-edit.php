<?php
session_start();
require_once '../functions.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

$artisan = null;
$error = null;
$success = null;

// Fetch artisan details if an ID is provided
if (isset($_GET['id'])) {
    $artisan_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if ($artisan_id) {
        // Fetch artisan details including linked user email
        $stmt = $pdo->prepare("SELECT a.*, u.email AS user_email FROM artisans a JOIN users u ON a.user_id = u.id WHERE a.id = ?");
        $stmt->execute([$artisan_id]);
        $artisan = $stmt->fetch();

        if (!$artisan) {
            $_SESSION['error_message'] = "Artisan not found.";
            header("Location: admin-dashboard.php?tab=artisans");
            exit();
        }
    } else {
        $_SESSION['error_message'] = "Invalid artisan ID.";
        header("Location: admin-dashboard.php?tab=artisans");
        exit();
    }
} else {
    $_SESSION['error_message'] = "No artisan ID provided for editing.";
    header("Location: admin-dashboard.php?tab=artisans");
    exit();
}

// Handle form submission for updating artisan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $bio = filter_input(INPUT_POST, 'bio', FILTER_SANITIZE_STRING);
    $location = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_STRING);
    $current_image_url = $artisan['image_url']; // Keep current image if no new one is uploaded

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $uploaded_image_url = uploadImage($_FILES['image']);
        if ($uploaded_image_url) {
            $current_image_url = $uploaded_image_url;
        } else {
            $error = $_SESSION['error_message'] ?? "Error uploading new image.";
            unset($_SESSION['error_message']);
        }
    }

    if (!$error) {
        if (updateArtisan($artisan['id'], $name, $bio, $location, $current_image_url)) {
            $_SESSION['success_message'] = "Artisan profile updated successfully!";
            header("Location: admin-dashboard.php?tab=artisans");
            exit();
        } else {
            $error = "Failed to update artisan profile. Please try again.";
        }
    }
    // Refresh artisan data in case of error to keep form pre-filled
    $stmt = $pdo->prepare("SELECT a.*, u.email AS user_email FROM artisans a JOIN users u ON a.user_id = u.id WHERE a.id = ?");
    $stmt->execute([$artisan_id]);
    $artisan = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JuaKali - Edit Artisan</title>
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
        #imagePreview { max-width: 150px; height: auto; margin-top: 1rem; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
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
        <h2>Edit Artisan: <?php echo htmlspecialchars($artisan['name'] ?? ''); ?></h2>
        <p class="text-muted text-center">Linked User Email: <?php echo htmlspecialchars($artisan['user_email'] ?? 'N/A'); ?></p>

        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>

        <?php if ($artisan): ?>
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
                    <label for="image" class="form-label">Profile Image (Leave blank to keep current)</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    <?php if ($artisan['image_url']): ?>
                        <img id="imagePreview" src="<?php echo htmlspecialchars($artisan['image_url']); ?>" alt="Current Artisan Image" style="max-width: 200px; height: auto; margin-top: 0.5rem; border-radius: 8px; border: 1px solid #ddd;">
                    <?php else: ?>
                        <img id="imagePreview" src="https://placehold.co/150x150/cccccc/333333?text=No+Image" alt="No Image" style="display: block;">
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-custom">Save Changes</button>
            </form>
        <?php else: ?>
            <p class="text-center">Artisan details could not be loaded. Please return to the <a href="admin-dashboard.php?tab=artisans">artisans list</a>.</p>
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
    <script>
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('imagePreview');

        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                // If no file selected, revert to current image or placeholder
                <?php if ($artisan['image_url']): ?>
                    imagePreview.src = "<?php echo htmlspecialchars($artisan['image_url']); ?>";
                <?php else: ?>
                    imagePreview.src = "https://placehold.co/150x150/cccccc/333333?text=No+Image";
                <?php endif; ?>
            }
        });
    </script>
</body>
</html>
