<?php
$conn = new mysqli("localhost", "root", "", "dbmsproject");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle customer insertion, deletion, and editing (code for these operations)

// Retrieve customer data
$sql = "SELECT * FROM customer";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Customers - Online Bookstore</title>
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

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: white;
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
    <h1>Manage Customers</h1>

    <!-- Customer List -->
    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Address</th>
            <th>Actions</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["c_name"] . "</td>";
                echo "<td>" . $row["c_email"] . "</td>";
                echo "<td>" . $row["c_address"] . "</td>";
                echo "<td>";
                echo "<button><a href='edit_customer.php?id=" . $row["c_id"] . "'>Edit</a></button>";
                echo "<form method='post' action='delete_customer.php'>
                    <input type='hidden' name='id' value='" . $row["c_id"] . "'>
                    <input type='submit' value='Delete'>
                </form>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No customers found</td></tr>";
        }
        ?>
    </table>

    <!-- Customer Insertion Form -->
    <form method="post" action="insert_customer.php">
        <h2 style="text-align: center;">Insert Customer Information</h2>
        <input type="text" name="name" placeholder="Name">
        <input type="text" name="email" placeholder="Email">
        <input type="text" name="address" placeholder="Address">
        <input type="submit" value="Insert">
    </form>
</body>
</html>
