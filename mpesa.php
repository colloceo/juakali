<?php
session_start();

// Load environment variables
require_once 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$shortcode = $_ENV['MPESA_SHORTCODE'] ?? '';
$passkey = $_ENV['MPESA_PASSKEY'] ?? '';
$consumer_key = $_ENV['MPESA_CONSUMER_KEY'] ?? '';
$consumer_secret = $_ENV['MPESA_CONSUMER_SECRET'] ?? '';
$callback_url = $_ENV['MPESA_CALLBACK_URL'] ?? '';

if (empty($shortcode) || empty($passkey) || empty($consumer_key) || empty($consumer_secret) || empty($callback_url)) {
    error_log("Missing M-Pesa environment variables.");
    header("Location: error.php?message=" . urlencode("Server configuration error. Please contact support."));
    exit();
}

// Africa's Talking credentials
$at_api_key = $_ENV['AT_API_KEY'] ?? '';
$at_username = $_ENV['AT_USERNAME'] ?? '';

// Mailtrap SMTP credentials
$smtp_host = $_ENV['SMTP_HOST'] ?? '';
$smtp_port = $_ENV['SMTP_PORT'] ?? '';
$smtp_username = $_ENV['SMTP_USERNAME'] ?? '';
$smtp_password = $_ENV['SMTP_PASSWORD'] ?? '';

// Generate access token for M-Pesa
function generateAccessToken($consumer_key, $consumer_secret) {
    $url = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
    $credentials = base64_encode($consumer_key . ':' . $consumer_secret);
    $headers = ["Authorization: Basic " . $credentials];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    $curl_error = curl_error($ch);
    curl_close($ch);

    if ($response === false) {
        error_log("Access token generation failed: " . $curl_error);
        header("Location: error.php?message=" . urlencode("Failed to generate access token. Please try again."));
        exit();
    }

    $response_data = json_decode($response, true);
    if (!isset($response_data['access_token'])) {
        error_log("Access token missing in response: " . json_encode($response_data));
        header("Location: error.php?message=" . urlencode("Failed to authenticate with M-Pesa. Please try again."));
        exit();
    }
    return $response_data['access_token'];
}

// Format phone number function
function formatPhoneNumber($phone) {
    $phone = preg_replace('/[^0-9]/', '', $phone);
    if (substr($phone, 0, 1) === '0') {
        $phone = '254' . substr($phone, 1);
    } elseif (substr($phone, 0, 4) === '+254') {
        $phone = substr($phone, 1);
    }
    if (strlen($phone) !== 12 || substr($phone, 0, 3) !== '254') {
        error_log("Invalid phone number: $phone");
        header("Location: checkout.php?error=" . urlencode("Invalid phone number format. Use 2547xxxxxxxxx (e.g., 254712345678)."));
        exit();
    }
    return $phone;
}

// Log session data for debugging
error_log("Session ID: " . session_id());
error_log("Session data on mpesa.php load: " . print_r($_SESSION, true));

// Validate session data
$totalAmount = $_SESSION['totalAmount'] ?? null;
$mpesa_number = $_SESSION['mpesa_number'] ?? null;
$email = $_SESSION['email'] ?? null;
$order_id = $_SESSION['order_id'] ?? null;
$cart_items = $_SESSION['cart_items'] ?? null;

if (!isset($totalAmount, $mpesa_number, $order_id, $cart_items, $email)) {
    error_log("Missing session data: " . print_r($_SESSION, true));
    header("Location: checkout.php?error=" . urlencode("Required session data missing. Please complete the checkout process."));
    exit();
}

$mpesa_number = formatPhoneNumber($mpesa_number);
$access_token = generateAccessToken($consumer_key, $consumer_secret);

$timestamp = date('YmdHis');
$password_string = $shortcode . $passkey . $timestamp;
$encoded_password = base64_encode($password_string);

$url = "https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest";
$headers = [
    "Content-Type:application/json",
    "Authorization:Bearer " . $access_token,
];

$request_data = [
    'BusinessShortCode' => $shortcode,
    'Password' => $encoded_password,
    'Timestamp' => $timestamp,
    'TransactionType' => 'CustomerPayBillOnline',
    'Amount' => (int)$totalAmount, // Ensure integer amount
    'PartyA' => $mpesa_number,
    'PartyB' => $shortcode,
    'PhoneNumber' => $mpesa_number,
    'CallBackURL' => $callback_url,
    'AccountReference' => 'JuaKaliOrder#' . $order_id,
    'TransactionDesc' => 'Payment for order #' . $order_id,
];

$data = json_encode($request_data);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);
$curl_error = curl_error($ch);
curl_close($ch);

if ($response === false) {
    error_log("M-Pesa request failed: " . $curl_error);
    header("Location: error.php?message=" . urlencode("Error occurred while processing payment. Please try again."));
    exit();
}

$response_data = json_decode($response, true);
error_log("M-Pesa Response: " . json_encode($response_data));

if (isset($response_data['errorCode'])) {
    error_log("M-Pesa API Error: " . $response_data['errorMessage']);
    header("Location: error.php?message=" . urlencode($response_data['errorMessage']));
    exit();
}

if (isset($response_data['ResponseCode']) && $response_data['ResponseCode'] == "0") {
    $_SESSION['checkout_request_id'] = $response_data['CheckoutRequestID'];
    // Store payment status as pending in the database
    global $pdo;
    $stmt = $pdo->prepare("UPDATE orders SET payment_status = 'pending', checkout_request_id = ? WHERE id = ?");
    $stmt->execute([$response_data['CheckoutRequestID'], $order_id]);
    header("Location: payment_success.php?order_id=$order_id");
    exit();
} else {
    error_log("M-Pesa Payment Failed: " . $response_data['ResponseDescription']);
    header("Location: error.php?message=" . urlencode($response_data['ResponseDescription']));
    exit();
}
?>