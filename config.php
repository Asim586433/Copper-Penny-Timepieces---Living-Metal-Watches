<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'copper_penny');

// Site Configuration
define('SITE_NAME', 'Copper Penny Timepieces');
define('SITE_URL', 'http://localhost/copperpenny');
define('SITE_EMAIL', 'info@copperpenny.com');

// Currency Settings
define('CURRENCY', '$');
define('CURRENCY_CODE', 'USD');

// Payment Settings (Test Mode)
define('RAZORPAY_KEY_ID', 'rzp_test_your_test_key');
define('RAZORPAY_KEY_SECRET', 'your_test_secret');

// Session Start
session_start();

// Database Connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set timezone
date_default_timezone_set('America/New_York');

// Cart Functions
function getCartCount() {
    global $conn;
    $count = 0;
    
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $result = $conn->query("SELECT SUM(quantity) as total FROM cart WHERE user_id = $user_id");
        $row = $result->fetch_assoc();
        $count = $row['total'] ?? 0;
    } else {
        $session_id = session_id();
        $result = $conn->query("SELECT SUM(quantity) as total FROM cart WHERE session_id = '$session_id'");
        $row = $result->fetch_assoc();
        $count = $row['total'] ?? 0;
    }
    
    return $count ?? 0;
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}
?>
