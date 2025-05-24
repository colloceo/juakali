<?php
session_start();

// Load environment variables
require_once 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Include functions.php for PDO connection
require_once 'functions.php'; // Assuming functions.php sets up $pdo

$shortcode = $_ENV['MPESA_SHORTCODE'] ?? '';
$passkey = $_ENV['MPESA_PASSKEY'] ?? '';
$consumer_key = $_ENV['MPESA_CONSUMER_KEY'] ?? '';
$consumer_secret = $_ENV['MPESA_CONSUMER_SECRET'] ?? '';
$callback_url = $_ENV['MPESA_CALLBACK_URL'] ?? '';

if (empty($shortcode) || empty($passkey) || empty($consumer_key) || empty($consumer_secret) || empty($callback_url)) {
    error_log("Missing M-Pesa environment variables.");
    $_SESSION['error_message'] = "Server configuration error. Please contact support.";
    header("Location: checkout.php"); // Redirect back to checkout with error
    exit();
}

// Africa's Talking credentials (if used for SMS notifications, etc.)
// Not directly used in the STK push logic here, but kept as per your original file.
$at_api_key = $_ENV['AT_API_KEY'] ?? '';
$at_username = $_ENV['AT_USERNAME'] ?? '';

// Mailtrap SMTP credentials (if used for email notifications)
// Not directly used in the STK push logic here, but kept as per your original file.
$smtp_host = $_ENV['SMTP_HOST'] ?? '';
$smtp_port = $_ENV['SMTP_PORT'] ?? '';
$smtp_username = $_ENV['SMTP_USERNAME'] ?? '';
$smtp_password = $_ENV['SMTP_PASSWORD'] ?? '';

/**
 * Generates an M-Pesa access token.
 *
 * @param string $consumer_key Your M-Pesa API Consumer Key.
 * @param string $consumer_secret Your M-Pesa API Consumer Secret.
 * @return string The generated access token.
 */
function generateAccessToken($consumer_key, $consumer_secret) {
    $url = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
    $credentials = base64_encode($consumer_key . ':' . $consumer_secret);
    $headers = ["Authorization: Basic " . $credentials];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // WARNING: Do not use in production without proper certificate validation
    $response = curl_exec($ch);
    $curl_error = curl_error($ch);
    curl_close($ch);

    if ($response === false) {
        error_log("Access token generation failed: " . $curl_error);
        $_SESSION['error_message'] = "Failed to generate access token. Please try again.";
        header("Location: checkout.php");
        exit();
    }

    $response_data = json_decode($response, true);
    if (!isset($response_data['access_token'])) {
        error_log("Access token missing in response: " . json_encode($response_data));
        $_SESSION['error_message'] = "Failed to authenticate with M-Pesa. Please try again.";
        header("Location: checkout.php");
        exit();
    }
    return $response_data['access_token'];
}

/**
 * Formats a phone number to the 254XXXXXXXXX format required by M-Pesa.
 *
 * @param string $phone The phone number to format.
 * @return string The formatted phone number.
 */
function formatPhoneNumber($phone) {
    $phone = preg_replace('/[^0-9]/', '', $phone); // Remove non-numeric characters
    if (substr($phone, 0, 1) === '0') {
        $phone = '254' . substr($phone, 1); // Convert 07... to 2547...
    } elseif (substr($phone, 0, 4) === '+254') {
        $phone = substr($phone, 1); // Remove leading '+' from +2547...
    }
    // Final check for 12 digits and starting with 254
    if (strlen($phone) !== 12 || substr($phone, 0, 3) !== '254') {
        error_log("Invalid phone number format for M-Pesa: $phone");
        $_SESSION['error_message'] = "Invalid phone number format. Please use a valid Safaricom number (e.g., 254712345678).";
        header("Location: checkout.php");
        exit();
    }
    return $phone;
}

// Validate session data for order ID and user ID
$order_id = $_SESSION['current_order_id'] ?? null;
$user_id = $_SESSION['user_id'] ?? null; // Ensure user_id is also available

if (!$order_id || !$user_id) {
    error_log("Missing order_id or user_id in session on mpesa.php load.");
    $_SESSION['error_message'] = "Order details missing. Please restart the checkout process.";
    header("Location: checkout.php");
    exit();
}

// Fetch order details from the database using the order_id and user_id for security
global $pdo; // Access the PDO object from functions.php
$stmt = $pdo->prepare("SELECT total, mpesa_phone_number FROM orders WHERE id = ? AND user_id = ?");
$stmt->execute([$order_id, $user_id]); // Ensure the order belongs to the logged-in user
$order_data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order_data) {
    error_log("Order not found or does not belong to user: Order ID $order_id, User ID $user_id");
    $_SESSION['error_message'] = "Order details could not be retrieved. Please try again.";
    header("Location: checkout.php");
    exit();
}

$totalAmount = $order_data['total'];
$mpesa_number = $order_data['mpesa_phone_number'];

// Ensure M-Pesa number was stored and is valid
if (empty($mpesa_number)) {
    error_log("M-Pesa phone number not found in order for order ID: $order_id");
    $_SESSION['error_message'] = "M-Pesa phone number missing for this order. Please try again.";
    header("Location: checkout.php");
    exit();
}

// Format phone number before M-Pesa API call
$mpesa_number = formatPhoneNumber($mpesa_number);

// Generate access token
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
    'PartyB' => $shortcode, // This should be your shortcode
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
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // WARNING: Do not use in production without proper certificate validation

$response = curl_exec($ch);
$curl_error = curl_error($ch);
curl_close($ch);

if ($response === false) {
    error_log("M-Pesa request failed: " . $curl_error);
    $_SESSION['error_message'] = "Error occurred while processing payment. Please try again.";
    header("Location: checkout.php"); // Redirect back to checkout with error
    exit();
}

$response_data = json_decode($response, true);
error_log("M-Pesa Response: " . json_encode($response_data));

// Handle M-Pesa API response
if (isset($response_data['ResponseCode']) && $response_data['ResponseCode'] == "0") {
    $_SESSION['checkout_request_id'] = $response_data['CheckoutRequestID'];
    // Update order status to 'Awaiting M-Pesa Confirmation' in the database
    $stmt = $pdo->prepare("UPDATE orders SET status = 'Awaiting M-Pesa Confirmation', checkout_request_id = ? WHERE id = ?");
    $stmt->execute([$response_data['CheckoutRequestID'], $order_id]);
    
    // Clear the current_order_id from session as the STK push has been initiated
    unset($_SESSION['current_order_id']);

    // Redirect to order confirmation page with success message
    header("Location: order_confirmation.php?order_id=$order_id&mpesa_status=initiated&message=" . urlencode("M-Pesa STK push initiated successfully. Please check your phone to complete the payment."));
    exit();
} else {
    // M-Pesa API returned an error or non-zero response code
    $error_message = $response_data['ResponseDescription'] ?? $response_data['errorMessage'] ?? "Unknown M-Pesa error.";
    error_log("M-Pesa Payment Initiation Failed: " . $error_message);
    
    // Update order status to 'M-Pesa Initiation Failed'
    $stmt = $pdo->prepare("UPDATE orders SET status = 'M-Pesa Initiation Failed' WHERE id = ?");
    $stmt->execute([$order_id]);

    // Clear the current_order_id from session
    unset($_SESSION['current_order_id']);

    $_SESSION['error_message'] = "M-Pesa payment initiation failed: " . $error_message;
    header("Location: checkout.php"); // Redirect back to checkout with error
    exit();
}
?>
