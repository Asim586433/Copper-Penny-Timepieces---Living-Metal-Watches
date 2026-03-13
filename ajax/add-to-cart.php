<?php
require_once '../config.php';

$product_id = $_POST['product_id'] ?? 0;
$quantity = $_POST['quantity'] ?? 1;

$response = ['success' => false];

if($product_id) {
    if(isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        // Check if product already in cart
        $check = $conn->query("SELECT id, quantity FROM cart WHERE user_id = $user_id AND product_id = $product_id");
        
        if($check->num_rows > 0) {
            $row = $check->fetch_assoc();
            $new_quantity = $row['quantity'] + $quantity;
            $conn->query("UPDATE cart SET quantity = $new_quantity WHERE id = {$row['id']}");
        } else {
            $conn->query("INSERT INTO cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, $quantity)");
        }
    } else {
        $session_id = session_id();
        // Check if product already in cart
        $check = $conn->query("SELECT id, quantity FROM cart WHERE session_id = '$session_id' AND product_id = $product_id");
        
        if($check->num_rows > 0) {
            $row = $check->fetch_assoc();
            $new_quantity = $row['quantity'] + $quantity;
            $conn->query("UPDATE cart SET quantity = $new_quantity WHERE id = {$row['id']}");
        } else {
            $conn->query("INSERT INTO cart (session_id, product_id, quantity) VALUES ('$session_id', $product_id, $quantity)");
        }
    }
    
    $response['success'] = true;
    $response['cart_count'] = getCartCount();
}

header('Content-Type: application/json');
echo json_encode($response);
?>
