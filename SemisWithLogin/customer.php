<?php
$conn = new mysqli("localhost", "root", "", "dbmsproject");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle customer insertion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'insert') {
        $c_name = $_POST['name'];
        $c_email = $_POST['email'];
        $c_address = $_POST['address'];

        $stmt = $conn->prepare("INSERT INTO customer  (c_name, c_email, c_address) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $c_name, $c_email, $c_address);

        if ($stmt->execute()) {
            echo "";
        } else {
            echo "Error: " . $conn->error;
        }
    }

    // Handle customer deletion
    if ($_POST['action'] == 'delete') {
        $c_id = $_POST['id'];

        $stmt = $conn->prepare("DELETE FROM customer WHERE c_id = ?");
        $stmt->bind_param("i", $c_id);

        if ($stmt->execute()) {
            echo "";
        } else {
            echo "Error: " . $conn->error;
        }
    }

    // Handle customer editing
    if ($_POST['action'] == 'edit' && isset($_POST['id']) && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['address'])) {
		$c_id = $_POST['id'];
		$c_name = $_POST['name'];
		$c_email = $_POST['email'];
		$c_address = $_POST['address'];

		$stmt = $conn->prepare("UPDATE customer SET c_name = ?, c_email = ?, c_address = ? WHERE c_id = ?");
		$stmt->bind_param("sssi", $c_name, $c_email, $c_address, $c_id);

		if ($stmt->execute()) {
			echo "";
		} else {
			echo "Error: " . $conn->error;
		}
	}
}

// Retrieve customer data
$sql = "SELECT * FROM customer";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
			background-color: #FFF2D8; 
        }
		.navbar {
            background-color: #BCA37F;
            overflow: hidden;
        }

        .navbar a {
            float: left;
            display: block;
            color: black;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }

        .navbar a:hover {
            background-color: black;
            color: white;
        }
		
        h1 {
            color: #333;
            text-align: center;
        }

        h2 {
            color: #333;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
        }

        .modal-content {
            background-color: #f9f9f9;
            width: 50%;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        
		form, .form1 {
            width: 50%;
            margin: 20px auto;
            padding: 25px;
            border: 2px solid #ccc;
            border-radius: 5px;
            background-color: #EAD7BB;
        }
		 .form2 {
			width: 50%;
			margin: 20px auto;
			padding: 25px;
			border: 2px solid #ccc;
			border-radius: 5px;
			background-color: #EAD7BB;
			animation-name: slideIn;
			animation-duration: 1s;
			}

		@keyframes slideIn {
			from {
				margin-top: -100px;
				opacity: 0;
			}
			to {
				margin-top: 20px;
				opacity: 1;
			}
		}
		.form3 {
			width: 20%;
            margin: 20px auto;
            padding: 20px;
            border: 2px solid #ccc;
            border-radius: 5px;
            background-color: #EAD7BB;
			text-align: center;
			display: center;
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

        /* Add a bit of margin between the forms and the table */
        form, table {
            margin-top: 20px;
        }

        /* Style the close button for the modal */
        .close {
            float: right;
            cursor: pointer;
        }

        /* Wider input fields */
        input[type="text"] {
            width: 90%; /* Make the inputs take the full width */
            padding: 5px;
            margin: 5px 0;
        }
		.edit-form {
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
        opacity: 0; /* Initially set opacity to 0 */
        transition: opacity 0.5s; /* Add a transition for the opacity change */
    }
		 input[type="submit"] {
            padding: 12px; /* Increase the button's padding */
            width: 101%; /* Set button width to 10% */
            margin-top: 10px; /* Add some top margin */
        }
		
    </style>
       <script>
    // JavaScript functions
    function toggleEditForm(id) {
        var editForm = document.getElementById('editForm' + id);
        if (editForm.style.display === 'block') {
            editForm.style.opacity = 0; // Fading out
            setTimeout(function() {
                editForm.style.display = 'none';
            }, 500); // Hide the form after 0.5 seconds (synced with the transition duration)
        } else {
            editForm.style.display = 'block';
            setTimeout(function() {
                editForm.style.opacity = 1; // Fading in after displaying
            }, 50); // Delay the fade-in to ensure display change is handled first
        }
    }

    function closeEditForm(id) {
        var editForm = document.getElementById('editForm' + id);
        editForm.style.opacity = 0; // Fading out
        setTimeout(function() {
            editForm.style.display = 'none';
        }, 500); // Hide the form after 0.5 seconds (synced with the transition duration)
    }
</script>

</head>
<body style="margin: 0;">
	<div class="navbar">
        <a href="home.php">Home</a>
        <a href="customer.php">Customers</a>
        <a href="items.php">Items</a>
    </div>
	<div class="form1">
        <h1>Customer List</h1>
    </div>
    <!-- Customer List -->
    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Address</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["c_name"] . "</td>";
                echo "<td>" . $row["c_email"] . "</td>";
                echo "<td>" . $row["c_address"] . "</td>";
                echo "<td>";
                // Edit button that opens the modal
                echo "<button onclick='toggleEditForm(" . $row["c_id"] . ")'>Edit</button>";
                // Delete button and form
                echo "<form class= 'form3' method='post' action=''>
                    <input type='hidden' name='action' value='delete'>
                    <input type='hidden' name='id' value='" . $row["c_id"] . "'>
                    <input type='submit' value='Delete'>
                </form>";
                echo "</td>";
                echo "</tr>";

                // Modal for editing
                echo "<div id='editForm" . $row["c_id"] . "' class='edit-form'>";
				echo "<span class='close' onclick='closeEditForm(" . $row["c_id"] . ")'>&times;</span>";
				echo "<form method='post' action=''>";
				echo "<input type='hidden' name='action' value='edit'>";
				echo "<input type='hidden' name='id' value='" . $row["c_id"] . "'>";
				echo "Name: <input type='text' name='name' value='" . $row["c_name"] . "'><br>";
				echo "Email: <input type='text' name='email' value='" . $row["c_email"] . "'><br>";
				echo "Address: <input type='text' name='address' value='" . $row["c_address"] . "'><br>";
				echo "<input type='submit' value='Save'>";
				echo "</form>";
				echo "</div>";
            }
        } else {
            echo "<tr><td colspan='4'>No customers found</td></tr>";
        }
        ?>
    </table>

    <!-- Customer Insertion Form -->
	<div class="form2">
    <h2>Insert Customer Information</h2>
		 </div>
    <form method="post" action="">
        <input type="hidden" name="action" value="insert">
         <input type="text" name="name" placeholder="Name:"style="width: 100%; padding: 4px;">
         <input type="text" name="email" placeholder="Email:"style="width: 100%; padding: 5px;">
        <input type="text" name="address" placeholder="Address:" style="width: 100%; padding: 5px;">
        <input type="submit" value="Insert">
    </form>
</body>
</html>

