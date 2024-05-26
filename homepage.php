<?php session_start();
    if(!isset($_SESSION["login"]))
        header("location:signin.html?eror=Please Sign In!"); ?>
<!DOCTYPE html>
<head>
  <title>Homepage</title>
  <link rel="stylesheet" href="styles/homePage.css">
  <style>

.topnav {
  overflow: hidden;
  background-color: #e9e9e9;
  margin: 0px;
}

.topnav a {
  float: left;
  display: block;
  color: black;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:hover {
  background-color: #ddd;
  color: black;
}

.topnav a.active {
  background-color: #2196F3;
  color: white;
}

.topnav .search-container {
  float: right;
}

.topnav input[type=text] {
  padding: 6px;
  margin-top: 8px;
  font-size: 17px;
  border: none;
}

.topnav .search-container button {
  float: right;
  padding: 6px;
  margin-top: 8px;
  margin-right: 16px;
  background: #ddd;
  font-size: 17px;
  border: none;
  cursor: pointer;
}

.topnav .search-container button:hover {
  background: #ccc;
}

@media screen and (max-width: 600px) {
  .topnav .search-container {
    float: none;
  }
  .topnav a, .topnav input[type=text], .topnav .search-container button {
    float: none;
    display: block;
    text-align: left;
    width: 100%;
    margin: 0;
    padding: 14px;
  }
  .topnav input[type=text] {
    border: 1px solid #ccc;  
  }
}
* {margin: 0; padding: 0;}

</style> 
</head>
<body id="body" class="backgroundPhoto">
    <?php
    if (isset($_SESSION['error_message'])) {
    echo "<script>alert('" . $_SESSION['error_message'] . "');</script>"; // Display it as a JavaScript alert
    unset($_SESSION['error_message']);}  ?>
    <div class="topnav">
        <a class="active" href="homepage.php">Home</a>
        <a href="Profile.php">My account</a>  <!--add the link -->
        <a href="add-item.html">Post a service</a> <!--add the link -->
        <a href="signout.php">Sign out</a>  <!--add the link -->
        <div class="search-container">
        <form action="search.php" method="post" > <!--add the link -->
            <input type="text" placeholder="Search.." name="search">
            <button type="submit" name="submit">Search</button>
        </form>
    </div>
</div>
<br>
<br>
<section id="last10AddedServices">
  <br>
<h1 class="headerForLast10AddedServices">Latest 10 Available Services</h1>
<br>
  <ul>
    <?php 

include 'db_config.php';
$con =mysqli_connect(DBHOST,DBUSER,DBPWD,DBNAME);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
  }
$phone =$_SESSION["phone"];  

$sql = "SELECT title,description,img_name,si.service_ID,phone,ui.name,numOfOrders
FROM service_item as si join imagesofservice as ios on si.service_ID = ios.serviceID 
join user_info as ui on ui.phoneNumber = si.phone order by si.service_ID desc";

$result = $con->query($sql);

$myArray = [];
$i=0;
if ($result->num_rows > 0) {
  while (($row = $result->fetch_assoc()) && $i<10) {
      $sid = $row["service_ID"];
      $tit = $row["title"];
      $descr = $row["description"];
      $na = $row["name"];
      if(!in_array($sid,$myArray)){
?>
      <p>
      <form method="post" action="servicePag.php">
      <?php 
      $imgName = $row["img_name"]; 
      $myArray[] =$sid; 
      echo "<a href ='servicePag.php?value=".$sid."' class='styleFora' ><li>
      <img class='imgLast10AddedServicesContainer' src='img/$imgName' />
      <h3 class='headerOfParagraphFontForLast10AddedServices'>$tit</h3><p class='paragraphFontLast10AddedServices'>$descr</p>
      <p class='paragraphFontLast10AddedServices'>Service provider: $na</p></li></a></form>";
      $i++;}}
  }
else {
  echo "No results found.";
}
//$con->close();
?>   </ul>
</div>
<br>
</section>

<section id="mostServicesOrder">
  <br>
<h1>Most Services Order</h1>
<br>
  <ul>
    <?php 
$sql = "SELECT title,description,img_name,si.service_ID,phone,ui.name,numOfOrders
FROM service_item as si join imagesofservice as ios on si.service_ID = ios.serviceID 
join user_info as ui on ui.phoneNumber = si.phone order by numOfOrders desc";

$result = $con->query($sql);
$myArray2 = [];
$i=0;
if ($result->num_rows > 0) {
  while (($row = $result->fetch_assoc()) && $i<5) {
      $sid = $row["service_ID"];
      $tit = $row["title"];
      $descr = $row["description"];
      $na = $row["name"];
      if(!in_array($sid,$myArray2)){
?>
      <p>
      <form method="post" action="servicePag.php">
      <?php 
      $imgName = $row["img_name"]; 
      $myArray2[] =$sid; 
      echo "<a href ='servicePag.php?value=".$sid."' class='styleFora' >
      <li><img class='imgForMostOrderContainer' src='img/$imgName' />
      <h3 class='headerOfParagraphFontForMostOrder'>$tit</h3><p class='paragraphFontForMostOrder'>$descr</p>
      <p class='paragraphFontForMostOrder'>Service provider: $na</p></li></a></form>";
      $i++;}}
  }
else {
  echo "No results found.";
}
$con->close();
?>   </ul>
</div>
<br>
</section>
</body></html>