<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JuaKali - About Us</title>
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
            position: fixed;
            width: 100&;
        }
        .navbar-brand, .nav-link {
            color: #FFD700 !important;
            font-weight: bold;
        }
        .about-container {
            padding: 2rem;
            text-align: center;
        }
        .about-section {
            margin: 2rem 0;
        }
        .about-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }
        @media (max-width: 768px) {
            .about-container {
                padding: 1rem;
            }
            .navbar-brand, .nav-link {
                font-size: 0.9rem;
            }
            .about-image {
                height: 150px;
            }
        }
        footer { background-color: #FF5733; color: #FFD700; padding: 1rem; text-align: center; }
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
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    <!-- <li class="nav-item"><a class="nav-link" href="signup.html">Sign Up</a></li> -->
                </ul>
            </div>
        </div>
    </nav>
    <div class="about-container">
        <h2 style="font-family: 'Lora', serif; color: #FF5733;">About JuaKali</h2>
        <div class="about-section">
            <h4>Our Mission</h4>
            <p>We connect Kenyan artisans with urban consumers, promoting authentic crafts like Kiondo baskets and Maasai jewelry. Our mission is to empower local communities and celebrate Kenya’s creative economy, valued at KES 300 billion annually.</p>
        </div>
        <div class="about-section">
            <h4>Our Vision</h4>
            <p>To become the leading platform for Kenyan artisanal products, driving economic growth and cultural preservation across the region.</p>
        </div>
        <div class="about-section">
            <h4>Meet Our Team</h4>
            <div class="row">
                <div class="col-md-4">
                    <img src="https://via.placeholder.com/300x200?text=Team+Member" alt="Team Member" class="about-image">
                    <p>Collins Otieno - Founder</p>
                </div>
                <div class="col-md-4">
                    <img src="https://via.placeholder.com/300x200?text=Team+Member" alt="Team Member" class="about-image">
                    <p>Michael Otieno - Tech Lead</p>
                </div>
                <div class="col-md-4">
                    <img src="https://via.placeholder.com/300x200?text=Team+Member" alt="Team Member" class="about-image">
                    <p>Esther Wanjiku - Artisan Coordinator</p>
                </div>
            </div>
        </div>
        <div class="about-section">
            <h4>Artisan Impact</h4>
            <p>We’ve empowered over 1,000 artisans, creating 70-190 jobs and contributing to Kenya’s USD 50 million artisanal export market (2023).</p>
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