<?php session_start();
    if(!isset($_SESSION["login"]))
        header("location:signin.html?eror=Please Sign In!"); ?>
<!DOCTYPE html>
<head>
  <title>Edit my services</title>
  <link rel="stylesheet" href="homepage.css">
  <style>
		/* Add a black background color to the top navigation bar */
        
.editButton {
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    background-color: #2196F3; /* Green for accept */
    color: white;
    margin-left: 5px;
}
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
  .service-actions {
        width: 100%;
        order: 3; /* Reorder to appear last */
    }
}
* {margin: 0; padding: 0;}
 
#services {
  margin: 20px;
}
 
ul {
  list-style-type: none;
  width: 100%;
}

h3 {
  font: bold 20px/1.5 Helvetica, Verdana, sans-serif;
}
 
li img {
  float: left;
  margin: 0 15px 0 0;
}
 
li p {
  font: 200 12px/1.5 Georgia, Times New Roman, serif;
}
 
li {
  padding: 10px;
  overflow: auto;
}
 
li:hover {
  background: #eee;
  cursor: pointer;
}	
.service-actions {
    flex-grow: 0;
    flex-shrink: 0;
}
   

</style> 
</head>
<body style="    background-color: #9f9da7;
    font-size: 1.6rem;
    font-family: 'Open Sans', sans-serif;
    color: #2b3e51;">
    <?php
     if (isset($_SESSION['error_message'])) {
    echo "<script>alert('" . $_SESSION['error_message'] . "');</script>"; // Display it as a JavaScript alert
    unset($_SESSION['error_message']);}  ?>
<div style="
    background-color: #fff;
    font-weight: 300;
    width: 80%;
    margin: 0 auto;
    text-align: center;
    padding: 0px 0 20% 0;
    border-radius: 4px;
    box-shadow: 0px 30px 50px 0px rgba(0, 0, 0, 0.2);">
<div class="topnav">
    <a class="active" href="homepage.php">Home</a>
    <a href="Profile.php">My account</a>
    <a href="add-item.html">Post a service</a>
    <a href="signout.php">Sign out</a>  
    <div class="search-container">
    <form action="search.php" method="post">
        <input type="text" placeholder="Search.." name="search" required>
        <button type="submit"  name="submit" >Search</button>
    </form>
    </div>
</div>
<br>
<h1>My services</h1>
<br>
<div id="services">
  <ul>
    <?php 
include 'db_config.php';
$con =mysqli_connect(DBHOST,DBUSER,DBPWD,DBNAME);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
  }
  $renon ="";
$phone =$_SESSION["phone"];  
$sql = "SELECT title,description,img_name,si.service_ID,phone,ui.name FROM service_item as si join imagesofservice as ios 
on si.service_ID = ios.serviceID join user_info as ui on ui.phoneNumber = si.phone where ui.phoneNumber=".$phone." order by service_ID desc ";
$result = $con->query($sql);
if ($result->num_rows > 0) {
  while (($row = $result->fetch_assoc()) ) {
      $sid = $row["service_ID"];
      $tit = $row["title"];
      $descr = $row["description"];
      $na = $row["name"];
      if($renon!=$sid){
      ?>
      <p>
      <?php 
      $imgName = $row["img_name"]; 
      $renon =$sid;
      echo "<a href ='servicePag.php?value=".$sid."' style='text-decoration:none; color:black;' ><li><img style='width: 15%;' src='img/$imgName' />
      <h3>$tit</h3><p>$descr</p><br>
      <div class='service-actions'>
                                <form action='ServiceEditedPage.php' method='post'>
                                    <input type='hidden' name='service_id' value='5'>
                                    <button class='editButton' type='submit' name='edit' value='$sid'>Edit</button>
                                </form>
                            </div>
      </form></li></a>";
      }}
  }
else {
  echo "No results found.";
}
$con->close();
?>   </ul>
</div>
<?php 

?></div></body></html>