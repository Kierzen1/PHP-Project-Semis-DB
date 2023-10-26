<?php
$conn = new mysqli("localhost", "root", "", "bookstore");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle customer insertion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'insert') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $address = $_POST['address'];

        $sql = "INSERT INTO customers (name, email, address) VALUES ('$name', '$email', '$address')";
        if ($conn->query($sql) === TRUE) {
            echo "Customer information inserted successfully.";
        } else {
            echo "Error: " . $conn->error;
        }
    }

    // Handle customer deletion
    if ($_POST['action'] == 'delete') {
        $id = $_POST['id'];

        $sql = "DELETE FROM customers WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            echo "Customer information deleted successfully.";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

// Retrieve customer data
$sql = "SELECT * FROM customers";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Online Bookstore</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            color: #333;
            text-align: center;
        }

        h2 {
            color: #333;
        }

        form {
            margin: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: white;
        }
    </style>
</head>
<body>
    <h1>Online Bookstore</h1>

    <!-- Customer Insertion Form -->
    <h2>Insert Customer Information</h2>
    <form method="post" action="">
        <input type="hidden" name="action" value="insert">
        Name: <input type="text" name="name"><br>
        Email: <input type="text" name="email"><br>
        Address: <textarea name="address"></textarea><br>
        <input type="submit" value="Insert">
    </form>

    <!-- Customer Deletion Form -->
    <h2>Delete Customer Information</h2>
    <form method="post" action="">
        <input type="hidden" name="action" value="delete">
        Customer ID: <input type="text" name="id"><br>
        <input type="submit" value="Delete">
    </form>

    <!-- Customer List -->
    <h2>Customer List</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Address</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["address"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No customers found</td></tr>";
        }
        ?>
    </table>
</body>
</html>
	
