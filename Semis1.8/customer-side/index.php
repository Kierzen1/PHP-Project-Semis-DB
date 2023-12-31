<?php
include 'db.php';
session_start();

// Check if the user is logged in
if (isset($_SESSION['c_id'])) {
    $welcome_message = "Welcome, " . $_SESSION['c_name'] . "!";
} else {
    $welcome_message = "Welcome to our online store!";
}

// Fetch and display items from the Items table
$item_query = "SELECT * FROM Items";
$item_result = $conn->query($item_query);
$items = $item_result->fetch_all(MYSQLI_ASSOC);

// Handle adding items to the cart
if (isset($_POST['add_to_cart']) && isset($_SESSION['c_id'])) {
    $item_id = mysqli_real_escape_string($conn, $_POST['item_id']);
    $cart_id = $_SESSION['c_id'];

    // Check if the item is already in the cart
    $check_cart_query = "SELECT * FROM Cart WHERE c_id = $cart_id AND item_id = $item_id";
    $check_cart_result = $conn->query($check_cart_query);

    if ($check_cart_result->num_rows == 0) {
        // Item is not in the cart, add it
        $add_to_cart_query = "INSERT INTO Cart (c_id, item_id) VALUES ($cart_id, $item_id)";
        $conn->query($add_to_cart_query);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Store</title>
    <style>
        /* Styles remain unchanged */
		body {
			background-color: #F1BF98;
		}
        .item {
			text-align: center;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 20px;
            background-color: #E1F4CB	;
			width: 60%;
			margin: 20px auto;
        }

        .item img {
            max-width: 100%;
            height: auto;
        }

        .add-to-cart {
            background-color: #4caf50;
            color: #fff;
            padding: 5px 10px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
        }
		form {
			text-align: right;
		}
		p{
			text-align: center;
		}
    </style>
</head>
<body>

<div class="container">
    <h2 style="margin-left:89%"><?php echo $welcome_message; ?></h2>
	<form method="post" action="logout.php">
        <button class="logout" type="submit" style="margin-right:50px;">Log Out</button>
    </form>
	
    <?php
    if (isset($_SESSION['c_id'])) {
        echo '<button onclick="location.href=\'viewcart.php\'" style="margin-left: 100px;">View Cart</button>';
		echo '<button onclick="location.href=\'orderdetails.php\'" style="margin-left: 20px;">View Order</button>';
    }
    ?>
	<br>
	<br>
	
	
    <p style="font-size:2em;">Your online shopping destination for books and more!</p>

    <?php
    // Display items and "Add to Cart" buttons
    foreach ($items as $item) {
        echo '<div class="item">';
        echo '<h3>' . $item['title'] . '</h3>';
        echo '<p>Author: ' . $item['author'] . '</p>';
        echo '<p>Genre: ' . $item['genre'] . '</p>';
        echo '<p>Price: $' . $item['price'] . '</p>';
        
        // Add to Cart button
        echo '<form method="post" action=""><input type="hidden" name="item_id" value="' . $item['i_id'] . '"><button class="add-to-cart" type="submit" name="add_to_cart">Add to Cart</button></form>';
        
        echo '</div>';
    }
    ?>
	

</div>

</body>
</html>
