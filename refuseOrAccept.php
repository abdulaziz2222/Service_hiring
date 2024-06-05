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
        $_SESSION['statAcc']='accept';
    }else{
        $ord_id = $_POST["refuse"];
        $query ="UPDATE `order` SET `condition` = 'refuse' WHERE `order_service_id` = $ord_id";
        $result = mysqli_query($con,$query);
        $_SESSION['statNotAcc']='refuse';
    }
        header("location:profile.php");
        mysqli_close($con);
        
?>