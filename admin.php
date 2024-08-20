<?php
    include_once("conn/ecommerce.php");
    $con = connection();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/33297be680.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="css-basic.css" />
    <title>Admin Panel</title>
</head>
<body>
    <div class="admin-main-container">
        <div class="nav-bar">
            <div class="admin-first-div">
                <a href="index.php">
                    <h3> Reich </h3>
                </a>
            </div>
            <div class="admin-secondary-div">

            </div>
            <div class="admin-third-div">

            </div>
        </div>
        <div class="admin-contents-container">
            <a href="viewAdmin.php">
                <div class="admin-options" id="#adminLists">
                    <div class="admin-function-symbol color-icon">
                        <i class="fa-solid fa-star"></i>
                    </div>
                    <div class="admin-wrapper">
                        <div class="admin-function-name">
                            <h2> Admins </h2>
                        </div>
                        <div class="admin-function-desc">
                            <p>
                                Access the Admin Section to manage your eCommerce website. 
                                Here, you can modify existing admins.
                            </p>
                        </div>
                    </div>
                </div>
            </a>

            <a href="viewSold.php">
                <div class="admin-options" id="soldProductAdmin">
                    <div class="admin-function-symbol color-icon">
                        <i class="fa-solid fa-money-bill"></i>
                    </div>
                    <div class="admin-wrapper">
                        <div class="admin-function-name">
                            <h2> Sold Products </h2>
                        </div>
                        <div class="admin-function-desc">
                            <p>
                                Check the Sold Products section to see a list of all items that have been sold. 
                                You'll find details like product names, quantities sold, and etc.
                            </p>
                        </div>
                    </div>
                </div>
            </a>

            <a href="viewOrders.php">
                <div class="admin-options" id="viewOrdersAdmin">
                    <div class="admin-function-symbol color-icon">
                        <i class="fa-solid fa-briefcase"></i>
                    </div>
                    <div class="admin-wrapper">
                        <div class="admin-function-name">
                            <h2> View Orders </h2>
                        </div>
                        <div class="admin-function-desc">
                            <p>
                                Use the View Orders option to see details of all the orders placed on your website. 
                                You can check order statuses, and purchased products.
                            </p>
                        </div>
                    </div>
                </div>
            </a>

            <a href="viewProducts.php">
                <div class="admin-options" id="#viewProductAdmin">
                    <div class="admin-function-symbol color-icon">
                        <i class="fa-solid fa-shop"></i>
                    </div>
                    <div class="admin-wrapper">
                        <div class="admin-function-name">
                            <h2> View Products </h2>
                        </div>
                        <div class="admin-function-desc">
                            <p>
                                Click on View Products to browse all the items available for purchase. 
                                You'll see product names, prices, descriptions, and images.
                            </p>
                        </div>
                    </div>
                </div>
            </a>

            <a href="viewUsers.php">
                <div class="admin-options" id="#addProductAdmin">
                    <div class="admin-function-symbol color-icon">
                        <i class="fa-solid fa-person-booth"></i>
                    </div>
                    <div class="admin-wrapper">
                        <div class="admin-function-name">
                            <h2> View Users </h2>
                        </div>
                        <div class="admin-function-desc">
                            <p>
                                Use this option to add new users to your online store. 
                                Fill in the user details, and assign them as an admin or a regular user.
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</body>
</html>