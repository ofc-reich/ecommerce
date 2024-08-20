<?php
session_start();
include_once("conn/ecommerce.php");
$con = connection();

// Get the user ID from the GET request
$user_id = $_GET['id'];

// Delete the user from the database
$delete_user_sql = "DELETE FROM users WHERE id =?";
$stmt = $con->prepare($delete_user_sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "User deleted successfully!";
    header("Location: login.php"); // Redirect back to users page
    exit;
} else {
    echo "Error deleting user: ". $con->error;
}

?>