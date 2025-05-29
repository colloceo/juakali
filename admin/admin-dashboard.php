<?php
session_start();
require_once '../functions.php'; // Ensure $pdo is correctly initialized in this file

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

// Handle product approval
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'approve' && isset($_POST['product_id'])) {
    approveProduct($_POST['product_id']);
    $_SESSION['success_message'] = "Product approved successfully!";
    header("Location: admin-dashboard.php?tab=products"); // Redirect back to products tab
    exit();
}

// Handle user deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'delete_user') {
    $user_id_to_delete = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
    if ($user_id_to_delete) {
        if (deleteUser($user_id_to_delete)) {
            $_SESSION['success_message'] = "User deleted successfully.";
        } else {
            $_SESSION['error_message'] = "Failed to delete user.";
        }
    } else {
        $_SESSION['error_message'] = "Invalid user ID.";
    }
    header("Location: admin-dashboard.php?tab=users"); // Redirect back to users tab
    exit();
}

// Handle user suspension
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'suspend_user') {
    $user_id_to_suspend = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
    if ($user_id_to_suspend) {
        if (suspendUser($user_id_to_suspend)) {
            $_SESSION['success_message'] = "User suspended successfully.";
        } else {
            $_SESSION['error_message'] = "Failed to suspend user.";
        }
    } else {
        $_SESSION['error_message'] = "Invalid user ID.";
    }
    header("Location: admin-dashboard.php?tab=users");
    exit();
}

// Handle user reactivation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'reactivate_user') {
    $user_id_to_reactivate = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
    if ($user_id_to_reactivate) {
        if (reactivateUser($user_id_to_reactivate)) {
            $_SESSION['success_message'] = "User reactivated successfully.";
        } else {
            $_SESSION['error_message'] = "Failed to reactivate user.";
        }
    } else {
        $_SESSION['error_message'] = "Invalid user ID.";
    }
    header("Location: admin-dashboard.php?tab=users");
    exit();
}

// Handle artisan creation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'create_artisan') {
    $user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $bio = filter_input(INPUT_POST, 'bio', FILTER_SANITIZE_STRING);
    $location = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_STRING);
    $image_url = null;

    // Check if user_id is valid and not already an artisan
    if ($user_id) {
        $existingArtisan = getArtisanByUserId($user_id);
        if ($existingArtisan) {
            $_SESSION['error_message'] = "User ID #{$user_id} is already registered as an artisan.";
        } else {
            if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
                $image_url = uploadImage($_FILES['image']);
            }

            if (registerArtisan($user_id, $name, $bio, $location, $image_url)) {
                $_SESSION['success_message'] = "Artisan '{$name}' created successfully!";
            } else {
                $_SESSION['error_message'] = "Failed to create artisan. Ensure all fields are valid and user exists.";
            }
        }
    } else {
        $_SESSION['error_message'] = "Invalid User ID provided for artisan creation.";
    }
    header("Location: admin-dashboard.php?tab=artisans");
    exit();
}


// Handle artisan deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'delete_artisan') {
    $artisan_id_to_delete = filter_input(INPUT_POST, 'artisan_id', FILTER_VALIDATE_INT);
    if ($artisan_id_to_delete) {
        if (deleteArtisan($artisan_id_to_delete)) {
            $_SESSION['success_message'] = "Artisan deleted successfully.";
        } else {
            $_SESSION['error_message'] = "Failed to delete artisan.";
        }
    } else {
        $_SESSION['error_message'] = "Invalid artisan ID.";
    }
    header("Location: admin-dashboard.php?tab=artisans"); // Redirect back to artisans tab
    exit();
}

// Handle artisan suspension
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'suspend_artisan') {
    $artisan_id_to_suspend = filter_input(INPUT_POST, 'artisan_id', FILTER_VALIDATE_INT);
    if ($artisan_id_to_suspend) {
        if (suspendArtisan($artisan_id_to_suspend)) {
            $_SESSION['success_message'] = "Artisan suspended successfully.";
        } else {
            $_SESSION['error_message'] = "Failed to suspend artisan.";
        }
    } else {
        $_SESSION['error_message'] = "Invalid artisan ID.";
    }
    header("Location: admin-dashboard.php?tab=artisans");
    exit();
}

// Handle artisan reactivation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'reactivate_artisan') {
    $artisan_id_to_reactivate = filter_input(INPUT_POST, 'artisan_id', FILTER_VALIDATE_INT);
    if ($artisan_id_to_reactivate) {
        if (reactivateArtisan($artisan_id_to_reactivate)) {
            $_SESSION['success_message'] = "Artisan reactivated successfully.";
        } else {
            $_SESSION['error_message'] = "Failed to reactivate artisan.";
        }
    } else {
        $_SESSION['error_message'] = "Invalid artisan ID.";
    }
    header("Location: admin-dashboard.php?tab=artisans");
    exit();
}


// Fetch data for KPIs
$totalArtisans = getTotalArtisansCount();
$totalProducts = getTotalProductsCount();
$approvedProducts = getApprovedProductsCount();
$pendingProducts = getPendingProductsCount();
$totalSalesVolume = getTotalSalesVolume();
$averageOrderValue = getAverageOrderValue();
$totalUsers = getTotalUsersCount();
$newUsersLast7Days = getNewUsersCountLastXDays(7);
$newArtisansLast7Days = getNewArtisansCountLastXDays(7);
$recentActivities = getRecentActivities(10); // Fetch last 10 activities

// Fetch pending products (for Products tab)
$products = $pdo->query("SELECT p.*, a.name AS artisan_name
                         FROM products p
                         JOIN artisans a ON p.artisan_id = a.id
                         WHERE p.status = 'Pending'")
                ->fetchAll(PDO::FETCH_ASSOC);

// Fetch all orders with payment status (for Orders tab)
$orders = $pdo->query("SELECT o.*, u.name AS customer
                       FROM orders o
                       JOIN users u ON o.user_id = u.id")
              ->fetchAll(PDO::FETCH_ASSOC);

// Fetch all users (for Users tab)
$users = getAllUsers();

// Fetch all artisans (for Artisans tab)
// We need to fetch artisans along with their linked user email for better identification
$artisans = $pdo->query("SELECT a.*, u.email AS user_email
                         FROM artisans a
                         JOIN users u ON a.user_id = u.id
                         ORDER BY a.created_at DESC")
                ->fetchAll(PDO::FETCH_ASSOC);


// Handle success/error messages
$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : null;
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : null;
unset($_SESSION['success_message']); // Clear message after displaying
unset($_SESSION['error_message']); // Clear message after displaying

// Determine active tab
$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'overview'; // Default to overview tab
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JuaKali - Admin Dashboard</title>
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
        .dashboard-table th, .dashboard-table td { border: 1px solid #ddd; padding: 10px; text-align: left; }
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
        .kpi-cards {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .kpi-card {
            background-color: #fefefe;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 1.5rem;
            flex: 1 1 calc(33% - 1rem); /* 3 cards per row, responsive */
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            text-align: center;
        }
        .kpi-card h6 {
            color: #FF5733;
            font-family: 'Ubuntu', sans-serif;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        .kpi-card p {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 0;
        }
        .kpi-card small {
            color: #666;
        }
        @media (max-width: 992px) {
            .kpi-card {
                flex: 1 1 calc(50% - 0.5rem); /* 2 cards per row on medium screens */
            }
        }
        @media (max-width: 576px) {
            .kpi-card {
                flex: 1 1 100%; /* 1 card per row on small screens */
            }
        }
        .activity-list {
            list-style: none;
            padding: 0;
        }
        .activity-list li {
            background-color: #fefefe;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            padding: 10px 15px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .activity-list li .activity-type {
            font-weight: bold;
            color: #FFA500;
        }
        .activity-list li .activity-detail {
            flex-grow: 1;
            margin-left: 15px;
        }
        .activity-list li .activity-time {
            font-size: 0.85rem;
            color: #888;
        }
        .create-form-section {
            background-color: #f9f9f9;
            padding: 1.5rem;
            border-radius: 8px;
            margin-top: 1.5rem;
            border: 1px solid #eee;
        }
        .create-form-section h5 {
            color: #FF5733;
            margin-bottom: 1rem;
        }
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
                    <li class="nav-item"><a class="nav-link" href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container dashboard-container">
        <h2>Admin Dashboard</h2>

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

        <ul class="nav nav-tabs" id="adminDashboardTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link <?php echo ($active_tab == 'overview' ? 'active' : ''); ?>"
                        id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview"
                        type="button" role="tab" aria-controls="overview" aria-selected="<?php echo ($active_tab == 'overview' ? 'true' : 'false'); ?>">
                    Overview
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link <?php echo ($active_tab == 'products' ? 'active' : ''); ?>"
                        id="products-tab" data-bs-toggle="tab" data-bs-target="#products"
                        type="button" role="tab" aria-controls="products" aria-selected="<?php echo ($active_tab == 'products' ? 'true' : 'false'); ?>">
                    Products
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
                <button class="nav-link <?php echo ($active_tab == 'users' ? 'active' : ''); ?>"
                        id="users-tab" data-bs-toggle="tab" data-bs-target="#users"
                        type="button" role="tab" aria-controls="users" aria-selected="<?php echo ($active_tab == 'users' ? 'true' : 'false'); ?>">
                    Users
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link <?php echo ($active_tab == 'artisans' ? 'active' : ''); ?>"
                        id="artisans-tab" data-bs-toggle="tab" data-bs-target="#artisans"
                        type="button" role="tab" aria-controls="artisans" aria-selected="<?php echo ($active_tab == 'artisans' ? 'true' : 'false'); ?>">
                    Artisans
                </button>
            </li>
        </ul>

        <div class="tab-content" id="adminDashboardTabContent">
            <div class="tab-pane fade <?php echo ($active_tab == 'overview' ? 'show active' : ''); ?>"
                 id="overview" role="tabpanel" aria-labelledby="overview-tab">
                <h5 class="mt-3">Key Performance Indicators</h5>
                <div class="kpi-cards">
                    <div class="kpi-card">
                        <h6>Total Artisans</h6>
                        <p><?php echo $totalArtisans; ?></p>
                        <small>+<?php echo $newArtisansLast7Days; ?> in last 7 days</small>
                    </div>
                    <div class="kpi-card">
                        <h6>Total Products</h6>
                        <p><?php echo $totalProducts; ?></p>
                        <small><?php echo $approvedProducts; ?> Approved, <?php echo $pendingProducts; ?> Pending</small>
                    </div>
                    <div class="kpi-card">
                        <h6>Total Sales Volume</h6>
                        <p>KES <?php echo number_format($totalSalesVolume, 2); ?></p>
                        <small>Average Order Value: KES <?php echo number_format($averageOrderValue, 2); ?></small>
                    </div>
                    <div class="kpi-card">
                        <h6>Total Customers</h6>
                        <p><?php echo $totalUsers; ?></p>
                        <small>+<?php echo $newUsersLast7Days; ?> in last 7 days</small>
                    </div>
                    </div>

                <h5 class="mt-5">Recent Activity</h5>
                <?php if (!empty($recentActivities)): ?>
                    <ul class="activity-list">
                        <?php foreach ($recentActivities as $activity): ?>
                            <li>
                                <span class="activity-type">
                                    <?php
                                    if ($activity['type'] == 'product_upload') echo 'New Product:';
                                    elseif ($activity['type'] == 'new_order') echo 'New Order:';
                                    elseif ($activity['type'] == 'user_registration') echo 'New User:';
                                    ?>
                                </span>
                                <span class="activity-detail">
                                    <?php
                                    if ($activity['type'] == 'product_upload') echo htmlspecialchars($activity['name']);
                                    elseif ($activity['type'] == 'new_order') echo 'Order #' . htmlspecialchars($activity['id']);
                                    elseif ($activity['type'] == 'user_registration') echo htmlspecialchars($activity['name']);
                                    ?>
                                </span>
                                <span class="activity-time"><?php echo date('M d, Y H:i', strtotime($activity['created_at'])); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="no-data">No recent activity to display.</p>
                <?php endif; ?>
            </div>

            <div class="tab-pane fade <?php echo ($active_tab == 'products' ? 'show active' : ''); ?>"
                 id="products" role="tabpanel" aria-labelledby="products-tab">
                <h5 class="mt-3">Pending Products for Approval</h5>
                <?php if (!empty($products)): ?>
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Artisan</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                                    <td><?php echo htmlspecialchars($product['artisan_name']); ?></td>
                                    <td>KES <?php echo number_format($product['price'], 2); ?></td>
                                    <td><?php echo htmlspecialchars($product['category']); ?></td>
                                    <td>
                                        <form method="POST" style="display:inline;">
                                            <input type="hidden" name="action" value="approve">
                                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                            <button type="submit" class="btn btn-custom btn-sm">Approve</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="no-data">No pending products for approval.</p>
                <?php endif; ?>
            </div>

            <div class="tab-pane fade <?php echo ($active_tab == 'orders' ? 'show active' : ''); ?>"
                 id="orders" role="tabpanel" aria-labelledby="orders-tab">
                <h5 class="mt-3">All Orders</h5>
                <?php if (!empty($orders)): ?>
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Order Date</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Payment Status</th>
                                <th>Delivery Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td>#<?php echo $order['id']; ?></td>
                                    <td><?php echo date('Y-m-d H:i:s', strtotime($order['created_at'])); ?></td>
                                    <td><?php echo htmlspecialchars($order['customer']); ?></td>
                                    <td>KES <?php echo number_format($order['total'], 2); ?></td>
                                    <td><?php echo htmlspecialchars($order['payment_status'] ?? 'N/A'); ?></td>
                                    <td><?php echo htmlspecialchars($order['delivery_option']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="no-data">No orders found.</p>
                <?php endif; ?>
            </div>

            <div class="tab-pane fade <?php echo ($active_tab == 'users' ? 'show active' : ''); ?>"
                 id="users" role="tabpanel" aria-labelledby="users-tab">
                <h5 class="mt-3">Manage Users</h5>
                <?php if (!empty($users)): ?>
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Registered Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                                    <td><?php echo htmlspecialchars(ucfirst($user['status'] ?? 'unknown')); ?></td> <td><?php echo date('Y-m-d H:i:s', strtotime($user['created_at'])); ?></td>
                                    <td>
                                        <a href="admin-user-edit.php?id=<?php echo $user['id']; ?>" class="btn btn-custom btn-sm">Edit</a>
                                        <form method="POST" style="display:inline-block; margin-left: 5px;">
                                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                            <?php if (($user['status'] ?? 'active') == 'active'): ?> <button type="submit" name="action" value="suspend_user" class="btn btn-warning btn-sm" onclick="return confirm('Are you sure you want to suspend this user? They will not be able to log in.')">Suspend</button>
                                            <?php else: ?>
                                                <button type="submit" name="action" value="reactivate_user" class="btn btn-success btn-sm" onclick="return confirm('Are you sure you want to reactivate this user?')">Reactivate</button>
                                            <?php endif; ?>
                                            <button type="submit" name="action" value="delete_user" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="no-data">No users found.</p>
                <?php endif; ?>
            </div>

            <div class="tab-pane fade <?php echo ($active_tab == 'artisans' ? 'show active' : ''); ?>"
                 id="artisans" role="tabpanel" aria-labelledby="artisans-tab">
                <h5 class="mt-3">Manage Artisans</h5>
                <div class="create-form-section mb-4">
                    <h5>Create New Artisan</h5>
                    <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="create_artisan">
                        <div class="mb-3">
                            <label for="create_user_id" class="form-label">Linked User ID</label>
                            <input type="number" class="form-control" id="create_user_id" name="user_id" required placeholder="User ID from 'Users' tab">
                        </div>
                        <div class="mb-3">
                            <label for="create_name" class="form-label">Artisan Name</label>
                            <input type="text" class="form-control" id="create_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="create_bio" class="form-label">Bio</label>
                            <textarea class="form-control" id="create_bio" name="bio" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="create_location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="create_location" name="location">
                        </div>
                        <div class="mb-3">
                            <label for="create_image" class="form-label">Profile Image</label>
                            <input type="file" class="form-control" id="create_image" name="image" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-custom">Add Artisan</button>
                    </form>
                </div>

                <?php if (!empty($artisans)): ?>
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Linked User Email</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Registered Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($artisans as $artisan): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($artisan['id']); ?></td>
                                    <td><?php echo htmlspecialchars($artisan['name']); ?></td>
                                    <td><?php echo htmlspecialchars($artisan['user_email'] ?? 'N/A'); ?></td>
                                    <td><?php echo htmlspecialchars($artisan['location'] ?? 'N/A'); ?></td>
                                    <td><?php echo htmlspecialchars(ucfirst($artisan['status'] ?? 'unknown')); ?></td> <td><?php echo date('Y-m-d H:i:s', strtotime($artisan['created_at'])); ?></td>
                                    <td>
                                        <a href="admin-artisan-edit.php?id=<?php echo $artisan['id']; ?>" class="btn btn-custom btn-sm">Edit</a>
                                        <form method="POST" style="display:inline-block; margin-left: 5px;">
                                            <input type="hidden" name="artisan_id" value="<?php echo $artisan['id']; ?>">
                                            <?php if (($artisan['status'] ?? 'active') == 'active'): ?> <button type="submit" name="action" value="suspend_artisan" class="btn btn-warning btn-sm" onclick="return confirm('Are you sure you want to suspend this artisan? They will not be able to log in and their products may be hidden.')">Suspend</button>
                                            <?php else: ?>
                                                <button type="submit" name="action" value="reactivate_artisan" class="btn btn-success btn-sm" onclick="return confirm('Are you sure you want to reactivate this artisan?')">Reactivate</button>
                                            <?php endif; ?>
                                            <button type="submit" name="action" value="delete_artisan" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this artisan? This will also remove their products and reviews.')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="no-data">No artisans found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <footer>
        <div class="container">
            <p>© <?php echo date("Y"); ?> JuaKali. All rights reserved.</p>
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
