<?php
session_start();

include 'db.php';

// Check if the customer is logged in
if (!isset($_SESSION['c_id'])) {
    echo "Error: Not logged in.";
    exit();
}

// Check if the necessary data is set
if (isset($_POST['action']) && $_POST['action'] == 'add' && isset($_POST['id'])) {
    $i_id = $_POST['id'];
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1;

    $sql = "SELECT * FROM Items WHERE i_id = $i_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (!isset($_SESSION['cart'])) {
            // Check if the customer has an existing cart in the database
            $cart_id = $_SESSION['c_id'];
            $checkCartQuery = "SELECT * FROM cart WHERE cart_id = '$cart_id'";
            $checkResult = $conn->query($checkCartQuery);

            if ($checkResult->num_rows === 0) {
                // If the customer doesn't have an existing cart, create a new one
                $date_created = date("Y-m-d");
                $insertCartQuery = "INSERT INTO cart (cart_id, date_created, c_id) VALUES ('$cart_id', '$date_created', '$cart_id')";
                $conn->query($insertCartQuery);
            }

            $_SESSION['cart'] = [];
        }

        $item = [
            'i_id' => $row['i_id'],
            'title' => $row['title'],
            'author' => $row['author'],
            'price' => $row['price'],
            'quantity' => $quantity
        ];

        array_push($_SESSION['cart'], $item);

        echo "Item added to cart.";
    } else {
        echo "Invalid item.";
    }
} else {
    echo "Error: Missing required data.";
}

$conn->close();
?>
