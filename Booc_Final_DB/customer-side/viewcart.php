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
$cart_query = "SELECT Items.*, Cart.cart_id, Cart.item_id FROM Items JOIN Cart ON Items.i_id = Cart.item_id WHERE Cart.cart_id = $cart_id";
$cart_result = $conn->query($cart_query);
$cart_items = $cart_result->fetch_all(MYSQLI_ASSOC);

if (isset($_POST['remove_from_cart'])) {
    $cart_id_to_remove = mysqli_real_escape_string($conn, $_POST['cart_id']);
    $item_id_to_remove = mysqli_real_escape_string($conn, $_POST['item_id']);

    // Use prepared statement to prevent SQL injection
    $remove_query = "DELETE FROM Cart WHERE cart_id = ? AND item_id = ?";
    $remove_stmt = $conn->prepare($remove_query);
    $remove_stmt->bind_param('ii', $cart_id_to_remove, $item_id_to_remove);
    
    // Execute the prepared statement
    $remove_stmt->execute();

    // Close the prepared statement
    $remove_stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://fonts.googleapis.com/css?family=Kanit' rel='stylesheet'>
    <title>View Cart</title>
    <style>
        /* Styles remain unchanged */	
		
		body {
            font-family: 'Kanit';
            margin: 0;
            padding: 0;
            background-color: #FFF2D8;
         
        }
        .cart-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color:#CFA983;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .cart-item {
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 20px;
            padding: 10px;
			background-color: #EAD7BB;
        }

        .cart-item img {
            max-width: 100%;
            height: auto;
        }

        .remove-from-cart {
            background-color: #e53935;
            color: #fff;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
		
		h3{
			text-align:center;
		}
        h2 {
            color: #333;
            text-align: center;
        }

        p {
            text-align: center;
            color: #555;
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
        <button class="logout" type="submit" style="margin:10px 8px 10px 900px;">Log Out</button>
    </form>
</div>
<div class="cart-container">
    <h2>Shopping Cart</h2>

    <?php
    if (empty($cart_items)) {
        echo '<p>Your cart is empty. <a href="index.php">Continue shopping</a></p>';
    } else {
        foreach ($cart_items as $cart_item) {
            echo '<div class="cart-item">';
            echo '<h3>' . $cart_item['title'] . '</h3>';
			echo '<img src="download.jpg" alt="Description of the image" style="margin-left:240px">';
			echo '<p>ISBN: ' . $cart_item['isbn'] . '</p>';
            echo '<p>Author: ' . $cart_item['author'] . '</p>';
            echo '<p>Genre: ' . $cart_item['genre'] . '</p>';
            echo '<p>Price: $' . $cart_item['price'] . '</p>';

            // Remove from Cart button
            echo '<form method="post" action=""><input type="hidden" name="cart_id" value="' . $cart_item['cart_id'] . '">';
            echo '<input type="hidden" name="item_id" value="' . $cart_item['item_id'] . '">';
            echo '<button class="remove-from-cart" type="submit" name="remove_from_cart">Remove from Cart</button></form>';

            echo '</div>';
        }

        // Proceed to Checkout button
        echo '<button onclick="location.href=\'checkout.php\'">Proceed to Checkout</button>';
    }
    ?>

</div>

</body>
</html>
