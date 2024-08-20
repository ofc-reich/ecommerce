<?php
session_start();
include_once("conn/ecommerce.php");
$con = connection();

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the product data from the form
    $product_name = $_POST['name'];
    $product_price = $_POST['price'];
    $product_type = $_POST['type'];
    $product_description = $_POST['description'];

    // Check if an image was uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        // Get the uploaded file information
        $image_name = $_FILES['image']['name'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_size = $_FILES['image']['size'];
        $image_error = $_FILES['image']['error'];

        // Validate the uploaded file
        if ($image_error === UPLOAD_ERR_OK && is_uploaded_file($image_tmp_name)) {
            // Move the uploaded file to the server's uploads directory
            $target_dir = "uploads/";
            $target_file = $target_dir. basename($image_name);
            if (move_uploaded_file($image_tmp_name, $target_file)) {
                // Insert the product data into the database
                $insert_sql = "INSERT INTO products (productname, productprice, producttype, productdescription, productimage) VALUES ('$product_name', '$product_price', '$product_type', '$product_description', '$image_name')";
                $stmt = $con->prepare($insert_sql);
                $stmt->execute();

                // Check if the insertion was successful
                if ($stmt->affected_rows > 0) {
                    echo "Product added successfully!";
                    header("Location: viewProducts.php"); // Redirect back to products page
                    exit;
                } else {
                    echo "Error adding product: ". $con->error;
                }
            } else {
                echo "Error uploading image: ". $con->error;
            }
        } else {
            echo "Error uploading image: ". $con->error;
        }
    } else {
        echo "No image uploaded";
    }
}

// Display the add product form
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <style>
        /* Add your CSS styles here */
    </style>
</head>
<body>
    <div class="modal-container" id="modal-container">
        <div class="modal" id="modal">
            <span class="modal-close" id="modal-close">&times;</span>
            <div class="modal-content">
                <h1>Add Product</h1>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="editContents">
                        <div>
                            <label for="product-name">Name:</label>
                            <input type="text" id="product-name" name="name">
                            <label for="product-price">Price:</label>
                            <input type="number" id="product-price" name="price">
                            <label for="product-type">Type:</label>
                            <input type="text" id="product-type" name="type">
                        </div>
                        <div>
                            <label for="product-description">Description:</label>
                            <textarea id="product-description" name="description"></textarea>
                            <label for="product-image">Image:</label>
                            <input type="file" id="product-image" name="image">
                        </div>
                    </div>
                    <button type="submit">Add Product</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Show the modal when the page loads
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("modal-container").style.display = "block";
            document.getElementById("modal").style.display = "block";
        });

        // Close the modal when the close button is clicked
        document.getElementById("modal-close").addEventListener("click", function() {
            document.getElementById("modal-container").style.display = "none";
            document.getElementById("modal").style.display = "none";
        });
    </script>
</body>
</html>