<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Bookstore</title>
</head>
<style>
         table {
            width: 90%;
            margin: 10px auto;
        }
        table, th, td {
            border: 1px dotted #EAD7BB;
        }
        th {
            padding: 6px;
            background-color: brown;
            color: white;
        }
        .button1{
            margin-left: 80px;
            width:120px;
            padding-left: 1px;
            background-color: aliceblue;
        }
        .button2{
            margin-left: 80px;
            width:120px;
            padding-left: 1px;
            background-color: aliceblue;
        }
        .button3{
            margin-left: 90px;
            width:120px;
            padding-left: 1px;
            background-color: aliceblue;
        }
        .h2cust{
            width: 240px;
            margin: 5px auto;
            padding: 10px;
            border-radius: 5px 5px 5px 5px; 
            background-color: beige;
            text-align: center;
        }
        
</style>
<body>
    <div>
        <h2 class = "h2cust">Customers</h2>
        <a class = "buttonadd" href="/semiproject_v1.2/addcustomer.php" role="button1"><button class = "button1">Add Customer</button></a>
        <br>
        <table class = "table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Status</th>
                <tr>
            </thead>
            <tbody>
                <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "dbmsproject";
                    $conn = new mysqli($servername, $username, $password, $dbname);

                    if($conn->connect_error) {
                        die("". $conn->connect_error);
                    }

                    $sql = "SELECT * from customer";
                    $result = $conn->query($sql);

                    if(!$result) {
                        die("Error querying!!". $conn->error);
                    }
                    while($row = $result->fetch_assoc()) {
                        echo"<tr>
                        <td>$row[c_name]</td>
                        <td>$row[c_email]</td>
                        <td>$row[c_address]</td>
                        <td>$row[c_status]</td>
                        <td>
                            <a class = 'button2' href='/semiproject_v1.2/updatecustomer.php?id=$row[c_id]'><button>Update</button></a>
                            <a class = 'button3' href='/semiproject_v1.2/delete.php?id=$row[c_id]'><button>Delete</button></a>
                        </td>
                    </tr>
                        ";
                    }

                ?>

            </tbody>
        </table>
    </div>
    
</body>
</html>