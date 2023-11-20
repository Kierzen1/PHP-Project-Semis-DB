<!-- login.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Login</title>
</head>
<body>
    <header>
        <h1>Login</h1>
    </header>

    <div class="container">
        <?php
        include 'db.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $c_email = $_POST['c_email'];

            $sql = "SELECT * FROM customers WHERE c_email = '$c_email'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                session_start();
                $_SESSION['c_id'] = $row['c_id']; // Set the customer ID in the session
                echo "Login successful. <a href='index.php'>Continue shopping</a>";
            } else {
                echo "Invalid email. <a href='login.php'>Try again</a>";
            }
        }
        ?>

        <form method="post" action="login.php">
            <label for="c_email">Email:</label>
            <input type="email" name="c_email" required>

            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>
