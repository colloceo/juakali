<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JuaKali - Wishlist</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;700&family=Lora:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Ubuntu', sans-serif;
            background-color: #f8f1e9;
        }
        .navbar {
            background-color: #FF5733;
            padding: 1rem;
        }
        .navbar-brand, .nav-link {
            color: #FFD700 !important;
            font-weight: bold;
        }
        .wishlist-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            padding: 1rem;
        }
        .wishlist-item {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 1rem;
            text-align: center;
        }
        .wishlist-item img {
            width: 100%;
            height: 200px;
            object-fit: contain;
        }
        .btn-custom {
            background-color: #FFA500;
            color: #fff;
            border: none;
        }
        footer { background-color: #FF5733; color: #FFD700; padding: 1rem; text-align: center; }
        @media (max-width: 768px) {
            .wishlist-grid {
                grid-template-columns: 1fr;
            }
            .navbar-brand, .nav-link {
                font-size: 0.9rem;
            }
        }
        
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.html">JuaKali</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="categoryDropdown" data-bs-toggle="dropdown">Products</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Decor</a></li>
                            <li><a class="dropdown-item" href="#">Textiles</a></li>
                            <li><a class="dropdown-item" href="#">Food</a></li>
                            <li><a class="dropdown-item" href="#">Personal Care</a></li>
                        </ul>
                    <li class="nav-item"><a class="nav-link" href="#artisans">Artisans</a></li>
                    <li class="nav-item"><a class="nav-link" href="cart.php">Cart</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" data-bs-toggle="dropdown">Account</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="account.php">My Account</a></li>
                            <li><a class="dropdown-item" href="wishlist.php">Wishlist</a></li>
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <h2 class="text-center my-4" style="font-family: 'Lora', serif; color: #FF5733;">Your Wishlist</h2>
        <div class="wishlist-grid">
            <div class="wishlist-item">
                <img src="https://via.placeholder.com/250x200?text=Kiondo+Basket" alt="Kiondo Basket">
                <h5>Kiondo Basket</h5>
                <p>KES 1,500</p>
                <button class="btn btn-custom">Add to Cart</button>
            </div>
            <div class="wishlist-item">
                <img src="https://via.placeholder.com/250x200?text=Maasai+Jewelry" alt="Maasai Jewelry">
                <h5>Maasai Necklace</h5>
                <p>KES 2,000</p>
                <button class="btn btn-custom">Add to Cart</button>
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
    <script>
        $(document).ready(function() {
            $('.btn-custom').click(function() {
                alert('Add to Cart functionality to be implemented with PHP backend');
            });
        });
    </script>
</body>
</html>