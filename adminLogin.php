<?php
    include_once("conn/ecommerce.php");
    $con = connection();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get the posted username, password, and name
        $username = $_POST["username"];
        $password = $_POST["password"];
        $name = $_POST["name"];

        // Query the admin table to check if the username, password, and name exist
        $stmt = $con->prepare("SELECT * FROM admin WHERE username=? AND password=?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if the query returned a row
        if ($result->num_rows > 0) {
            // Get the row from the result
            $row = $result->fetch_assoc();

            // Check if the entered name matches the one in the database
            if ($row["name"] == $name) {
                // Login successful, redirect to admin page
                header("Location: admin.php");
                exit;
            } else {
                // Name doesn't match, display error message
                echo "Invalid name";
            }
        } else {
            // Username or password is invalid, display error message
            echo "Invalid username or password";
        }
    }

    $con->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css-basic.css" />
    <title> Admin Log In</title>
    <style>

    </style>
</head>
<body>
    <div class="admin-login-main-container">
        <div class="nav-bar">
            <div class="first-div">
                <a href="index.php">
                <h3> Reich </h3>
                </a>
            </div>
            <div class="secondary-div">

            </div>
            <div class="third-div">
                <a href="index.php"> Products </a>
            </div>

        </div>
        <div class="admin-login-contents-container">
            <div class="admin-login-info-container">
                <div style="margin-bottom: 20px; line-height: 10px;">
                    <h1> Admin Login</h1>
                    <p> Enter to be an admin </p>
                </div>
                <div>
                    <form action="adminLogin.php" method="post" autocomplete="off">
                        <div style="line-height: 10px;">
                            <input type="text" class="admin-login-input" id="name" name="name" placeholder="Name"><br><br>
                            <input type="text" class="admin-login-input" id="username" name="username" placeholder="Username"> <br><br>
                            <input type="password" class="admin-login-input" id="password" name="password" placeholder="Password"><br><br>
                        </div>
                        <div>
                            <button type="submit" id="adminLoginButton" name="submit">Login</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</body>
</html>