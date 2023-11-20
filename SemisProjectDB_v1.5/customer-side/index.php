<!-- index.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Online Bookstore</title>
</head>
<body>
    <header>
        <h1>Welcome to the Online Bookstore</h1>
        <?php
        session_start();
        if (isset($_SESSION['c_id'])) {
            echo "<p>Hello, Customer!</p><a href='logout.php' class = 'cart'>Logout</a>";
        } else {
            echo "<a href='login.php' class = 'cart'>Login</a> | <a href='register.php' class = 'cart'>Register</a>";
        }
        ?>
    </header>

    <div class="container">
        <?php
        include 'db.php';

        $sql = "SELECT * FROM Items";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='book'>
                        <p>{$row['title']} by {$row['author']} - \${$row['price']}</p>
                        <form action='cart.php' method='post'> <!-- Change method to post -->
                            <input type='number' name='quantity' value='1' min='1' max='10'>
                            <input type='hidden' name='action' value='add'>
                            <input type='hidden' name='id' value='{$row['i_id']}'>
                            <button type='submit' class='cart'>Add to Cart</button>
                        </form>
                      </div>";
            }

            // Add a button to view the cart
            echo "<div class='view-cart-btn-container'>
                    <a href='viewcart.php' class='cart'>View Cart</a>
                  </div>";
        } else {
            echo "No books available.";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
