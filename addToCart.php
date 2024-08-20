<?php
session_start();
include_once("conn/ecommerce.php");
$con = connection();

if (!isset($_SESSION['session_id'])) {
    $_SESSION['session_id'] = session_id();
}

$product_id = $_POST['product_id'];
$quantity = 1; // Default quantity when adding to cart
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$session_id = $_SESSION['session_id'];

$cart_sql = "SELECT * FROM cart WHERE (user_id = ? OR session_id = ?) AND product_id = ?";
$stmt = $con->prepare($cart_sql);
$stmt->bind_param("isi", $user_id, $session_id, $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Update quantity if item already in cart
    $update_sql = "UPDATE cart SET quantity = quantity + 1 WHERE (user_id = ? OR session_id = ?) AND product_id = ?";
    $stmt = $con->prepare($update_sql);
    $stmt->bind_param("isi", $user_id, $session_id, $product_id);
    $stmt->execute();
} else {
    // Insert new item into cart
    $insert_sql = "INSERT INTO cart (user_id, session_id, product_id, quantity) VALUES (?, ?, ?, ?)";
    $stmt = $con->prepare($insert_sql);
    $stmt->bind_param("issi", $user_id, $session_id, $product_id, $quantity);
    $stmt->execute();
}

echo "Product added to cart successfully";
?>
