<?php
session_start();
include_once("conn/ecommerce.php");
$con = connection();

if (isset($_POST['admin_id'])) {
    $admin_id = $_POST['admin_id'];

    // Retrieve the admin data from the database
    $stmt = $con->prepare("SELECT * FROM admin WHERE id = ?");
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin_data = $result->fetch_assoc();

    // Display the edit form
    if (isset($_POST['admin_id']) && isset($_POST['name']) && isset($_POST['username']) && isset($_POST['password'])) {
        $admin_id = $_POST['admin_id'];
        $name = $_POST['name'];
        $username = $_POST['username'];
        $password = $_POST['password'];
    
        // Update the admin data in the database
        $stmt = $con->prepare("UPDATE admin SET name = ?, username = ?, password = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $username, $password, $admin_id);
        $stmt->execute();
    
        echo "Admin updated successfully!";
        header("Location: viewAdmin.php");
    } else {
        echo "Error: Missing form data.";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css-basic.css" />
    <title>Document</title>
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
                    <h1> Edit Admin </h1>
                    <p> Edit the current admin </p>
                </div>
                <div>
                    <form action="editAdmin.php" method="post" autocomplete="off">
                        <div style="line-height: 10px;">
                            <input type="hidden" name="admin_id" value="<?php echo $admin_id; ?>">
                            <input type="text" class="admin-login-input" id="name" name="name" value="<?php echo $admin_data['name']; ?>" placeholder="Name"><br><br>
                            <input type="text" class="admin-login-input" id="username" name="username" value="<?php echo $admin_data['username']; ?>" placeholder="Username"> <br><br>
                            <input type="password" class="admin-login-input" id="password" name="password" value="<?php echo $admin_data['password']; ?>" placeholder="Password"><br><br>
                        </div>
                        <div>
                            <button type="submit" id="adminLoginButton" name="submit">Login</button>
                        </div>
                    </form>
                    <?php
                        } else {
                            echo "Error: No admin ID provided.";
                        }
                    ?>
                </div>

            </div>
        </div>
    </div>
</body>
</html>