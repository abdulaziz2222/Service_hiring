<?php session_start();
    if(!isset($_SESSION["login"]))
        header("location:signin.html?eror=Please Sign In!"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Account</title>
    <link rel="stylesheet" href="homepage.css"> <!-- Ensure your CSS path is correct -->
    <style>
/* Overall body styles */
body {
    background-color: #9f9da7;
    font-size: 1.6rem;
    font-family: 'Open Sans', sans-serif;
    color: #2b3e51;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
}

/* Container for content to centralize and shadow */
.container {
    background-color: #fff;
    font-weight: 300;
    width: 80%;
    margin-top: 20px;
    text-align: center;
    padding-bottom: 20px;
    border-radius: 4px;
    box-shadow: 0 30px 50px 0 rgba(0, 0, 0, 0.2);
}

/* Navigation bar styling */
.topnav {
    overflow: hidden;
    background-color: #e9e9e9;
    width: 100%;
    border-radius: 4px 4px 0 0;
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

.topnav a.active {
    background-color: #2196F3;
    color: white;
}
 .topnav a:hover {
    background-color: #ddd;
    color: black;
}

/* Styling for service lists */
#servicesProvided, #servicesRequested {
    margin: 20px auto;
    width: 90%;
}

ul {
    list-style-type: none;
    padding: 0;
}

li {
    background: #f0f0f0;
    margin: 10px 0;
    padding: 10px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.service-details {
    flex-grow: 1;
}

.service-actions {
    flex-grow: 0;
    flex-shrink: 0;
}
   
.editButton {
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        background-color: #2196F3; /* Green for accept */
        color: white;
   /*     margin: 25px 120px; */
}

.accepTbutton {
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    background-color: #4CAF50; /* Green for accept */
    color: white;
    margin-left: 5px;
}

.refusebutton{
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    background-color: #4CAF50; /* Green for accept */
    color: white;
    margin-left: 5px;
    background-color: #f44336; /* Red for refuse */
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


button:hover {
    opacity: 0.8;
}

.topnav input[type=text] {
  padding: 6px;
  margin-top: 8px;
  font-size: 17px;
  margin-right: 3px;
  border: none;
}
@media screen and (max-width: 600px) {
    .topnav a, .topnav input[type=text], .topnav .search-container button {
        width: 100%;
        margin: 0;
        padding: 14px;
    }

    .topnav input[type=text] {
        border: 1px solid #ccc; 
        display: block; 
    }

    li {
        flex-direction: column;
        align-items: start;
    }

    li img {
        margin-bottom: 10px;
    }

    .service-actions {
        width: 100%;
        order: 3; /* Reorder to appear last */
    }
    
   
}

    </style>
</head>
<body>
 <?php   
include 'db_config.php';
$con =mysqli_connect(DBHOST,DBUSER,DBPWD,DBNAME);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
} ?>
    <div class="container">
        <div class="topnav">
            <a class="active" href="homepage.php">Home</a>
            <a href="profile.php">My Account</a>
            <a href="add-item.html">Post a Service</a>
            <a href="signout.php">Sign Out</a>
            <div class="search-container">
                <form action="search.php" method="post">
                    <input style="margin-right: -715px;" type="text" placeholder="Search.." name="search" >
                    <button style="margin-left: 0px;" type="submit">Search</button>
                </form>
            </div>
        </div>
        <br>
        <h2>Hi <?php echo $_SESSION["name"];?></h2>
        <a href="editProfile.php" style=" margin: 25px 120px;"><button class='editButton' type='submit' name='accept' value='$oID'>Edit my profile</button></a>
        <a href="" style=" margin: 25px 120px;"><button class='editButton' type='submit' name='accept' value='$oID'>Edit my services</button></a>
        <div id="servicesRequested">
            <h3>Requests for my services</h3>
            <ul>
                <?php
                $phon =$_SESSION['phone'];
                $sql = 'SELECT ui.phoneNumber as ownerphone,title,description,img_name, o.phoneNumber as requestedphone
                ,ui.name as ownerName,o.order_service_id, `condition` FROM `order` AS o JOIN service_item AS si ON o.service_ID = si.service_ID 
                JOIN user_info AS ui ON si.phone = ui.phoneNumber Join imagesofservice as ios on si.service_ID = ios.serviceID  WHERE ui.phoneNumber = '."$phon".' ORDER BY order_service_id DESC';
                $result = $con->query($sql);
                $repeat ="";
                if($result->num_rows >0 ){
                while ($row = $result->fetch_assoc()) {
                    if($repeat != $row["order_service_id"]){
                    if($row["condition"] == 'waiting' && $_SESSION["phone"]= $row['ownerphone']){
                    echo "<li> 
                            <img src='img/".$row["img_name"]."' style='width: 15%; '>
                            <div class='service-details'>
                                <h3>".$row["title"]."</h3>
                                <p>".$row["description"]."</p>
                                <p style='color: #FDDA0D;'>waiting</p>";
                                $sqlp ='SELECT name FROM user_info where phoneNumber='.$row["requestedphone"].'';
                                $result2 = $con->query($sqlp);
                                $row2 = $result2->fetch_assoc();
                                $oID = $row["order_service_id"];
                                echo " <p>Requested by: ".$row2['name'].".</p>
                            </div>
                            <div class='service-actions'>
                                <form action='refuseOrAccept.php' method='post'>
                                    <input type='hidden' name='service_id' value='5'>
                                    <button class='accepTbutton' type='submit' name='accept' value='$oID'>Accept</button>
                                    <button class='refusebutton' type='submit' name='refuse' value='$oID'>Refuse</button>
                                </form>
                            </div>
                        </li>";
                    }elseif ($row["condition"] == 'accept' && $_SESSION["phone"]= $row['ownerphone']){
                    echo "<li> 
                            <img src='img/".$row["img_name"]."' style='width: 15%;'>
                            <div class='service-details'>
                                <h3>".$row["title"]."</h3>
                                <p>".$row["description"]."</p>
                                <p style='color: #13a809;'>Accepted</p>";
                                $sqlp ='SELECT name FROM user_info where phoneNumber='.$row["requestedphone"].'';
                                $result2 = $con->query($sqlp);
                                $row2 = $result2->fetch_assoc();
                                echo " <p>Requested by: ".$row2['name'].".</p>
                                <p>".$row2['name']." phone number: ".$row['requestedphone']."</p>
                            </div> 
                            </li>";
                
            }else{
                    echo "<li> 
                            <img src='img/".$row["img_name"]."' style='width: 15%;'>
                            <div class='service-details'>
                                <h3>".$row["title"]."</h3>
                                <p>".$row["description"]."</p>
                                <p style='color: red;'>Refused</p>";
                                $sqlp ='SELECT name FROM user_info where phoneNumber='.$row["requestedphone"].'';
                                $result2 = $con->query($sqlp);
                                $row2 = $result2->fetch_assoc();
                                echo " <p>Requested by: ".$row2['name'].".</p>
                            </div> 
                            </li>";
            }
            $repeat=$row["order_service_id"];
        }}}else {
            echo "<p>No Result Found.</p>";
        }
        
                ?>
            </ul>
            <h3>My requests for services</h3>
            <ul>
                <?php
                $phon =$_SESSION['phone'];
                $sql = 'SELECT ui.phoneNumber as ownerphone,title,description,img_name, o.phoneNumber as requestedphone
                ,ui.name as ownerName,o.order_service_id, `condition` FROM `order` AS o JOIN service_item AS si ON o.service_ID = si.service_ID 
                JOIN user_info AS ui ON si.phone = ui.phoneNumber Join imagesofservice as ios on si.service_ID = ios.serviceID  WHERE o.phoneNumber =  '."$phon".'  ORDER BY order_service_id DESC';
                $result = $con->query($sql);
                $repeat ="";
                // Assume $resultRequested is fetched before this point
                if($result ->num_rows >0){
                while ($row = $result->fetch_assoc()) {
                    if($repeat != $row["order_service_id"]){
                    if($row["condition"] == 'waiting' && $_SESSION["phone"]= $row['requestedphone']){
                    echo "<li> 
                            <img src='img/".$row["img_name"]."' style='width: 15%; '>
                            <div class='service-details'>
                                <h3>".$row["title"]."</h3>
                                <p>".$row["description"]."</p>
                                <p style='color: #FDDA0D;'>waiting</p>";
                                $sqlp ='SELECT name FROM user_info where phoneNumber='.$row["ownerphone"].'';
                                $result2 = $con->query($sqlp);
                                $row2 = $result2->fetch_assoc();
                                $oID = $row["order_service_id"];
                                echo " <p>service provider: ".$row2['name'].".</p>
                            </div>
                            
                        </li>";
                    }elseif ($row["condition"] == 'accept' && $_SESSION["phone"]= $row['requestedphone']){
                    echo "<li> 
                            <img src='img/".$row["img_name"]."' style='width: 15%;'>
                            <div class='service-details'>
                                <h3>".$row["title"]."</h3>
                                <p>".$row["description"]."</p>
                                <p style='color: #13a809;'>Accepted</p>";
                                $sqlp ='SELECT name FROM user_info where phoneNumber='.$row["ownerphone"].'';
                                $result2 = $con->query($sqlp);
                                $row2 = $result2->fetch_assoc();
                                echo " <p>Service provider: ".$row2['name'].".</p>
                                <p>".$row2['name']." phone number: ".$row['ownerphone']."</p>
                            </div> 
                            </li>";
                
            }else{
                    echo "<li> 
                            <img src='img/".$row["img_name"]."' style='width: 15%;'>
                            <div class='service-details'>
                                <h3>".$row["title"]."</h3>
                                <p>".$row["description"]."</p>
                                <p style='color: red;'>Refused</p>";
                                $sqlp ='SELECT name FROM user_info where phoneNumber='.$row["ownerphone"].'';
                                $result2 = $con->query($sqlp);
                                $row2 = $result2->fetch_assoc();
                                echo " <p>Service provider: ".$row2['name'].".</p>
                            </div> 
                            </li>";
            }
            $repeat=$row["order_service_id"];
        }}} else{
            echo '<p>No Result Found.</p>';
        }
                ?>
            </ul>
        </div>
    </div>
</body>
</html>
