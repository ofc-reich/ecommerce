<?php
session_start();
include_once("conn/ecommerce.php");
$con = connection();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete related rows in sold table
    $delete_sold_sql = "DELETE FROM sold WHERE product_id =?";
    $stmt = $con->prepare($delete_sold_sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Delete related rows in cart table
    $delete_cart_sql = "DELETE FROM cart WHERE product_id =?";
    $stmt = $con->prepare($delete_cart_sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Delete product
    $delete_sql = "DELETE FROM products WHERE id =?";
    $stmt = $con->prepare($delete_sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: viewProducts.php"); // Redirect back to products page
        exit;
    } else {
        echo "Error deleting product";
    }
} else {
    echo "No ID provided";
}
?>