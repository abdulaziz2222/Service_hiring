<?php session_start();
    if(!isset($_SESSION["login"]))
        header("location:signin.html?eror=Please Sign In!"); ?>
<!DOCTYPE html>
<head>
  <title>Homepage</title>
  <link rel="stylesheet" href="styles/homePage.css">
  <link rel="stylesheet" href="styles/barAndBackgroundImg.css">
</head>
<body id="body" class="backgroundPhoto">
    <?php
    if (isset($_SESSION['error_message'])) {
    echo "<script>alert('" . $_SESSION['error_message'] . "');</script>"; // Display it as a JavaScript alert
    unset($_SESSION['error_message']);}  ?>
    <div class="topnav">
        <a class="active" href="homepage.php">Home</a>
        <a href="Profile.php">My account</a>  
        <a href="add-item.html">Post a service</a> 
        <a href="signout.php">Sign out</a> 
        <div class="search-container">
        <form action="search.php" method="post" > 
            <input type="text" placeholder="Search.." name="search">
            <button type="submit" name="submit">Search</button>
        </form>
    </div>
</div>

<br><br>

    <?php 

include 'db_config.php';
$con =mysqli_connect(DBHOST,DBUSER,DBPWD,DBNAME);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
  }
$phone =$_SESSION["phone"];  
include 'functions/displayFunction.php';

//displayLeastest
$sql = "SELECT title,description,img_name,si.service_ID,phone,ui.name,numOfOrders
FROM service_item as si join imagesofservice as ios on si.service_ID = ios.serviceID 
join user_info as ui on ui.phoneNumber = si.phone order by si.service_ID desc";
$numServicesShown=5;
$type ='Last10AddedServices';
$result = $con->query($sql);
$title ="Latest 10 Available Services";
$isSearch = false;
displayServices($result,$numServicesShown,$type,$title,$isSearch);


//display most order services
$sql2 = "SELECT title,description,img_name,si.service_ID,phone,ui.name,numOfOrders
FROM service_item as si join imagesofservice as ios on si.service_ID = ios.serviceID 
join user_info as ui on ui.phoneNumber = si.phone order by numOfOrders desc";
$numServicesShown=5;
$type ='MostOrder';
$result = $con->query($sql2);
$title ="Most demanded";
displayServices($result,$numServicesShown,$type,$title,$isSearch);

?>
<footer>

</footer>
</body></html>