<?php
session_start();
include_once("conn/ecommerce.php");
$con = connection();

if (!isset($_SESSION['session_id'])) {
    $_SESSION['session_id'] = session_id();
}

$session_id = $_SESSION['session_id'];
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Check if user is logged in
if (!$user_id) {
    header('Location: login.php'); // Redirect to login page
    exit;
}

$cart_sql = "SELECT c.product_id, p.productname, p.productprice, c.quantity, p.producttype, p.productdescription, p.productimage
            FROM cart c
            JOIN products p ON c.product_id = p.id
            WHERE c.user_id = ?";

$stmt = $con->prepare($cart_sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$cart_result = $stmt->get_result();

$cart_items = array();
while ($row = $cart_result->fetch_assoc()) {
    $cart_items[] = $row;
}

function calculateTotalCost($cart_items) {
    $total_cost = 0;
    foreach ($cart_items as $item) {
        $total_cost += $item['productprice'] * $item['quantity'];
    }
    return $total_cost;
}

// Update cart item quantity
if (isset($_POST['update_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    $update_sql = "UPDATE cart SET quantity = ? WHERE product_id = ? AND user_id = ?";
    $stmt = $con->prepare($update_sql);
    $stmt->bind_param("iii", $quantity, $product_id, $user_id);
    $stmt->execute();
}

// Remove cart item
if (isset($_POST['remove_item'])) {
    $product_id = $_POST['product_id'];

    $remove_sql = "DELETE FROM cart WHERE product_id = ? AND user_id = ?";
    $stmt = $con->prepare($remove_sql);
    $stmt->bind_param("ii", $product_id, $user_id);
    $stmt->execute();
}

// Add to cart
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    $check_sql = "SELECT * FROM cart WHERE product_id = ? AND user_id = ?";
    $stmt = $con->prepare($check_sql);
    $stmt->bind_param("ii", $product_id, $user_id);
    $stmt->execute();
    $check_result = $stmt->get_result();

    if ($check_result->num_rows > 0) {
        $update_sql = "UPDATE cart SET quantity = quantity + ? WHERE product_id = ? AND user_id = ?";
        $stmt = $con->prepare($update_sql);
        $stmt->bind_param("iii", $quantity, $product_id, $user_id);
        $stmt->execute();
    } else {
        $add_sql = "INSERT INTO cart (product_id, user_id, quantity) VALUES (?, ?, ?)";
        $stmt = $con->prepare($add_sql);
        $stmt->bind_param("iii", $product_id, $user_id, $quantity);
        $stmt->execute();
    }
}

?>

<!-- HTML code here -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css-basic.css" />
    <title>Your Cart</title>
    <style>
        
        
    </style>
</head>
<body>
    <div class="cart-main-container">
        <div class="nav-bar">
            <div class="first-div">
                <a href="index.php">
                <h3> Reich </h3>
                </a>
            </div>
            <div class="secondary-div">
                
            </div>
            <div class="third-div">
                <a href="cart.php"> Cart </a>
                <a href="profile.php"> Profile</a>
                <a href="adminLogin.php"> Admin </a>
                <a href="logout.php"> Logout </a>
            </div>

        </div>
        <div class="cart-contents-container">
            <div class="cart-info-container">
                <?php if (!empty($cart_items)) { ?>
                <?php foreach ($cart_items as $item) { ?>
                    <div class="cart-item" data-product-id="<?php echo $item['product_id']; ?>">
                        <div id="cartImageDiv">
                            <img src="images/<?php echo $item['productimage'];?>">
                        </div>
                        <div class="" id="cartInfosDiv">
                            <div id="cartNameDiv">
                                <p><?php echo htmlspecialchars($item['productname']); ?></p>
                            </div>
                            <div id="cartPriceDiv">
                                <p>$<?php echo htmlspecialchars($item['productprice']); ?></p>
                            </div>
                            <div id="cartTypeDiv">
                                <p><?php echo htmlspecialchars($item['producttype']); ?></p>
                            </div>
                            <div id="cartDescDiv">
                                <p><?php echo htmlspecialchars($item['productdescription']); ?></p>
                            </div>
                        </div>
                        <div id="cartOperationDiv">
                            <div id="cartQuantityDiv">
                                <button id="quantityControl" class="quantity-decrease">-</button>
                                <input type="number" class="quantity-input" value="<?php echo $item['quantity']; ?>" min="1">
                                <button id="quantityControl" class="quantity-increase">+</button>
                            </div>
                            <div id="cartRemoveDiv">
                                <button class="remove-item">Remove</button>
                            </div> 
                        </div>
                    </div>
                <?php } ?>    
                <?php } else { ?>
                    <p id="cartEmpty">Your cart is empty.</p>
                <?php } ?>
                
                <div class="checkout-container">
                <div class="total">
                    <h2 style="font-family: SF-Bold;">Total: $<?php echo calculateTotalCost($cart_items); ?></h2>
                </div>
                <div class="checkout-btns">
                    <a href="index.php">
                        <button id="goBack"> Go Back </button>
                    </a>
                    <form action="checkout.php" method="post">
                        <input type="submit" id="checkOut" value="Checkout">
                    </form>
                </div>
            </div>
            </div>

        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cartItems = document.querySelectorAll('.cart-item');

            cartItems.forEach(item => {
                const productId = item.getAttribute('data-product-id');

                const quantityInput = item.querySelector('.quantity-input');
                const decreaseButton = item.querySelector('.quantity-decrease');
                const increaseButton = item.querySelector('.quantity-increase');
                const removeButton = item.querySelector('.remove-item');

                decreaseButton.addEventListener('click', function () {
                    if (quantityInput.value > 1) {
                        quantityInput.value--;
                        updateCart(productId, quantityInput.value);
                    }
                });

                increaseButton.addEventListener('click', function () {
                    quantityInput.value++;
                    updateCart(productId, quantityInput.value);
                });

                quantityInput.addEventListener('change', function () {
                    if (quantityInput.value < 1) {
                        quantityInput.value = 1;
                    }
                    updateCart(productId, quantityInput.value);
                });

                removeButton.addEventListener('click', function () {
                    removeFromCart(productId);
                });
            });

            function updateCart(productId, quantity) {
                const formData = new FormData();
                formData.append('update_cart', 'true');
                formData.append('product_id', productId);
                formData.append('quantity', quantity);

                fetch('cart.php', {
                    method: 'POST',
                    body: formData
                })
            .then(response => response.text())
            .then(data => {
                    console.log(data);
                    location.reload(); // Refresh the page to reflect changes
                })
            .catch(error => console.error('Error:', error));
            }

            function removeFromCart(productId) {
                const formData = new FormData();
                formData.append('remove_item', 'true');
                formData.append('product_id', productId);

                fetch('cart.php', {
                    method: 'POST',
                    body: formData
                })
            .then(response => response.text())
            .then(data => {
                    console.log(data);
                    location.reload(); // Refresh the page to reflect changes
                })
            .catch(error => console.error('Error:', error));
            }
        });
    </script>
</body>
</html>
