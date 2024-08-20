<?php
session_start();
include_once("conn/ecommerce.php");
$con = connection();

// Get the product ID from the GET request
$product_id = $_GET['id'];

// Fetch the product data from the database
$product_sql = "SELECT * FROM products WHERE id = '$product_id'";
$stmt = $con->prepare($product_sql);
$stmt->execute();
$product_result = $stmt->get_result();
$product = $product_result->fetch_assoc();

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the updated product data from the form
    $product_name = $_POST['name'];
    $product_price = $_POST['price'];
    $product_type = $_POST['type'];
    $product_description = $_POST['description'];

    // Check if a new image was uploaded
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
            $target_file = $target_dir . basename($image_name);
            if (move_uploaded_file($image_tmp_name, $target_file)) {
                // Update the product image in the database
                $update_image_sql = "UPDATE products SET productimage = '$image_name' WHERE id = '$product_id'";
                $stmt = $con->prepare($update_image_sql);
                $stmt->execute();
            } else {
                echo "Error uploading image: " . $con->error;
            }
        } else {
            echo "Error uploading image: " . $con->error;
        }
    }

    // Update the product data in the database
    $update_sql = "UPDATE products SET productname = '$product_name', productprice = '$product_price', producttype = '$product_type', productdescription = '$product_description' WHERE id = '$product_id'";
    $stmt = $con->prepare($update_sql);
    $stmt->execute();

    // Check if the update was successful
    if ($stmt->affected_rows > 0) {
        echo "Product updated successfully!";
        header("Location: viewProducts.php"); // Redirect back to products page
        exit;
    } else {
        echo "Error updating product: " . $con->error;
    }
}

// Display the product data in a modal
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css-modals.css" />
    <title>Edit Product</title>
</head>
<body>
    <img src="images/<?php echo htmlspecialchars($product['productimage']);?>" class="edit-product-img" alt="Product Image">
    <div class="edit-product-modal-container" id="edit-product-modal-container">
        <div class="edit-product-modal" id="edit-product-modal">
            <span class="modal-close" id="edit-product-modal-close">&times;</span>
            <div class="edit-product-modal-content">
                <h1 id="editProductHeading">Edit Product</h1>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="editContents">
                        <div>
                            <input type="hidden" name="id" value="<?php echo $product['id'];?>">
                            <label for="product-name" class="edit-product-label" >Name:</label>
                            <input type="text" id="product-name" class="edit-product-input" name="name" value="<?php echo $product['productname'];?>">
                            <label for="product-price" class="edit-product-label">Price:</label>
                            <input type="number" id="product-price" class="edit-product-input" name="price" value="<?php echo $product['productprice'];?>">
                            <label for="product-type" class="edit-product-label">Type:</label>
                            <input type="text" id="product-type" class="edit-product-input" name="type" value="<?php echo $product['producttype'];?>">
                        </div>
                        <div>
                            <label for="product-description" class="edit-product-label">Description:</label>
                            <textarea id="product-description" class="edit-product-textarea" name="description"><?php echo $product['productdescription'];?></textarea>
                            <label for="product-image" class="edit-product-label">Image:</label>
                            <input type="file" id="product-image" class="edit-product-input" name="image">
                        </div>
                    </div>
                    

                    <button type="submit" id="editProductBtn">Update</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Show the modal when the page loads
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("edit-product-modal-container").style.display = "block";
            document.getElementById("edit-product-modal").style.display = "block";
        });

        // Close the modal when the close button is clicked
        document.getElementById("edit-product-modal-close").addEventListener("click", function() {
            document.getElementById("edit-product-modal-container").style.display = "none";
            document.getElementById("edit-product-modal").style.display = "none";
        });
    </script>
</body>
</html>