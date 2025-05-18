<?php
session_start();
require_once '../functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$artisan = getArtisanByUserId($user_id);
if (!$artisan) {
    header("Location: index.php");
    exit();
}

$error = null;
$success = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
    $image_url = null;

    // Validate inputs
    if (empty($name)) {
        $error = "Product name is required.";
    } elseif (strlen($name) > 255) {
        $error = "Product name cannot exceed 255 characters.";
    } elseif ($price === false || $price <= 0) {
        $error = "Please provide a valid price greater than 0.";
    }

    // Handle image upload
    if (!$error && isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_file_size = 2 * 1024 * 1024; // 2MB

        if (!in_array($_FILES['image']['type'], $allowed_types)) {
            $error = "Invalid image format. Only JPEG, PNG, and GIF are allowed.";
        } elseif ($_FILES['image']['size'] > $max_file_size) {
            $error = "Image size exceeds the maximum limit of 2MB.";
        }

        if (!$error) {
            $upload_result = uploadImage($_FILES['image']);
            if ($upload_result === false) {
                $error = "Failed to upload image. Please try again.";
            } else {
                $image_url = $upload_result;
            }
        }
    } elseif (!$error && (!isset($_FILES['image']) || $_FILES['image']['error'] == UPLOAD_ERR_NO_FILE)) {
        // Optional: Set a default image URL if no image is uploaded
        $image_url = 'images/default_product.png'; // Replace with your default image path
    } elseif (!$error && isset($_FILES['image']) && $_FILES['image']['error'] != UPLOAD_ERR_NO_FILE) {
        $error = "Error uploading image.";
    }

    // Create product if no errors
    if (!$error) {
        if (createProduct($artisan['id'], $name, $description, $price, $image_url)) {
            $success = "Product uploaded successfully! Awaiting admin approval.";
            // Clear form fields after successful upload
            $_POST = [];
        } else {
            $error = "Failed to upload product to the database. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JuaKali - Upload Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;700&family=Lora:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Ubuntu', sans-serif; background-color: #f8f1e9; }
        .navbar { background-color: #FF5733; padding: 1rem; }
        .navbar-brand, .nav-link { color: #FFD700 !important; font-weight: bold; }
        .upload-container { padding: 2rem; max-width: 600px; margin: 0 auto; }
        .upload-form { background: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .section-title { font-family: 'Lora', serif; color: #FF5733; text-align: center; margin-bottom: 1.5rem; }
        .btn-custom { background-color: #FFA500; color: #fff; border: none; padding: 0.75rem; font-size: 1rem; min-height: 48px; width: 100%; }
        .error { color: red; text-align: center; margin-bottom: 1rem; background-color: #ffe0e0; border: 1px solid red; padding: 0.5rem; border-radius: 4px;}
        .success { color: green; text-align: center; margin-bottom: 1rem; background-color: #e0ffe0; border: 1px solid green; padding: 0.5rem; border-radius: 4px;}
        footer { background-color: #FF5733; color: #FFD700; padding: 1rem; text-align: center; }
        #imagePreview { max-width: 150px; margin-top: 10px; display: block; }
        @media (max-width: 768px) {
            .upload-container { padding: 1rem; }
            .upload-form { padding: 1rem; }
            .navbar-brand, .nav-link { font-size: 0.9rem; }
            .btn-custom { font-size: 0.9rem; padding: 0.5rem; }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">JuaKali</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                 <ul class="navbar-nav ms-auto">
                     <li class="nav-item"><a class="nav-link" href="artisan-dashboard.php">Dashboard</a></li>
                     <li class="nav-item"><a class="nav-link" href="artisan-product-upload.php">Upload Product</a></li>
                     <li class="nav-item"><a class="nav-link" href="artisan-options.php">Profile</a></li>
                     <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                 </ul>
            </div>
        </div>
    </nav>

    <div class="upload-container">
        <h2 class="section-title">Upload a New Product</h2>
        <div class="upload-form">
            <?php if (isset($error)): ?>
                <p class='error'><?php echo $error; ?></p>
            <?php endif; ?>
            <?php if (isset($success)): ?>
                <p class='success'><?php echo $success; ?></p>
            <?php endif; ?>
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3"><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Price (KES)</label>
                    <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?php echo isset($_POST['price']) ? htmlspecialchars($_POST['price']) : ''; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Product Image</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    <img id="imagePreview" src="#" alt="Image preview" style="display: none;">
                </div>
                <button type="submit" class="btn btn-custom">Upload Product</button>
            </form>
        </div>
    </div>

    <footer>
        <p>© 2025 JuaKali. All rights reserved.</p>
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
                imagePreview.src = '#';
                imagePreview.style.display = 'none';
            }
        });
    </script>
</body>
</html>