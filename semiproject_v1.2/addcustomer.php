<?php
    $servername="localhost";
    $username= "root";
    $password= "";
    $dbname= "dbmsproject";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    
    $c_name="";
    $c_email= "";
    $c_address= "";
    $c_status= "";

    $errorMessage = "";
    $successMessage = "";

    if( $_SERVER['REQUEST_METHOD']=='POST'){
        $c_name=$_POST['name'];
        $c_email=$_POST['email'];
        $c_address=$_POST['address'];
        $c_status=$_POST['status'];

       

            $sql = "INSERT INTO customer (c_name, c_email, c_address, c_status) " .
                    "VALUES ('$c_name', '$c_email', '$c_address', '$c_status')";
            $result = $conn->query($sql);

            $c_name= "";
            $c_email= "";
            $c_address= "";
            $c_status= "";
            $successMessage = "Customer Added";

            header("location: /semiproject_v1.2/customer.php");
            exit;

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Bookstore</title>

</head>
<style>
    form{
        width: 240px;
            margin: 5px auto;
            padding: 10px;
            border-radius: 5px 5px 5px 5px; 
            background-color: beige;
            text-align: left;
    }
    .formh2{
        width: 250px;
            margin: 0px auto;
            padding: 2px;
            border-radius: 5px 5px 5px 5px; 
            background-color: beige;
            text-align: center;
    }
    form input[type="text"] {
        width: 220px; 
        padding: 2px;
        margin: 3px 0;
        font-family: monospace;
    }
    button{
        margin-right: 20px;
            width:80px;
            padding-left: 1px;
            background-color: aliceblue;
    }
    strong{
        text-align: center;
    }
</style>
<body>
    <div class = "container my-5">
        <form class = "formh2"><h2>Add Customer</h2></form>
        <?php
        if(!empty($errorMessage)){
            echo"
                <div class='alert alert-warning alert-disimissable fade show' role='alert'>
                    <strong>$errorMessage</strong>
                    <button type='button' class = 'btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>
            ";
        }
        ?>
        <form method = "post">
            <div class = "row mb-3">
                <label class ="col-sm-3 col-form-label">Name</label>
                <div class = "col-sm-6">
                    <input type="text" class = "form-control" name = "name" value = "<?php echo $c_name; ?>">
                </div>
            </div>
            <div class = "row mb-3">
                <label class ="col-sm-3 col-form-label">Email</label>
                <div class = "col-sm-6">
                    <input type="text" class = "form-control" name = "email" value = "<?php echo $c_email; ?>">
                </div>
            </div>
            <div class = "row mb-3">
                <label class ="col-sm-3 col-form-label">Address</label>
                <div class = "col-sm-6">
                    <input type="text" class = "form-control" name = "address" value = "<?php echo $c_address; ?>">
                </div>
            </div>
            <div class = "row mb-3">
                <label class ="col-sm-3 col-form-label">Status</label>
                <div class = "col-sm-6">
                    <input type="text" class = "form-control" name = "status" value = "<?php echo $c_status; ?>">
                </div>
            </div>
            <div>
                <div>
                    <button type="submit" class = "btn btn-primary">Submit</button>
                <button><a class = "btn btn-outline-primary" href = "/semiproject_v1.2/customer.php" role = "button">Cancel</button></a>
                </div>
            </div>
        </form>
    </div>
    
</body>
</html>