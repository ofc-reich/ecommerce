<?php
session_start();
include_once("conn/ecommerce.php");
$con = connection();

if (isset($_POST['admin_id'])) {
    $admin_id = $_POST['admin_id'];

    // Delete the admin data from the database
    $stmt = $con->prepare("DELETE FROM admin WHERE id = ?");
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();

    echo "Admin deleted successfully!";
    header("Location: viewAdmin.php");
} else {
    echo "Error: No admin ID provided.";
}
?>