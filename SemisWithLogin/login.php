<!DOCTYPE html>
<html>
<head>
    <title>Online Book Store</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #FFF2D8;
        }
        h1 {
            text-align: center;
            margin-top: 50px;
        }
        .container {
            width: 20%;
            margin: 0 auto;
            padding: 20px;
            background-color: #EAD7BB;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        form, a {
            margin-top: 20px;
			
        }
        form label {
            display: block;
            margin-bottom: 5px;
			background-color: #EAD7BB;
        }
        form input[type="email"],
        form input[type="password"],
        form input[type="submit"],
        button {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
			
        }
        form input[type="submit"],
        button {
            background-color: #BCA37F;
            color: white;
            cursor: pointer;
        }
        form input[type="submit"]:hover,
        button:hover {
            background-color: #45a049;
        }
		img.logo {
            display: block;
            margin: 0 auto; /* Center the image */
            width: 300px; /* Set the width of the image */
            
        }
    </style>
</head>
<body>
    <h1>Online Book Store</h1>

    <div class="container">
        <h2>Login</h2>
        <form action="login_process.php" method="post">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email"><br><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password"><br><br>

            <input type="submit" value="Login">

        </form>
		<a href="registration.php"><button>Register</button></a>
    </div>
<img class="logo" src="book-shop.png" alt="Bookstore Logo">
</body>
</html>
