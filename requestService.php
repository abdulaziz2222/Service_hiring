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
    $titleOrder=$_POST["title"];
    $priceOrder=$_POST["price"];
    $startDate=$_POST["start_date"];
    $endDate=$_POST["end_date"];

    $ph =$_SESSION["phone"];
    $areyoutheonerQurey ="SELECT phone FROM service_item where service_ID = $sid";
    $phoneofoner = mysqli_query($con,$areyoutheonerQurey);
    if ($phoneofoner) {
        $rowN = mysqli_fetch_assoc($phoneofoner);
        $valueP = $rowN['phone'];
    if($ph!=$valueP){
    $query = "INSERT INTO `order`(`order_service_id`, `condition`, `phoneNumber`, `service_ID`, `title`, `price`, `startDate`, `endDate`) VALUES (null,'waiting','".$ph."',
    '".$sid."','".$titleOrder."','".$priceOrder."','".$startDate."','".$endDate."')";
    if(mysqli_connect_errno()){
        die("Cannot connect to db ".mysqli_connect_error());
    }
    $result = mysqli_query($con,$query);

    $query2 ="UPDATE `service_item` SET numOfOrders = numOfOrders + 1 WHERE `service_ID` = $sid";
    $result = mysqli_query($con,$query2);

    mysqli_close($con);
    $_SESSION['status']='requested';
    $_SESSION['StartDate']=$startDate;
    $_SESSION['endDate']=$endDate;

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