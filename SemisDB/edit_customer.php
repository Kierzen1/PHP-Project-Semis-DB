<?php
$conn = new mysqli("localhost", "root", "", "dbmsproject");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $c_id = $_GET['id'];
    $sql = "SELECT * FROM customer WHERE c_id = $c_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "No customer found with this ID.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Customer - Online Bookstore</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .navbar {
            background-color: #333;
            overflow: hidden;
        }

        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }

        h1 {
            text-align: center;
            padding: 30px 0;
            color: #333;
        }

        form {
            width: 50%;
            margin: 20px auto;
        }

        input[type="text"], input[type="submit"] {
            padding: 8px;
            width: 100%;
            margin: 5px 0;
        }

        input[type="submit"] {
            background-color: #333;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="index.php">Home</a>
        <a href="customers.php">Customers</a>
        <a href="items.php">Items</a>
    </div>
    <h1>Edit Customer</h1>

    <form method="post" action="update_customer.php">
        <input type="hidden" name="id" value="<?php echo $row['c_id']; ?>">
        Name: <input type="text" name="name" value="<?php echo $row['c_name']; ?>">
        Email: <input type="text" name="email" value="<?php echo $row['c_email']; ?>">
        Address: <input type="text" name="address" value="<?php echo $row['c_address']; ?>">
        <input type="submit" value="Update">
    </form>
</body>
</html>
