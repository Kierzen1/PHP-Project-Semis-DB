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

        do{
            if (empty($c_name) || empty($c_email) || empty($c_address) || empty($c_email) || empty($c_status)){
                $errorMessage = "Please Fill up the fields";
                break;
            }

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

        }while(false) ;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Bookstore</title>

</head>
<body>
    <div class = "container my-5">
        <h2>Add Customer</h2>
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
            <?php
            if(!empty($successMessage)){
            echo"
                <div class='row mb-3'>
                    <div class='offset-sm-3 col-sm-6'>
                        <div class='alert alert-sucess alert-dismissable fade show' role='alert'>
                            <strong>$successMessage</strong>
                            <button type='button' class = 'btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
                    </div>
                </div>
            ";
            }?>
            <div class = "row mb-3">
                <div class ="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class = "btn btn-primary">Submit</button>
                </div>
                <div class = "col-sm-3 d-grid">
                <button><a class = "btn btn-outline-primary" href = "/semiproject_v1.2/customer.php" role = "button">Cancel</button></a>
                </div>
            </div>
        </form>
    </div>
    
</body>
</html>