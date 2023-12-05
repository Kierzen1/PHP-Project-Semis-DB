<?php
include 'db.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['c_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Fetch orders for the current user
$customer_id = $_SESSION['c_id'];
$orders_query = "SELECT * FROM orders WHERE c_id = ?";
$orders_stmt = $conn->prepare($orders_query);
$orders_stmt->bind_param('i', $customer_id);
$orders_stmt->execute();
$orders_result = $orders_stmt->get_result();
$orders_stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://fonts.googleapis.com/css?family=Kanit' rel='stylesheet'>
    <title>My Orders</title>
    <style>
        /* Add any styles you may need for the orders page */
        /* For simplicity, you can use a basic table layout */
		body {
            font-family: 'Kanit';
            margin: 0;
            padding: 0;
            background-color: #FFF2D8;
         
        }
        table {
            width: 80%;
            margin: 20px auto;
			border-radius: 7px;
        }
		h2{
			text-align:center;
		}
        table, th, td {
            border: 1px outset #ddd;
            padding: 5px;
            text-align: left;
			border: 2px outset #EAD7BB;
        }

        th {
           background-color: #EAD7BB;
        }
		.navbar {
            background-color: #BCA37F;
            overflow: hidden;
        }

        .navbar a {
            float: left;
            display: block;
            color: black;
            text-align: center;
            padding: 7px 20px;
            text-decoration: none;
        }

        .navbar a:hover {
            background-color: #113946;
            color: white;
        }
		
    </style>
</head>
<body>
<div class="navbar">
    <a href="index.php">Home</a>
    <?php
    if (isset($_SESSION['c_id'])) {
        echo '<a href="viewcart.php">Cart</a>';
        echo '<a href="orders.php">Orders</a>';
        
    }
    ?>
	<form method="post" action="logout.php">
        <button class="logout" type="submit" style="margin:10px 8px 10px 1200px;">Log Out</button>
    </form>
</div>
<div class="orders-container">
    <h2>Orders</h2>

    <?php
    if ($orders_result->num_rows === 0) {
        echo '<p>No orders found.</p>';
    } else {
        echo '<table>';
        echo '<tr>';
        
        echo '<th>Date Ordered</th>';
        echo '<th>Shipping Address</th>';
        echo '<th>Book Title</th>';
        echo '<th>Quantity</th>';
        echo '<th>Total Cost</th>';
        echo '<th>Status</th>';
        echo '</tr>';

        while ($order = $orders_result->fetch_assoc()) {
            $firstRow = true;

            // Fetch order details including quantity and book title
            $order_details_query = "SELECT items.title, orderdetails.qty, items.price
                                    FROM orderdetails
                                    JOIN items ON orderdetails.i_id = items.i_id
                                    WHERE orderdetails.o_id = ?";
            $order_details_stmt = $conn->prepare($order_details_query);
            $order_details_stmt->bind_param('i', $order['o_id']);
            $order_details_stmt->execute();
            $order_details_result = $order_details_stmt->get_result();

            // Iterate through order details
            while ($order_detail = $order_details_result->fetch_assoc()) {
                if ($firstRow) {
                    echo '<tr>';
                    echo '<td rowspan="' . $order_details_result->num_rows . '">' . $order['o_date'] . '</td>';
                    echo '<td rowspan="' . $order_details_result->num_rows . '">' . $order['shipping_address'] . '</td>';
                    $firstRow = false;
                }
                echo '<td>' . $order_detail['title'] . '</td>';
                echo '<td>' . $order_detail['qty'] . '</td>';
                echo '<td>$' . number_format($order_detail['price'] * $order_detail['qty'], 2) . '</td>';
                if ($firstRow) {
                    echo '<td rowspan="' . $order_details_result->num_rows . '"> Completed </td>';
                }
				echo '<td> To ship </td>';
                echo '</tr>';
            }

            $order_details_stmt->close();
        }

        echo '</table>';
    }
    ?>

</div>

</body>
</html>
