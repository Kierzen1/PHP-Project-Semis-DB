<?php
$conn = new mysqli("localhost", "root", "", "semisproject");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"])) {
    if ($_POST["action"] == "insert") {
        $c_name = $_POST["name"];
        $c_email = $_POST["email"];
        $c_address = $_POST["address"];

        $stmt = $conn->prepare(
            "INSERT INTO customers  (c_name, c_email, c_address, c_status) VALUES (?, ?, ?, 'active')"
        );
        $stmt->bind_param("sss", $c_name, $c_email, $c_address);

        if ($stmt->execute()) {
            echo "";
        } else {
            echo "Error: " . $conn->error;
        }
    }

    if ($_POST["action"] == "delete") {
        $c_id = $_POST["id"];

        $stmt = $conn->prepare("DELETE FROM customers WHERE c_id = ?");
        $stmt->bind_param("i", $c_id);

        if ($stmt->execute()) {
            echo "";
        } else {
            echo "Error: " . $conn->error;
        }
    }

    if (
        $_POST["action"] == "edit" &&
        isset($_POST["id"]) &&
        isset($_POST["name"]) &&
        isset($_POST["email"]) &&
        isset($_POST["address"])
    ) {
        $c_id = $_POST["id"];
        $c_name = $_POST["name"];
        $c_email = $_POST["email"];
        $c_address = $_POST["address"];
        $c_status = $_POST["status"];

        $stmt = $conn->prepare(
            "UPDATE customers SET c_name = ?, c_email = ?, c_address = ?, c_status = ? WHERE c_id = ?"
        );
        $stmt->bind_param(
            "ssssi",
            $c_name,
            $c_email,
            $c_address,
            $c_status,
            $c_id
        );

        if ($stmt->execute()) {
            echo "";
        } else {
            echo "Error: " . $conn->error;
        }
        $search = "";
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["search"])) {
            $search = $_GET["search"];
            $sql = "SELECT * FROM customers WHERE c_name LIKE '%$search%'";
        } else {
            $sql = "SELECT * FROM customers";
        }

        $result = $conn->query($sql);
    }
}

// Retrieve customer data
$sql = "SELECT * FROM customers";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Management</title>
</head>
<style>
    body 
        {
            font-family: monospace;
            margin: 0;
            padding: 0;
            background-color: #FFF2D8;
            font-size: 18px;
        }
    .navbar 
        {
            background-color: #BCA37F;
            overflow: hidden;
        }

    .navbar a 
        {
        float: left;
        display: block;
        color: black;
        text-align: center;
        padding: 7px 20px;
        text-decoration: none;
        }
    .navbar a:hover 
        {
        background-color: #113946;
        color: white;
        }
    .forminfo{
        width: 240px;
            margin: 0px auto;
            padding: 10px;
            border-radius: 5px 5px 5px 5px; 
            background-color: #EAD7BB;
            text-align: center;
    }
    .form1 {
            width: 350px;
            margin: 8px auto;
            padding: 0%;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #EAD7BB;
            text-align: center;
        }
    .formsearch
    {
         width: 250px;
            margin: 0px auto;
            padding: 10px;
            border-radius: 5px 5px 0px 0px; 
            background-color: #EAD7BB;
    }
    .formshow
    {
        width: 260px;
            margin: 0px auto;
            padding: 5px;
            border-radius: 0px 0px 5px 5px;
            background-color: #EAD7BB;
            text-align: center;
    }
    .formdelete
     {
        width: 50%;
        margin: 10px auto;
        padding: 10px;
        border-radius: 5px;
        font-family: monospace;
        }
    .formedit
    {
        width: 80%;
        margin: 20px auto;
        text-align: center;
        padding: 2px;
        }
    .edit-form 
        {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #f9f9f9;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 10px;
        z-index: 999;
        opacity: 0; 
        transition: opacity 0.5s;
        }
        table {
            width: 90%;
            margin: 10px auto;
            border-style: groove;
        }
        table, th, td {
            border: 1px solid #EAD7BB;
        }
        th {
            padding: 6px;
            background-color: #EAD7BB;
            color: black;
        }
        form input[type="text"] {
        width: 220px; 
        padding: 2px;
        margin: 3px 0;
        font-family: monospace;
    }
</style>
<body style="margin: 0;">
	<div class="navbar">
        <a href="home.php">Home</a>
        <a href="customer.php">Customers</a>
        <a href="items.php">Items</a>
    </div>
    <div class="form1">
        <h2>Customer List</h2>
        
        </form>
    </div>
	 <form class = "formsearch" method="get" action="">
            <input name="search" placeholder="Search by name">
            <input type="submit" value="Search" style = 'font-family: monospace;'>
        </form>
		
	<form class = "formshow"method="get" action="">
            <input type="submit" name="showAll" value="Show All" style = 'font-family: monospace;'>
        </form>
    <!-- Customer List -->
<table>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Address</th>
        <th>Status</th>
    </tr>
	<?php
 $search = "";
 if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["search"])) {
     $search = $_GET["search"];
     $sql = "SELECT * FROM customers WHERE c_name = '$search'";
 } else {
     $sql = "SELECT * FROM customers";
 }

 $result = $conn->query($sql);
 ?>
    <?php if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["c_name"] . "</td>";
            echo "<td>" . $row["c_email"] . "</td>";
            echo "<td>" . $row["c_address"] . "</td>";
            echo "<td>" . $row["c_status"] . "</td>";
            echo "<td>";
            // Edit button that opens the modal
            echo "<button class = 'formedit'onclick='toggleEditForm(" .
                $row["c_id"] .
                ")' style='font-family: monospace;'>Edit</button>";
            echo "</td>";
            echo "<td style='padding-left: 5px;'>"; // Adding a small left padding for a space
            // Delete button and form
            echo "<form class='formdelete' method='post' action='' style='display: inline;>
					<input type='hidden' name='action' value='delete'>
					<input type='hidden' name='id' value='" .
								$row["c_id"] .
								"'>
					<input type='submit' value='Delete'  style='font-family: monospace;'>
				</form>";
            echo "</td>";
            echo "</tr>";

            // editing form
            echo "<div id='editForm" . $row["c_id"] . "' class='edit-form'>";
            echo "<span class='close' onclick='closeEditForm(" .
                $row["c_id"] .
                ")'>&times;</span>";
            echo "<form method='post' action=''>";
            echo "<input type='hidden' name='action' value='edit'>";
            echo "<input type='hidden' name='id' value='" . $row["c_id"] . "'>";
            echo "Name: <input type='text' name='name' value='" .
                $row["c_name"] .
                "'><br>";
            echo "Email: <input type='text' name='email' value='" .
                $row["c_email"] .
                "'><br>";
            echo "Address: <input type='text' name='address' value='" .
                $row["c_address"] .
                "'><br>";
            echo "Status: <input type='text' name='status' value='" .
                $row["c_status"] .
                "'><br>";
            echo "<input type='submit' value='Save'>";
            echo "</form>";
            echo "</div>";
        }
    } else {
        echo "<tr><td colspan='5'>No customers found</td></tr>";
    } ?>
</table>

    <!-- Customer Insertion Form -->
	
    <form class = "forminfo "method="post" action="">
    <h4>Add Customer</h4>
        <input type="hidden" name="action" value="insert">
         <input type="text" name="name" placeholder="Name:"><br>
         <input type="text" name="email" placeholder="Email:"><br>
        <input type="text" name="address" placeholder="Address:"><br>
        <input type="submit" value="Add" style = 'font-family: monospace;'>
    </form>
    <script>
    function toggleEditForm(id) {
        var editForm = document.getElementById('editForm' + id);
        if (editForm.style.display === 'block') {
            editForm.style.opacity = 0; 
            setTimeout(function() {
                editForm.style.display = 'none';
            }, 500); 
        } else {
            editForm.style.display = 'block';
            setTimeout(function() {
                editForm.style.opacity = 1; 
            }, 50); 
        }
    }

    function closeEditForm(id) {
        var editForm = document.getElementById('editForm' + id);
        editForm.style.opacity = 0; 
        setTimeout(function() {
            editForm.style.display = 'none';
        }, 500);
    }</script>
</body>
</html>