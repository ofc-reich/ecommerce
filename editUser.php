
<?php
session_start();
include_once("conn/ecommerce.php");
$con = connection();

// Get the user ID from the GET request
$user_id = $_GET['id'];

// Fetch the user data from the database
$user_sql = "SELECT * FROM users WHERE id = ?";
$stmt = $con->prepare($user_sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_result = $stmt->get_result();
$user = $user_result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $update_user_sql = "UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?";
    $stmt = $con->prepare($update_user_sql);
    $stmt->bind_param("sssi", $name, $email, $password, $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        echo "User updated successfully!";
        header("Location: profile.php"); // Redirect back to profile page
        exit;
    } else {
        echo "Error updating user: " . $con->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css-modals.css" />
    <title>Edit User</title>
    <style>
        
    </style>
</head>
<body>
    <img src="images/<?php echo htmlspecialchars($user['image']);?>" id="editUserImg" alt="User Image">
    <div class="edit-user-modal-container" id="editUserModalContainer">
        <div class="edit-user-modal" id="editUserModal">
            <span class="edit-user-modal-close" id="editUserModalClose">&times;</span>
            <div class="edit-user-modal-content" id="editUserModalContent">
                <h1>Edit User</h1>
                <form action="" method="post">
                    <div id="editUserEditContents">
                        <div>
                            <input type="hidden" name="id" value="<?php echo $user['id'];?>">
                            <label for="name" class="edit-user-label">Name:</label>
                            <input type="text" id="name" class="edit-user-input" name="name" value="<?php echo $user['name'];?>">
                            <label for="email" class="edit-user-label">Email:</label>
                            <input type="email" id="email" class="edit-user-input" name="email" value="<?php echo $user['email'];?>">
                        </div>
                        <div>
                            <label for="password" class="edit-user-label">Password:</label>
                            <input type="password" id="password" class="edit-user-input" name="password" value="<?php echo $user['password'];?>">
                        </div>
                    </div>
                    <button type="submit" id="editUserBtn">Update</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Show the modal when the page loads
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("editUserModalContainer").style.display = "block";
            document.getElementById("editUserModal").style.display = "block";
        });

        // Close the modal when the close button is clicked
        document.getElementById("editUserModalClose").addEventListener("click", function() {
            document.getElementById("editUserModalContainer").style.display = "none";
            document.getElementById("editUserModal").style.display = "none";
        });
    </script>
</body>
</html>