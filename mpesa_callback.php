<?php
require_once 'config.php';
require_once 'functions.php';

// Load environment variables
require_once 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Africa's Talking credentials
$at_api_key = $_ENV['AT_API_KEY'] ?? '';
$at_username = $_ENV['AT_USERNAME'] ?? '';

// Mailtrap SMTP credentials
$smtp_host = $_ENV['SMTP_HOST'] ?? '';
$smtp_port = $_ENV['SMTP_PORT'] ?? '';
$smtp_username = $_ENV['SMTP_USERNAME'] ?? '';
$smtp_password = $_ENV['SMTP_PASSWORD'] ?? '';

// Function to send email notification (manual SMTP with Mailtrap)
function sendOrderEmail($email, $order_id, $cart_items, $total) {
    global $smtp_host, $smtp_port, $smtp_username, $smtp_password;

    $from = "no-reply@juakali.com";
    $subject = "Order Confirmation - Order #$order_id";
    $message = "Thank you for your order!\n\nOrder ID: $order_id\nItems:\n";
    foreach ($cart_items as $item) {
        $message .= "- {$item['name']} (KES " . number_format($item['price'], 2) . ") x {$item['quantity']}\n";
    }
    $message .= "\nTotal: KES " . number_format($total, 2) . "\n\nView your orders at: http://localhost/juakali/track.php";

    $smtp = @fsockopen($smtp_host, $smtp_port, $errno, $errstr, 30);
    if (!$smtp) {
        error_log("SMTP connection failed: $errstr ($errno)");
        return false;
    }

    fputs($smtp, "HELO localhost\r\n");
    fputs($smtp, "AUTH LOGIN\r\n");
    fputs($smtp, base64_encode($smtp_username) . "\r\n");
    fputs($smtp, base64_encode($smtp_password) . "\r\n");
    fputs($smtp, "MAIL FROM: <$from>\r\n");
    fputs($smtp, "RCPT TO: <$email>\r\n");
    fputs($smtp, "DATA\r\n");
    fputs($smtp, "Subject: $subject\r\n");
    fputs($smtp, "From: $from\r\n");
    fputs($smtp, "To: $email\r\n");
    fputs($smtp, "\r\n$message\r\n");
    fputs($smtp, ".\r\n");
    fputs($smtp, "QUIT\r\n");

    fclose($smtp);
    error_log("Email sent successfully to $email");
    return true;
}

// Function to send SMS notification (Africa's Talking HTTP API)
function sendOrderSMS($phone, $order_id, $total) {
    global $at_api_key, $at_username;

    $url = "https://api.sandbox.africastalking.com/version1/message";
    $message = "Order #$order_id confirmed! Total: KES " . number_format($total, 2) . ". View your orders at: http://localhost/juakali/track.php";
    $data = http_build_query([
        'username' => $at_username,
        'to' => $phone,
        'message' => $message
    ]);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "ApiKey: $at_api_key",
        "Content-Type: application/x-www-form-urlencoded",
        "Accept: application/json"
    ]);
    $response = curl_exec($ch);
    if ($response === false) {
        error_log("SMS failed: " . curl_error($ch));
        return false;
    } else {
        error_log("SMS sent successfully: " . $response);
        return true;
    }
    curl_close($ch);
}

// Read callback response
$response = file_get_contents('php://input');
if ($response === false) {
    error_log("Failed to read callback response.");
    http_response_code(400);
    exit("Invalid request");
}

$response_data = json_decode($response, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    error_log("Failed to parse callback JSON: " . json_last_error_msg());
    http_response_code(400);
    exit("Invalid JSON");
}

if (!isset($response_data['Body']['stkCallback']['ResultCode'])) {
    error_log("Invalid callback response structure: " . $response);
    http_response_code(400);
    exit("Invalid callback response");
}

$resultCode = $response_data['Body']['stkCallback']['ResultCode'];
$checkoutRequestID = $response_data['Body']['stkCallback']['CheckoutRequestID'] ?? '';

if (empty($checkoutRequestID)) {
    error_log("Missing CheckoutRequestID in callback response: " . $response);
    http_response_code(400);
    exit("Missing CheckoutRequestID");
}

// Fetch order by CheckoutRequestID
global $pdo;
$stmt = $pdo->prepare("SELECT id, user_id, total, payment_status FROM orders WHERE checkout_request_id = ?");
$stmt->execute([$checkoutRequestID]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    error_log("Order not found for CheckoutRequestID: $checkoutRequestID");
    http_response_code(404);
    exit("Order not found");
}

// Update order status based on ResultCode
if ($resultCode == 0) {
    // Payment successful
    $stmt = $pdo->prepare("UPDATE orders SET payment_status = 'completed' WHERE checkout_request_id = ?");
    $stmt->execute([$checkoutRequestID]);
    file_put_contents('logs/success.log', date('Y-m-d H:i:s') . " - " . print_r($response_data, true) . "\n", FILE_APPEND);

    // Fetch cart items for notifications
    $stmt = $pdo->prepare("SELECT oi.product_id, oi.quantity, oi.price, p.name FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?");
    $stmt->execute([$order['id']]);
    $cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch user email and phone
    $stmt = $pdo->prepare("SELECT email, phone FROM users WHERE id = ?");
    $stmt->execute([$order['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $email = $user['email'];
        $phone = $user['phone'] ? '+254' . substr($user['phone'], -9) : '';
        if ($email) {
            sendOrderEmail($email, $order['id'], $cart_items, $order['total']);
        }
        if ($phone) {
            sendOrderSMS($phone, $order['id'], $order['total']);
        }
    }

    // Clear cart
    $pdo->prepare("DELETE FROM cart WHERE user_id = ?")->execute([$order['user_id']]);
} else {
    // Payment failed
    $stmt = $pdo->prepare("UPDATE orders SET payment_status = 'failed' WHERE checkout_request_id = ?");
    $stmt->execute([$checkoutRequestID]);
    file_put_contents('logs/error.log', date('Y-m-d H:i:s') . " - " . print_r($response_data, true) . "\n", FILE_APPEND);
}

http_response_code(200);
exit("Callback processed");
?>