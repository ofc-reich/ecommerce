<?php
function connection(){
    // Configuration
    $db_host = 'localhost';
    $db_username = 'root';
    $db_password = '';
    $db_name = 'ecommerce';

    // Create connection
    $conn = new mysqli($db_host, $db_username, $db_password, $db_name);

    // Check connection
    if (!$conn) {
        die("Connection failed: ". mysqli_connect_error());
    }

    // Retrieve data from MySQL database
    $result = mysqli_query($conn, "SELECT * FROM products ORDER BY RAND()");

    $data = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    return $conn; // Change this to return $conn
}
?>