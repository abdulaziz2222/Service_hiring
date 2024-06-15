<?php session_start();
    if(!isset($_SESSION["login"]))
        header("location:signin.html?eror=Please Sign In!"); ?>
<!DOCTYPE html>
<head>
  <title>Edit my services</title>
  <link rel="stylesheet" href="styles/homePage.css">
  <link rel="stylesheet" href="styles/search.css">
  <link rel="stylesheet" href="styles/barAndBackgroundImg.css">
  <link rel="stylesheet" href="styles/editServices.css">
  <link rel="stylesheet" href="styles/footerStyle.css">
  <link rel="stylesheet" href="styles/breadcrumb.css" >
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
</head>

<body id="body" class="backgroundPhoto">

<div class="topnav">
    <a class="active" href="homepage.php">Home</a>
    <a href="Profile.php">My account</a>
    <a href="postService.php">Post a service</a>
    <a href="signout.php">Sign out</a>  
    <div class="search-container">
    <form action="search.php" method="post">
        <input type="text" placeholder="Search.." name="search" required>
        <button type="submit"  name="submit" >Search</button>
    </form>
    </div>
</div>
<ul class="breadcrumb">
  <li><a href="Profile.php">my account</a></li>
  <li>my services</li>
</ul>
<br><br>

<?php
include 'db_config.php';
include 'functions/displayFunction.php';
$con =mysqli_connect(DBHOST,DBUSER,DBPWD,DBNAME);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
  }
  $renon ="";
$phone =$_SESSION["phone"];  
$sql = "SELECT title,description,img_name,si.service_ID,phone,ui.name FROM service_item as si join imagesofservice as ios 
on si.service_ID = ios.serviceID join user_info as ui on ui.phoneNumber = si.phone where ui.phoneNumber=".$phone." order by service_ID desc ";
$numServicesShown=20;
$type ='Last10AddedServices';
$result = $con->query($sql);
$title ="My services ";
$isSearch = true;
$isEditPage = true;
displayServices($result,$numServicesShown,$type,$title,$isSearch,$isEditPage);
include 'functions/footer.php';
//Footer
footer();
?>
</body></html>