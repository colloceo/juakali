<?php
session_start();
require_once '../functions.php';

// Check if the user is logged in and is an artisan
if (!isset($_SESSION['user_id'])) {
    header("Location: artisan-login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$artisan = getArtisanByUserId($user_id);
if (!$artisan) {
    header("Location: artisan-index.php"); // Redirect if not an artisan
    exit();
}

$artisan_id = $artisan['id'];
$product = null;
$error = null;
$success = null;

// Define categories (should ideally be fetched from DB or a config)
$categories = ['Decor', 'Textiles', 'Food', 'Personal Care', 'Jewelry', 'Art', 'Clothing', 'Home Goods'];

// Fetch product details if an ID is provided
if (isset($_GET['id'])) {
    $product_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if ($product_id) {
        $product = getProductById($product_id);
        // Ensure the product belongs to the current artisan
        if (!$product || $product['artisan_id'] != $artisan_id) {
            $_SESSION['error_message'] = "Product not found or you don't have permission to edit it.";
            header("Location: artisan-dashboard.php");
            exit();
        }
    } else {
        $_SESSION['error_message'] = "Invalid product ID.";
        header("Location: artisan-dashboard.php");
        exit();
    }
} else {
    $_SESSION['error_message'] = "No product ID provided for editing.";
    header("Location: artisan-dashboard.php");
    exit();
}

// Handle form submission for updating product
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
    $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING);
    $current_image_url = $product['image_url']; // Keep current image if no new one is uploaded

    // Validate inputs
    if (empty($name)) {
        $error = "Product name is required.";
    } elseif (strlen($name) > 255) {
        $error = "Product name cannot exceed 255 characters.";
    } elseif ($price === false || $price <= 0) {
        $error = "Please provide a valid price greater than 0.";
    } elseif (empty($category) || !in_array($category, $categories)) {
        $error = "Please select a valid category.";
    } elseif (empty($description)) {
        $error = "Product description is required.";
    }

    // Handle image upload
    if (!$error && isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $new_image_url = uploadImage($_FILES['image']);
        if ($new_image_url) {
            $current_image_url = $new_image_url;
        } else {
            $error = $_SESSION['error_message'] ?? "Error uploading new image."; // Use message from uploadImage
            unset($_SESSION['error_message']); // Clear it from session
        }
    }

    if (!$error) {
        if (updateProduct($product['id'], $name, $description, $price, $category, $current_image_url)) {
            $_SESSION['success_message'] = "Product updated successfully!";
            header("Location: artisan-dashboard.php");
            exit();
        } else {
            $error = "Failed to update product. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JuaKali - Edit Product</title>
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
            <a class="navbar-brand" href="artisan-dashboard.php">JuaKali Artisan</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="artisan-dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="artisan-product-upload.php">Upload Product</a></li>
                    <li class="nav-item"><a class="nav-link" href="options.php">Profile Settings</a></li>
                    <li class="nav-item"><a class="nav-link" href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container form-container">
        <h2>Edit Product</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>

        <?php if ($product): ?>
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($product['name'] ?? ''); ?>" required maxlength="255">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="5" required><?php echo htmlspecialchars($product['description'] ?? ''); ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Price (KES)</label>
                    <input type="number" class="form-control" id="price" name="price" step="0.01" min="0.01" value="<?php echo htmlspecialchars($product['price'] ?? ''); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-control" id="category" name="category" required>
                        <option value="">Select a category</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo htmlspecialchars($cat); ?>" <?php echo (isset($product['category']) && $product['category'] == $cat) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Product Image (Leave blank to keep current)</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    <?php if ($product['image_url']): ?>
                        <img id="imagePreview" src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="Current Product Image">
                    <?php else: ?>
                        <img id="imagePreview" src="https://placehold.co/150x150/cccccc/333333?text=No+Image" alt="No Image" style="display: block;">
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-custom">Update Product</button>
            </form>
        <?php else: ?>
            <p class="text-center">Product details could not be loaded. Please return to the <a href="artisan-dashboard.php">dashboard</a>.</p>
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
                <?php if ($product['image_url']): ?>
                    imagePreview.src = "<?php echo htmlspecialchars($product['image_url']); ?>";
                <?php else: ?>
                    imagePreview.src = "https://placehold.co/150x150/cccccc/333333?text=No+Image";
                <?php endif; ?>
            }
        });
    </script>
</body>
</html>
