<!-- viewcart.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>View Cart</title>
</head>
<body>
    <header>
        <h1>Shopping Cart</h1>
    </header>

    <div class="container">
        <?php
        session_start();

        include 'db.php';

        if (isset($_POST['buy_now'])) {
            // Process the order and generate a receipt
            // Implement your order processing logic here
            // ...

            // Clear the cart after processing the order
            unset($_SESSION['cart']);
            echo "<p class='cart-item'>Order placed successfully. Receipt generated.</p>";
        }

        if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
            echo "<div class='cart-container'>";

            foreach ($_SESSION['cart'] as $key => $item) {
                $quantity = $item['quantity'] ?? 1; // Default to 1 if quantity not set
                $total = $item['price'] * $quantity;

                echo "<div class='cart-item'>
                        <p>{$item['title']} by {$item['author']} - \${$item['price']} each</p>
                        <p>Quantity: $quantity</p>
                        <p>Total: \$$total</p>
                        <form method='post' action='viewcart.php'>
                            <input type='hidden' name='delete_item' value='$key'>
                            <input type='submit' name='delete_btn' class='delete-btn' value='Delete'>
                        </form>
                      </div>";
            }

            echo "<form method='post' action='viewcart.php'>
                    <input type='submit' name='buy_now' class='buy-now-btn' value='Buy Now'>
                  </form>";
            echo "</div>";
        } else {
            echo "<p class='cart-item'>Your cart is empty.</p>";
        }

        // Handle item deletion
        if (isset($_POST['delete_item']) && isset($_SESSION['cart'][$_POST['delete_item']])) {
            unset($_SESSION['cart'][$_POST['delete_item']]);
            $_SESSION['cart'] = array_values($_SESSION['cart']); // Re-index the array
         
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
