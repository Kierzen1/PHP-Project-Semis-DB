<?php
include 'db.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['c_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Fetch items from the user's order
$order_id = $_GET['order_id']; // Assuming you pass the order_id through the URL
$order_query = "SELECT Items.*, Orders.o_id FROM Items JOIN Order_Items ON Items.i_id = Order_Items.item_id JOIN Orders ON Order_Items.order_id = Orders.order_id WHERE Orders.c_id = {$_SESSION['c_id']} AND Orders.order_id = $o_id";
$order_result = $conn->query($order_query);
$order_items = $order_result->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Order</title>
    <style>
        /* Styles remain unchanged */
		/* Add any additional styles you may need for the order details */
    </style>
</head>
<body>

<div class="cart-container">
    <h2>Order Details</h2>

    <?php
    if (empty($order_items)) {
        echo '<p>No items found for this order.</p>';
    } else {
        foreach ($order_items as $order_item) {
            echo '<div class="cart-item">';
            echo '<h3>' . $order_item['title'] . '</h3>';
            echo '<p>Author: ' . $order_item['author'] . '</p>';
            echo '<p>Genre: ' . $order_item['genre'] . '</p>';
            echo '<p>Price: $' . $order_item['price'] . '</p>';
            echo '</div>';
        }

        // Total Price
        $total_query = "SELECT SUM(price) as total_price FROM Items JOIN Order_Items ON Items.i_id = Order_Items.item_id JOIN Orders ON Order_Items.order_id = Orders.order_id WHERE Orders.c_id = {$_SESSION['c_id']} AND Orders.order_id = $order_id";
        $total_result = $conn->query($total_query);
        $total_price = $total_result->fetch_assoc()['total_price'];
        echo '<p>Total Price: $' . $total_price . '</p>';
    }
    ?>

    <p><a href="orders.php">Back to Orders</a></p>
</div>

</body>
</html>
