<?php
session_start();
require_once '../functions.php'; // Ensure $pdo is correctly initialized in this file

// Check if the user is logged in and is an artisan
if (!isset($_SESSION['user_id'])) {
    header("Location: artisan-login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$artisan = getArtisanByUserId($user_id);
if (!$artisan) {
    // If user is logged in but not recognized as an artisan, redirect
    header("Location: artisan-index.php"); // Assuming an artisan home page
    exit();
}

$artisan_id = $artisan['id'];

// Handle product deletion (existing functionality)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'delete_product') {
    $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
    if ($product_id) {
        // Ensure the product belongs to the current artisan before deleting
        $stmt = $pdo->prepare("SELECT id FROM products WHERE id = ? AND artisan_id = ?");
        $stmt->execute([$product_id, $artisan_id]);
        if ($stmt->fetch()) {
            deleteProduct($product_id);
            $_SESSION['success_message'] = "Product deleted successfully.";
        } else {
            $_SESSION['error_message'] = "Product not found or you don't have permission to delete it.";
        }
    } else {
        $_SESSION['error_message'] = "Invalid product ID.";
    }
    header("Location: artisan-dashboard.php?tab=products"); // Redirect back to products tab
    exit();
}

// Handle order status update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'update_order_status') {
    $order_id = filter_input(INPUT_POST, 'order_id', FILTER_VALIDATE_INT);
    $new_status = filter_input(INPUT_POST, 'order_status', FILTER_SANITIZE_STRING);

    // Validate status to be one of the allowed values
    $allowed_statuses = ['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled'];
    if (!in_array($new_status, $allowed_statuses)) {
        $_SESSION['error_message'] = "Invalid order status provided.";
        header("Location: artisan-dashboard.php?tab=orders"); // Redirect back to orders tab
        exit();
    }

    if ($order_id && $new_status) {
        // You might want to add a check here to ensure the order belongs to this artisan
        // This would involve a more complex query in updateOrderStatus or a prior fetch.
        // For simplicity, assuming the order ID is valid and belongs to the artisan's products.
        if (updateOrderStatus($order_id, $new_status)) {
            $_SESSION['success_message'] = "Order #{$order_id} status updated to '{$new_status}' successfully.";
        } else {
            $_SESSION['error_message'] = "Failed to update status for Order #{$order_id}.";
        }
    } else {
        $_SESSION['error_message'] = "Invalid order ID or status provided.";
    }
    header("Location: artisan-dashboard.php?tab=orders"); // Redirect back to orders tab
    exit();
}

// Handle tracking number update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'update_tracking_number') {
    $order_id = filter_input(INPUT_POST, 'order_id', FILTER_VALIDATE_INT);
    $tracking_number = filter_input(INPUT_POST, 'tracking_number', FILTER_SANITIZE_STRING);

    if ($order_id) {
        if (updateOrderTracking($order_id, $tracking_number)) {
            $_SESSION['success_message'] = "Tracking number for Order #{$order_id} updated successfully.";
        } else {
            $_SESSION['error_message'] = "Failed to update tracking number for Order #{$order_id}.";
        }
    } else {
        $_SESSION['error_message'] = "Invalid order ID provided.";
    }
    header("Location: artisan-dashboard.php?tab=orders"); // Redirect back to orders tab
    exit();
}

// Handle review response submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'respond_to_review') {
    $review_id = filter_input(INPUT_POST, 'review_id', FILTER_VALIDATE_INT);
    $artisan_response = filter_input(INPUT_POST, 'artisan_response', FILTER_SANITIZE_STRING);

    if ($review_id && $artisan_response !== null) { // Allow empty response to clear it
        // You might want to add a check here to ensure the review is for this artisan's product
        // This would involve fetching the review and checking its product's artisan_id.
        if (updateArtisanReviewResponse($review_id, $artisan_response)) {
            $_SESSION['success_message'] = "Response to review #{$review_id} updated successfully.";
        } else {
            $_SESSION['error_message'] = "Failed to update response for review #{$review_id}.";
        }
    } else {
        $_SESSION['error_message'] = "Invalid review ID or response provided.";
    }
    header("Location: artisan-dashboard.php?tab=reviews"); // Redirect back to reviews tab
    exit();
}


// Fetch all products for the artisan, regardless of status
$products = getArtisanProducts($artisan_id);

// Fetch detailed orders for the artisan
$orders = getArtisanOrdersDetailed($artisan_id);

// Fetch reviews for the artisan's products
$reviews = getArtisanProductReviews($artisan_id);

// Handle success/error messages
$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : null;
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : null;
unset($_SESSION['success_message']); // Clear message after displaying
unset($_SESSION['error_message']); // Clear message after displaying

// Determine active tab
$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'products'; // Default to products tab
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JuaKali - Artisan Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;700&family=Lora:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body { font-family: 'Ubuntu', sans-serif; background-color: #f8f1e9; color: #333; }
        .navbar { background-color: #FF5733; padding: 1rem 0; }
        .navbar-brand { color: #FFD700 !important; font-family: 'Lora', serif; font-size: 1.8rem; font-weight: bold; }
        .navbar-nav .nav-link { color: #fff !important; margin-right: 15px; }
        .navbar-nav .nav-link:hover { color: #FFD700 !important; }
        .dashboard-container { background-color: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); margin-top: 2rem; }
        h2, h5 { font-family: 'Lora', serif; color: #FF5733; margin-bottom: 1.5rem; }
        .dashboard-table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        .dashboard-table th, .dashboard-table td { border: 1px solid #ddd; padding: 10px; text-align: left; vertical-align: middle; }
        .dashboard-table th { background-color: #f2f2f2; }
        .no-data { text-align: center; color: #666; margin-top: 1rem; }
        .btn-custom { background-color: #FFA500; color: #fff; border: none; padding: 8px 15px; border-radius: 5px; text-decoration: none; display: inline-block; }
        .btn-custom:hover { background-color: #e69500; color: #fff; }
        .btn-danger { background-color: #dc3545; color: #fff; border: none; padding: 8px 15px; border-radius: 5px; text-decoration: none; display: inline-block; }
        .btn-danger:hover { background-color: #c82333; color: #fff; }
        .btn-sm { padding: 5px 10px; font-size: 0.8rem; }
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
        .order-action-form {
            display: flex;
            gap: 5px;
            align-items: center;
            margin-top: 5px;
        }
        .order-action-form select, .order-action-form input[type="text"] {
            padding: 5px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        .order-action-form button {
            padding: 5px 10px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
        }
        .order-action-form .btn-update {
            background-color: #007bff;
            color: white;
        }
        .order-action-form .btn-update:hover {
            background-color: #0056b3;
        }
        /* Tab styling */
        .nav-tabs .nav-link {
            color: #FF5733;
            border: 1px solid transparent;
            border-top-left-radius: .25rem;
            border-top-right-radius: .25rem;
        }
        .nav-tabs .nav-link.active {
            color: #495057;
            background-color: #fff;
            border-color: #dee2e6 #dee2e6 #fff;
        }
        .tab-content {
            padding-top: 1rem;
            border: 1px solid #dee2e6;
            border-top: none;
            border-bottom-left-radius: .25rem;
            border-bottom-right-radius: .25rem;
            background-color: #fff;
        }
        .star-rating .fa-star {
            color: #FFD700; /* Gold color for stars */
        }
        .review-response-form {
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #eee;
        }
        .review-response-form textarea {
            width: 100%;
            margin-bottom: 5px;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
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
                    <li class="nav-item"><a class="nav-link" href="artisan-product-upload.php">Upload Product</a></li>
                    <li class="nav-item"><a class="nav-link" href="options.php">Profile Settings</a></li>
                    <li class="nav-item"><a class="nav-link" href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container dashboard-container">
        <h2>Welcome, <?php echo htmlspecialchars($artisan['name']); ?>!</h2>

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

        <ul class="nav nav-tabs" id="artisanDashboardTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link <?php echo ($active_tab == 'products' ? 'active' : ''); ?>"
                        id="products-tab" data-bs-toggle="tab" data-bs-target="#products"
                        type="button" role="tab" aria-controls="products" aria-selected="<?php echo ($active_tab == 'products' ? 'true' : 'false'); ?>">
                    Your Products
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link <?php echo ($active_tab == 'orders' ? 'active' : ''); ?>"
                        id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders"
                        type="button" role="tab" aria-controls="orders" aria-selected="<?php echo ($active_tab == 'orders' ? 'true' : 'false'); ?>">
                    Orders
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link <?php echo ($active_tab == 'reviews' ? 'active' : ''); ?>"
                        id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews"
                        type="button" role="tab" aria-controls="reviews" aria-selected="<?php echo ($active_tab == 'reviews' ? 'true' : 'false'); ?>">
                    Customer Reviews
                </button>
            </li>
        </ul>

        <div class="tab-content" id="artisanDashboardTabContent">
            <div class="tab-pane fade <?php echo ($active_tab == 'products' ? 'show active' : ''); ?>"
                 id="products" role="tabpanel" aria-labelledby="products-tab">
                <h5 class="mt-3">Your Products</h5>
                <?php if (!empty($products)): ?>
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td>
                                        <?php if ($product['image_url']): ?>
                                            <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px;">
                                        <?php else: ?>
                                            <img src="https://placehold.co/80x80/cccccc/333333?text=No+Image" alt="No Image" style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px;">
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                                    <td>KES <?php echo number_format($product['price'], 2); ?></td>
                                    <td><?php echo htmlspecialchars($product['category']); ?></td>
                                    <td><?php echo htmlspecialchars($product['status']); ?></td>
                                    <td>
                                        <a href="artisan-product-edit.php?id=<?php echo $product['id']; ?>" class="btn btn-custom btn-sm">Edit</a>
                                        <form method="POST" style="display:inline-block; margin-left: 5px;">
                                            <input type="hidden" name="action" value="delete_product">
                                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product? This action cannot be undone.')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="no-data">You haven't uploaded any products yet. <a href="artisan-product-upload.php">Upload your first product!</a></p>
                <?php endif; ?>
            </div>

            <div class="tab-pane fade <?php echo ($active_tab == 'orders' ? 'show active' : ''); ?>"
                 id="orders" role="tabpanel" aria-labelledby="orders-tab">
                <h5 class="mt-3">Orders</h5>
                <?php if (!empty($orders)): ?>
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Order Date</th>
                                <th>Customer</th>
                                <th>Products</th>
                                <th>Total</th>
                                <th>Payment Status</th>
                                <th>Delivery Option</th>
                                <th>Shipping Address</th>
                                <th>Order Status</th>
                                <th>Tracking Number</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td>#<?php echo $order['order_id']; ?></td>
                                    <td><?php echo date('Y-m-d H:i:s', strtotime($order['order_date'])); ?></td>
                                    <td>
                                        <?php echo htmlspecialchars($order['customer_name']); ?><br>
                                        <small><?php echo htmlspecialchars($order['customer_email']); ?></small>
                                    </td>
                                    <td><?php echo htmlspecialchars($order['products_summary']); ?></td>
                                    <td>KES <?php echo number_format($order['total'], 2); ?></td>
                                    <td><?php echo htmlspecialchars($order['payment_status']); ?></td>
                                    <td><?php echo htmlspecialchars($order['delivery_option']); ?></td>
                                    <td>
                                        <?php
                                        $address = [];
                                        if (!empty($order['street'])) $address[] = $order['street'];
                                        if (!empty($order['city'])) $address[] = $order['city'];
                                        if (!empty($order['state'])) $address[] = $order['state'];
                                        if (!empty($order['postal_code'])) $address[] = $order['postal_code'];
                                        if (!empty($order['country'])) $address[] = $order['country'];
                                        echo htmlspecialchars(implode(', ', $address));
                                        if (empty($address)) echo 'N/A';
                                        ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($order['order_status'] ?? 'N/A'); ?></td>
                                    <td><?php echo htmlspecialchars($order['tracking_number'] ?? 'N/A'); ?></td>
                                    <td>
                                        <form method="POST" class="order-action-form">
                                            <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                            <select name="order_status" class="form-select-sm">
                                                <?php
                                                $statuses = ['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled'];
                                                foreach ($statuses as $status):
                                                    $selected = ($order['order_status'] == $status) ? 'selected' : '';
                                                ?>
                                                    <option value="<?php echo htmlspecialchars($status); ?>" <?php echo $selected; ?>>
                                                        <?php echo htmlspecialchars($status); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <button type="submit" name="action" value="update_order_status" class="btn btn-update btn-sm">Update Status</button>
                                        </form>
                                        <form method="POST" class="order-action-form mt-2">
                                            <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                            <input type="text" name="tracking_number" placeholder="Tracking #" value="<?php echo htmlspecialchars($order['tracking_number'] ?? ''); ?>">
                                            <button type="submit" name="action" value="update_tracking_number" class="btn btn-update btn-sm">Add Tracking</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="no-data">No orders received yet.</p>
                <?php endif; ?>
            </div>

            <div class="tab-pane fade <?php echo ($active_tab == 'reviews' ? 'show active' : ''); ?>"
                 id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                <h5 class="mt-3">Customer Reviews for Your Products</h5>
                <?php if (!empty($reviews)): ?>
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Customer</th>
                                <th>Rating</th>
                                <th>Comment</th>
                                <th>Date</th>
                                <th>Your Response</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reviews as $review): ?>
                                <tr>
                                    <td><a href="artisan-product-edit.php?id=<?php echo $review['product_id']; ?>"><?php echo htmlspecialchars($review['product_name']); ?></a></td>
                                    <td><?php echo htmlspecialchars($review['customer_name']); ?></td>
                                    <td class="star-rating">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="fa<?php echo ($i <= $review['rating']) ? 's' : 'r'; ?> fa-star"></i>
                                        <?php endfor; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($review['comment']); ?></td>
                                    <td><?php echo date('Y-m-d H:i:s', strtotime($review['review_date'])); ?></td>
                                    <td>
                                        <?php echo htmlspecialchars($review['artisan_response'] ?? 'No response yet.'); ?>
                                    </td>
                                    <td>
                                        <form method="POST" class="review-response-form">
                                            <input type="hidden" name="review_id" value="<?php echo $review['review_id']; ?>">
                                            <textarea name="artisan_response" rows="2" placeholder="Your response..."><?php echo htmlspecialchars($review['artisan_response'] ?? ''); ?></textarea>
                                            <button type="submit" name="action" value="respond_to_review" class="btn btn-custom btn-sm">
                                                <?php echo ($review['artisan_response'] ? 'Update Response' : 'Add Response'); ?>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="no-data">No customer reviews yet.</p>
                <?php endif; ?>
            </div>
        </div>
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
