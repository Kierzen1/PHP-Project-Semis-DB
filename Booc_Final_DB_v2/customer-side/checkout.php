<?php
include 'db.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['c_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Fetch items from the user's cart
$cart_id = $_SESSION['c_id'];
$cart_query = "SELECT Items.*, Cart.cart_id FROM Items JOIN Cart ON Items.i_id = Cart.item_id WHERE Cart.cart_id = $cart_id";
$cart_result = $conn->query($cart_query);
$cart_items = $cart_result->fetch_all(MYSQLI_ASSOC);

// Handle order placement
if (isset($_POST['place_order'])) {
    $shipping_address = mysqli_real_escape_string($conn, $_POST['shipping_address']);

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Create a new order
        $order_query = "INSERT INTO Orders (o_date, shipping_address, c_id) VALUES (NOW(), '$shipping_address', $cart_id)";
        $conn->query($order_query);

        // Get the order ID
        $order_id = $conn->insert_id;

        // Move cart items to order details with quantity
        foreach ($cart_items as $cart_item) {
            $item_id = $cart_item['i_id'];
            $quantity = $_POST['quantity'][$item_id] ?? 1; // Use the selected quantity or default to 1

            // Create order details
            $order_details_query = "INSERT INTO OrderDetails (i_id, o_id, qty) VALUES ($item_id, $order_id, $quantity)";
            $conn->query($order_details_query);

            // Update item quantity in the Items table
            $update_quantity_query = "UPDATE Items SET stocks = stocks - $quantity WHERE i_id = $item_id";
            $conn->query($update_quantity_query);
        }

        // Clear the user's cart after placing the order
        $clear_cart_query = "DELETE FROM Cart WHERE cart_id = $cart_id";
        $conn->query($clear_cart_query);

        // Commit the transaction
        $conn->commit();

        // Redirect to a thank you page or display a success message
        header("Location: thank_you.php");
        exit();
    } catch (Exception $e) {
        // Rollback the transaction on error
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <style>
        /* Styles remain unchanged */
		body {
            font-family: 'Kanit';
            margin: 0;
            padding: 0;
            background-color: #FFF2D8;
         
        }
        .checkout-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color:#CFA983;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .checkout-item {
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 20px;
            padding: 10px;
			background-color: #EAD7BB;
        }

        .checkout-item img {
            max-width: 100%;
            height: auto;
        }

        .place-order {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            margin-top: 5px;
        }
    </style>
</head>
<body>

<div class="checkout-container">
    <h2>Checkout</h2>

    <?php
    if (empty($cart_items)) {
        echo '<p>Your cart is empty. <a href="index.php">Continue shopping</a></p>';
    } else {
        echo '<form method="post" action="">';
        foreach ($cart_items as $cart_item) {
            echo '<div class="checkout-item">';
            echo '<h3>' . $cart_item['title'] . '</h3>';
            echo '<p>Author: ' . $cart_item['author'] . '</p>';
            echo '<p>Genre: ' . $cart_item['genre'] . '</p>';
            echo '<p>Price: $' . $cart_item['price'] . '</p>';
            echo '<img src="path/to/your/images/' . $cart_item['i_id'] . '.jpg" alt="' . $cart_item['title'] . '">';

            // Quantity input field
            echo '<label for="quantity[' . $cart_item['i_id'] . ']">Quantity:</label>';
            echo '<input type="number" name="quantity[' . $cart_item['i_id'] . ']" value="1" min="1" required>';

            echo '</div>';
        }

        // Display a summary of the total cost
        $total_cost_query = "SELECT SUM(price) AS total_cost FROM Items WHERE i_id IN (SELECT item_id FROM Cart WHERE cart_id = $cart_id)";
        $total_cost_result = $conn->query($total_cost_query);
        $total_cost = $total_cost_result->fetch_assoc()['total_cost'];

        // Shipping address input field
        echo '<label for="shipping_address">Shipping Address:</label>';
        echo '<input type="text" name="shipping_address" required>';

        // Place Order button
        echo '<button class="place-order" type="submit" name="place_order">Place Order</button>';
        echo '</form>';
    }
    ?>

    <p><a href="index.php">Back to Home</a></p>
</div>

</body>
</html>
