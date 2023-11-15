<?php
    $servername="localhost";
    $username= "root";
    $password= "";
    $dbname= "dbmsproject";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    
    $c_id="";
    $c_name= "";
    $c_email= "";
    $c_address= "";
    $c_status= "";

    $errorMessage = "";
    $successMessage="";

    if ($_SERVER['REQUEST_METHOD'] == 'GET'){
        if(!isset($_GET["id"])){
            header("location: /semiproject_v1.2/customer.php");
            exit;
        }
        $c_id=$_GET["id"];

        $sql = "SELECT * from customer WHERE c_id = $c_id";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        if(!$row){
            header("location: /semiproject_v1.2/customer.php");
            exit;
        }
        $c_name=$row["c_name"];
        $c_email=$row["c_email"];
        $c_address=$row["c_address"];
        $c_status=$row["c_status"];
    }
    else {
        $c_id = $_POST["id"];
        $c_name = $_POST["name"];
        $c_email = $_POST["email"];
        $c_address = $_POST["address"];
        $c_status = $_POST["status"];

        
            $sql = "UPDATE customer " .
                    "SET c_name = '$c_name', c_email = '$c_email', c_address = '$c_address', c_status = '$c_status'" .
                    "WHERE c_id = $c_id";
                    $result = $conn->query($sql);
                    $successMessage = "CustomerUpdated";

            if(!$result){
                $errorMessage = "Invalid Querying" . $conn->error;
                return;
            }
            $successMessage = "Client updated!!";

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
        font-family: aria-label;
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
        <form class ="formh2"><h2>Update</h2></form>
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
            <input type="hidden" name = "id" value="<?php echo $c_id; ?>">
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
            
            <div class = "row mb-3">
                
                    <button type="submit" class = "btn btn-primary" >Update</button>
                    <button><a class = "btn btn-outline-primary" href = "/semiproject_v1.2/customer.php" role = "button">Cancel</a></button>
                </div>
            
        </form>
    </div>
    
</body>
</html>