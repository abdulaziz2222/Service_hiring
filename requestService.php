<?php 
session_start();
?>
<!DOCTYPE html>
<head>
    <title>request service</title>
</head>
<body>
    <?php 
    include 'db_config.php';
    $con =mysqli_connect(DBHOST,DBUSER,DBPWD,DBNAME);
    if(mysqli_connect_errno()){
        die("Cannot connect to db ".mysqli_connect_error());
    }
    $sid =$_POST["ord"];
    $ph =$_SESSION["phone"];
    $areyoutheonerQurey ="SELECT phone FROM service_item where service_ID = $sid";
    $phoneofoner = mysqli_query($con,$areyoutheonerQurey);
    if ($phoneofoner) {
        $rowN = mysqli_fetch_assoc($phoneofoner);
        $valueP = $rowN['phone'];
    if($ph!=$valueP){
    $query = "INSERT INTO `order` (`condition`, `order_service_id`, `phoneNumber`, `service_ID`) VALUES ('waiting',NULL,$ph,$sid)";
    if(mysqli_connect_errno()){
        die("Cannot connect to db ".mysqli_connect_error());
    }
    $result = mysqli_query($con,$query);
    mysqli_close($con);
    header("location:profile.php");
    }else{
        mysqli_close($con);
        $_SESSION['error_message'] = "You cannot request your own service.";
        header("location:servicePag.php?value=".$sid."");
        }
} else {
    // Handle query error
    echo "Error executing the query: " . mysqli_error($con);
} 
    
    ?></body>
</html>