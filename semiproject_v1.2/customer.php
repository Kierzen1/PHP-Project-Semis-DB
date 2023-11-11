<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Bookstore</title>
</head>
<style>
         table {
            width: 75%;
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
        .h2cust{
            margin-left: 80px;
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
                            <a class = 'btn btn-primary btn-sm' href='/semiproject/updatecustomer.php?id=$row[c_id]'><button>Update</button></a>
                            <a class = 'btn btn-danger btn-sm' href='/semiproject/delete.php?id=$row[c_id]'><button>Delete</button></a>
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