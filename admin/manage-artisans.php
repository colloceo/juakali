<?php
session_start();
require_once '../functions.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'create') {
            $name = $_POST['name'];
            $bio = $_POST['bio'];
            $location = $_POST['location'];
            $image_url = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
                $image_url = uploadImage($_FILES['image']);
            }
            createArtisan($name, $bio, $location, $image_url);
        } elseif ($_POST['action'] == 'update') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $bio = $_POST['bio'];
            $location = $_POST['location'];
            $image_url = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
                $image_url = uploadImage($_FILES['image']);
            } elseif (isset($_POST['current_image'])) {
                $image_url = $_POST['current_image'];
            }
            updateArtisan($id, $name, $bio, $location, $image_url);
        } elseif ($_POST['action'] == 'delete') {
            $id = $_POST['id'];
            deleteArtisan($id);
        }
        header("Location: manage-artisans.php");
        exit();
    }
}

$artisans = getAllArtisans();
$edit_artisan = null;
if (isset($_GET['edit'])) {
    $edit_artisan = getArtisanById($_GET['edit']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JuaKali - Manage Artisans</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;700&family=Lora:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Ubuntu', sans-serif; background-color: #f8f1e9; }
        .navbar { background-color: #FF5733; padding: 1rem; }
        .navbar-brand, .nav-link { color: #FFD700 !important; font-weight: bold; }
        .dashboard-container { padding: 2rem; }
        .dashboard-table { width: 100%; border-collapse: collapse; margin: 1rem 0; }
        .dashboard-table th, .dashboard-table td { border: 1px solid #ddd; padding: 0.5rem; text-align: center; }
        .btn-custom { background-color: #FFA500; color: #fff; border: none; padding: 0.75rem; font-size: 1rem; min-height: 48px; }
        .btn-danger { padding: 0.75rem; font-size: 1rem; min-height: 48px; }
        @media (max-width: 768px) { .dashboard-container { padding: 1rem; } .dashboard-table th, .dashboard-table td { font-size: 0.8rem; } .navbar-brand, .nav-link { font-size: 0.9rem; } .btn-custom, .btn-danger { font-size: 0.9rem; padding: 0.5rem; } }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="index-after-login.html">JuaKali</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="admin-dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="manage-artisans.php">Manage Artisans</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="dashboard-container">
        <h2 class="text-center my-4" style="font-family: 'Lora', serif; color: #FF5733;">Manage Artisans</h2>
        
        <!-- Create/Update Form -->
        <h5><?php echo $edit_artisan ? 'Edit Artisan' : 'Add New Artisan'; ?></h5>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="<?php echo $edit_artisan ? 'update' : 'create'; ?>">
            <?php if ($edit_artisan): ?>
                <input type="hidden" name="id" value="<?php echo $edit_artisan['id']; ?>">
                <input type="hidden" name="current_image" value="<?php echo $edit_artisan['image_url'] ?? ''; ?>">
            <?php endif; ?>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $edit_artisan['name'] ?? ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="bio" class="form-label">Bio</label>
                <textarea class="form-control" id="bio" name="bio" rows="3"><?php echo $edit_artisan['bio'] ?? ''; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" class="form-control" id="location" name="location" value="<?php echo $edit_artisan['location'] ?? ''; ?>">
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Profile Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                <?php if ($edit_artisan && $edit_artisan['image_url']): ?>
                    <img src="<?php echo $edit_artisan['image_url']; ?>" alt="Current Image" style="max-width: 200px; margin-top: 0.5rem;">
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-custom"><?php echo $edit_artisan ? 'Update Artisan' : 'Add Artisan'; ?></button>
        </form>

        <!-- Artisan List -->
        <h5 class="mt-5">Artisan List</h5>
        <table class="dashboard-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($artisans as $artisan): ?>
                    <tr>
                        <td><?php echo $artisan['name']; ?></td>
                        <td><?php echo $artisan['location'] ?? 'Not specified'; ?></td>
                        <td>
                            <a href="manage-artisans.php?edit=<?php echo $artisan['id']; ?>" class="btn btn-custom btn-sm">Edit</a>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $artisan['id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>