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
                    <li class="nav-item"><a class="nav-link" href="manage-artisans.php">Manage Artisans</a></li>
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
