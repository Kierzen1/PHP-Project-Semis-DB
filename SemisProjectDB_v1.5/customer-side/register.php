<!-- register.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Register</title>
</head>
<body>
    <header>
        <h1>Register</h1>
    </header>

    <div class="container">
        <?php
        include 'db.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $c_name = $_POST['c_name'];
            $c_email = $_POST['c_email'];
            $c_address = $_POST['c_address'];

            $sql = "INSERT INTO customer (c_name, c_email, c_address) VALUES ('$c_name', '$c_email', '$c_address')";
            
            if ($conn->query($sql) === TRUE) {
                echo "Registration successful. <a href='login.php'>Login</a>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        ?>

        <form method="post" action="register.php">
            <label for="c_name">Name:</label>
            <input type="text" name="c_name" required>

            <label for="c_email">Email:</label>
            <input type="email" name="c_email" required>

            <label for="c_address">Address:</label>
            <input type="text" name="c_address" required>

            <input type="submit" value="Register">
        </form>
    </div>
</body>
</html>
