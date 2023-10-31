<!DOCTYPE html>
<html>
<head>
    <title>Online Bookstore</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
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
            padding-top: 50px;
            color: #333;
            font-size: 3em;
            animation: fadeIn 2s;
        }

        p {
            text-align: center;
            color: #555;
            font-size: 1.2em;
            animation: slideInFromLeft 2s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes slideInFromLeft {
            from {
                margin-left: -100%;
                opacity: 0;
            }
            to {
                margin-left: 0;
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="index.php">Home</a>
        <a href="customers.php">Customers</a>
        <a href="items.php">Items</a>
    </div>
    <h1>Welcome to the Online Bookstore!</h1>
    <p>Explore our collection of books and much more.</p>
</body>
</html>
