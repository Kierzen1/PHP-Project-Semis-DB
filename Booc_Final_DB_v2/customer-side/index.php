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
    $check_cart_query = "SELECT * FROM Cart WHERE cart_id = ? AND item_id = ?";
    $check_cart_stmt = $conn->prepare($check_cart_query);
    $check_cart_stmt->bind_param('ii', $cart_id, $item_id);
    $check_cart_stmt->execute();
    $check_cart_result = $check_cart_stmt->get_result();

    if ($check_cart_result->num_rows == 0) {
        // Item is not in the cart, add it
        $add_to_cart_query = "INSERT INTO Cart (cart_id, item_id) VALUES (?, ?)";
        $add_to_cart_stmt = $conn->prepare($add_to_cart_query);
        $add_to_cart_stmt->bind_param('ii', $cart_id, $item_id);
        $add_to_cart_stmt->execute();
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://fonts.googleapis.com/css?family=Kanit' rel='stylesheet'>
    <title>Online Store</title>
    <style>
        /* Styles remain unchanged */
		body {
            font-family: 'Kanit';
            margin: 0;
            padding: 0;
            background-color: #FFF2D8;
         
        }
        .item {
			text-align: center;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 20px;
            background-color: #EAD7BB;
			width: 60%;
			margin: 20px auto;
        }

        .item img {
            max-width: 100%;
            height: auto;
        }

        .add-to-cart {
            background-color: #white;
            color: #black;
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
		img.logo {
            display: block;
            margin: 0 auto; /* Center the image */
            width: 300px; /* Set the width of the image */
            animation: fadeInImage 2s; /* Apply fade-in animation */
        }
		@keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes slideInFromLeft {
            from {
                margin-left: -100%;
                opacity: 0;
            }
            to {
                margin-left: 0;
                opacity: 1;
            }
        }

        @keyframes fadeInImage {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
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
        <button class="logout" type="submit" style="margin:10px 10px 10px 10px;">Log Out</button>
    </form>
    </div>

<div class="container">
	
    <h3 style="margin-left:10px"><?php echo $welcome_message; ?></h3>
	<p style="font-size:3em;">Explore our collection of books and much more.</p>
    <img class="logo" src="book-shop.png" alt="Bookstore Logo">
	
	
    
	
	
    
	<script>
    function showAlert() {
        alert('Item added to cart!');
    }
		window.onload = function () {
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
        }
</script>
    <?php
    // Display items and "Add to Cart" buttons
    foreach ($items as $item) {
        echo '<div class="item">';
        echo '<h3>' . $item['title'] . '</h3>';
		echo '<img src="download.jpg" alt="Description of the image">';
		echo '<p>ISBN: ' . $item['isbn'] . '</p>';
        echo '<p>Author: ' . $item['author'] . '</p>';
        echo '<p>Genre: ' . $item['genre'] . '</p>';
        echo '<p>Price: $' . $item['price'] . '</p>';
		echo '<p>Stocks left: ' . $item['stocks'] . '</p>';
        
        // Add to Cart button
        echo '<form method="post" action=""><input type="hidden" name="item_id" value="' . $item['i_id'] . '"><button class="add-to-cart" type="submit" name="add_to_cart" onclick="showAlert()">Add to Cart</button></form>';

        echo '</div>';
    }
    ?>
	

</div>

</body>
</html>
