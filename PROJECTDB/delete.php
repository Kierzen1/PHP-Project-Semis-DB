<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    $conn = new mysqli("localhost", "root", "", "bookstore");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "DELETE FROM customers WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "Customer information deleted successfully.";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Customer Information</title>
</head>
<body>
    <h1>Delete Customer Information</h1>
    <form method="post" action="delete.php">
        Customer ID: <input type="text" name="id"><br>
        <input type="submit" value="Delete">
    </form>
</body>
</html>
