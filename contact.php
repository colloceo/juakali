<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JuaKali - Contact Us</title>
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
            width: 100%;
        }
        .navbar-brand, .nav-link {
            color: #FFD700 !important;
            font-weight: bold;
        }
        .contact-container {
            padding: 2rem;
            max-width: 800px;
            margin: 0 auto;
        }
        .map-placeholder {
            width: 100%;
            height: 300px;
            background: url('https://via.placeholder.com/800x300?text=Map+Placeholder') no-repeat center/cover;
            margin: 1rem 0;
        }
        .social-links a {
            color: #FF5733;
            margin: 0 0.5rem;
            font-size: 1.2rem;
        }
        .btn-custom {
            background-color: #FFA500;
            color: #fff;
            border: none;
            padding: 0.75rem;
            font-size: 1rem;
            min-height: 48px;
        }
        @media (max-width: 768px) {
            .contact-container {
                padding: 1rem;
            }
            .navbar-brand, .nav-link {
                font-size: 0.9rem;
            }
            .map-placeholder {
                height: 200px;
            }
            .btn-custom {
                font-size: 0.9rem;
                padding: 0.5rem;
            }
        }
        footer { background-color: #FF5733; color: #FFD700; padding: 1rem; text-align: center; }
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
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    <!-- <li class="nav-item"><a class="nav-link" href="signup.html">Sign Up</a></li> -->
                </ul>
            </div>
        </div>
    </nav>
    <div class="contact-container">
        <h2 class="text-center my-4" style="font-family: 'Lora', serif; color: #FF5733;">Contact Us</h2>
        <div class="row">
            <div class="col-md-6">
                <h5>Get in Touch</h5>
                <p>Email: support@juakali.co.ke</p>
                <p>Phone: +254 712 345 678</p>
                <p>Address: Westlands, Nairobi, Kenya</p>
                <div class="social-links">
                    <a href="#">Facebook</a>
                    <a href="#">Twitter</a>
                    <a href="#">Instagram</a>
                </div>
            </div>
            <div class="col-md-6">
                <form>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-custom w-100">Send Message</button>
                </form>
            </div>
        </div>
        <div class="map-placeholder"></div>
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
            $('form').submit(function(e) {
                e.preventDefault();
                alert('Contact form functionality to be implemented with PHP backend');
            });
        });
    </script>
</body>
</html>