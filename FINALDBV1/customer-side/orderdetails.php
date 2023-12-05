<?php
include 'db.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['c_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Fetch the latest order for the user
$c_id = $_SESSION['c_id'];
$order_query = "SELECT Orders.*, OrderDetails.*, Items.* FROM Orders
                JOIN OrderDetails ON Orders.o_id = OrderDetails.o_id
                JOIN Items ON OrderDetails.i_id = Items.i_id
                WHERE Orders.c_id = $c_id
                ORDER BY Orders.o_id DESC
                LIMIT 1";
$order_result = $conn->query($order_query);
$order_details = $order_result->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <style>
        /* Styles remain unchanged */

        .order-details-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .order-item {
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 20px;
            padding: 10px;
        }

        .order-item img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>

<div class="order-details-container">
    <h2>Order Details</h2>

    <?php
    if (empty($order_details)) {
        echo '<p>No order details available.</p>';
    } else {
        foreach ($order_details as $order_item) {
            echo '<div class="order-item">';
            echo '<h3>' . $order_item['title'] . '</h3>';
            echo '<p>Author: ' . $order_item['author'] . '</p>';
            echo '<p>Genre: ' . $order_item['genre'] . '</p>';
            echo '<p>Price: $' . $order_item['price'] . '</p>';
            echo '<p>Quantity: ' . $order_item['qty'] . '</p>';
            echo '<img src="path/to/your/images/' . $order_item['i_id'] . '.jpg" alt="' . $order_item['title'] . '">';
            echo '</div>';
        }

        // Display the shipping address and total cost
        echo '<p>Shipping Address: ' . $order_details[0]['shipping_address'] . '</p>';
        echo '<p>Total Cost: $' . number_format($order_details[0]['total_cost'], 2) . '</p>';
    }
    ?>

    <p><a href="index.php">Back to Home</a></p>
</div>

</body>
</html>
