<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    $conn = new mysqli("localhost", "root", "", "bookstore");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO customers (name, email, address) VALUES ('$name', '$email', '$address')";
    if ($conn->query($sql) === TRUE) {
        echo "Customer information inserted successfully.";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Insert Customer Information</title>
</head>
<body>
    <h1>Insert Customer Information</h1>
    <form method="post" action="insert.php">
        Name: <input type="text" name="name"><br>
        Email: <input type="text" name="email"><br>
        Address: <textarea name="address"></textarea><br>
        <input type="submit" value="Insert">
    </form>
</body>
</html>
