<?php
if(isset($_GET["id"])){
    $c_id = $_GET["id"];
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbmsproject";
    
    $connection = new mysqli($servername, $username, $password, $dbname);

    $sql = "DELETE FROM customer WHERE c_id = $c_id";
    $connection->query($sql);
}

header("location: /semiproject/customer.php");
exit;
?>
