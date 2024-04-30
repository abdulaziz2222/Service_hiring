<?php
    session_start();
        if(!isset($_SESSION["login"]))
            header("location:signin.html?eror=Please Sign In!");
        include 'db_config.php';
        $con =mysqli_connect(DBHOST,DBUSER,DBPWD,DBNAME);
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        } 
        
        
        if(isset($_POST["accept"])){
        $ord_id = $_POST["accept"];
        $query ="UPDATE `order` SET `condition` = 'accept' WHERE `order_service_id` = $ord_id";
        $result = mysqli_query($con,$query);
    }else{
        $ord_id = $_POST["refuse"];
        $query ="UPDATE `order` SET `condition` = 'refuse' WHERE `order_service_id` = $ord_id";
        $result = mysqli_query($con,$query);
    }
        header("location:profile.php");
        mysqli_close($con);
        /*
         $result = mysqli_query($con,$query);
        $query = "SELECT furniture_id FROM orderfur WHERE `order_id` = $ord_id";
        $na = mysqli_query($con,$query);
        if ($na) {
            $rowN = mysqli_fetch_assoc($na);
            $fid = $rowN['furniture_id'];
            $query ="UPDATE `orderfur` SET `condition` = 'taken' WHERE `order_id` != $ord_id and furniture_id=$fid ";
            $result = mysqli_query($con,$query);
        } else {
            // Handle query error
            echo "Error executing the query: " . mysqli_error($con);
        }    */
        
        
?>