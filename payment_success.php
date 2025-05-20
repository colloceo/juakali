<?php
session_start();
$order_id = $_GET['order_id'] ?? 'Unknown';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="5;url=track.php">
    <title>Payment Success - JuaKali</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        body {
            font-family: "Roboto", sans-serif;
            background: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .success-box {
            background: #fff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            text-align: center;
            max-width: 500px;
        }
        .success-box i {
            color: #2e7d32;
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        .success-box h2 {
            color: #1a2634;
            margin-bottom: 1rem;
        }
        .success-box p {
            color: #333;
            line-height: 1.6;
        }
        .success-box a {
            color: #ff6f61;
            text-decoration: none;
        }
        .success-box a:hover {
            text-decoration: underline;
            color: #e65b50;
        }
    </style>
</head>
<body>
    <div class="success-box">
        <i class="fas fa-check-circle"></i>
        <h2>Payment Initiated Successfully!</h2>
        <p>Your order (#<?php echo htmlspecialchars($order_id); ?>) has been placed.<br>
        You will be redirected to your <a href="track.php">order tracking page</a> in 5 seconds.</p>
    </div>
</body>
</html>