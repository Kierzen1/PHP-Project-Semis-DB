<?php
$conn = new mysqli("localhost", "root", "", "dbmsproject");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'insert') {
        // Insert new item
        $isbn = $_POST['isbn'];
        $title = $_POST['title'];
        $author = $_POST['author'];
        $genre = $_POST['genre'];
		$booktype = $_POST['booktype'];
        $price = $_POST['price'];
        

        $stmt = $conn->prepare("INSERT INTO items (isbn, title, author, genre, booktype, price) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $isbn, $title, $author, $genre, $booktype, $price);

        if ($stmt->execute()) {
            echo "";
        } else {
            echo "Error: " . $conn->error;
        }
    }

    if ($_POST['action'] == 'delete') {
        // Delete item
        $i_id = $_POST['id'];

        $stmt = $conn->prepare("DELETE FROM items WHERE i_id = ?");
        $stmt->bind_param("i", $i_id);

        if ($stmt->execute()) {
            echo "";
        } else {
            echo "Error: " . $conn->error;
        }
    }

    if ($_POST['action'] == 'edit' && isset($_POST['id'])) {
        // Edit item
        $i_id = $_POST['id'];
        $isbn = $_POST['isbn'];
        $title = $_POST['title'];
        $author = $_POST['author'];
        $genre = $_POST['genre'];
		$booktype = $_POST['booktype'];
        $price = $_POST['price'];
        

        $stmt = $conn->prepare("UPDATE items SET isbn = ?, title = ?, author = ?, genre = ?, booktype = ?, price = ? WHERE i_id = ?");
        $stmt->bind_param("sssssii", $isbn, $title, $author, $genre, $booktype, $price, $i_id);

        if ($stmt->execute()) {
            echo "";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

$sql = "SELECT * FROM items";
$result = $conn->query($sql);
?>
<!-- Rest of your HTML and JavaScript remains unchanged -->


<!DOCTYPE html>
<html>
<head>
    <title>Item Management</title>
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
            padding: 10px 20px;
            text-decoration: none;
        }

        .navbar a:hover {
            background-color: #113946;
            color: white;
        }
		
        h2 {
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
			width: 30%;
            margin: 15px auto;
            padding: 10px;
            border-radius: 10px;
            background-color: #EAD7BB;
			text-align: center;
			display: left;
	
        }
		.forminfo{
			width: 20%;
            margin: 15px auto;
            padding: 20px;
            border: 2px solid #ccc;
            border-radius: 5px;
            background-color: #EAD7BB;
		}
	
		.form2{
			width: 25%;
            margin: 20px auto;
            padding: 25px;
            border: 2px solid #ccc;
            border-radius: 5px;
            background-color: #EAD7BB;
			text-align: center;
		}
		.form3 {
			width: 15%;
            margin: 20px auto;
            padding: 20px;
            border: 2px solid #ccc;
            border-radius: 5px;
            background-color: #EAD7BB;
			text-align: center;
			display: center;
		}
		

        table {
            width: 95%;
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
        }
		 input[type="submit"] {
            padding: 12px; /* Increase the button's padding */
            width: 101%; /* Set button width to 10% */
            margin-top: 10px; /* Add some top margin */
        }
		table button {
        width: 60px;
        padding: 6px;
        background-color: #113946;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        margin-right: 5px;
		}

		form.form3 {
			display: inline-block; /* Display forms in line with each other */
			margin: 0;
			padding: 10px;
		}

		form.form3 button {
			width: 60px;
			padding: 6px;
			background-color: #fa8f87;
			color: white;
			border: none;
			cursor: pointer;
			border-radius: 5px;
		}
		
    </style>
       <script>
        // JavaScript functions
        function toggleEditForm(id) {
            var editForm = document.getElementById('editForm' + id);
            editForm.style.display = 'block';
        }

        function closeEditForm(id) {
            var editForm = document.getElementById('editForm' + id);
            editForm.style.display = 'none';
        }
    </script>
</head>
<body style="margin: 0;">
	<div class="navbar">
        <a href="home.php"><b>Home</b></a>
        <a href="customer.php"><b>Customers</b></a>
        <a href="items.php"><b>Items</b></a>
    </div>
	<div class="form1">
        <h2>Item List</h2>
    </div>
    <!-- Customer List -->
    <table>
        <tr>
            <th>ISBN</th>
            <th>Title</th>
            <th>Author</th>
			<th>Genre</th>
			<th>Book Type</th>
            <th>Price</th>
           
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["isbn"] . "</td>";
                echo "<td>" . $row["title"] . "</td>";
                echo "<td>" . $row["author"] . "</td>";
                echo "<td>" . $row["genre"] . "</td>"; 
				echo "<td>" . $row["booktype"] . "</td>";
                echo "<td>" . $row["price"] . "</td>";
               
                echo "<td>";
                // Edit button that opens the modal
                echo "<button onclick='toggleEditForm(" . $row["i_id"] . ")'>Edit</button>";

                // Delete button and form
                echo "<form class='form3' method='post' action=''>
                    <input type='hidden' name='action' value='delete'>
                    <input type='hidden' name='id' value='" . $row["i_id"] . "'>
                    <button type='submit'>Delete</button>
                </form>";

                echo "</td>";
                echo "</tr>";

                // Modal for editing
                echo "<div id='editForm" . $row["i_id"] . "' class='edit-form'>";
				echo "<span class='close' onclick='closeEditForm(" . $row["i_id"] . ")'>&times;</span>";
				echo "<form method='post' action=''>";
				echo "<input type='hidden' name='action' value='edit'>";
				echo "<input type='hidden' name='id' value='" . $row["i_id"] . "'>";
				echo "ISBN: <input type='text' name='isbn' value='" . $row["isbn"] . "'><br>";
				echo "Title: <input type='text' name='title' value='" . $row["title"] . "'><br>";
				echo "Author: <input type='text' name='author' value='" . $row["author"] . "'><br>";
				echo "Genre: <input type='text' name='genre' value='" . $row["genre"] . "'><br>";
				echo "Booktype: <input type='text' name='booktype' value='" . $row["booktype"] . "'><br>";
				echo "Price: <input type='text' name='price' value='" . $row["price"] . "'><br>";
				
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
    <h3>Insert Customer Information</h3>
		 </div>
		 <div class = "forminfo">
    <form method="post" action="">
        <input type="hidden" name="action" value="insert">
        <input type="text" name="isbn" placeholder="ISBN:"style="width: 100%; padding: 1px;">
        <input type="text" name="title" placeholder="Title:"style="width: 100%; padding: 1px;">
        <input type="text" name="author" placeholder="Author:" style="width: 100%; padding: 1px;">
		<input type="text" name="genre" placeholder="Genre:"style="width: 100%; padding: 1px;">
		<input type="text" name="booktype" placeholder="Booktype:" style="width: 100%; padding: 1px;">
        <input type="text" name="price" placeholder="Price:" style="width: 100%; padding: 1px;">
        <input type="submit" value="Insert">
		</div>
    </form>
</body>
</html>

