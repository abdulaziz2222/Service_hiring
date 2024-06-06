<?php session_start();
    if(!isset($_SESSION["login"]))
        header("location:signin.html?eror=Please Sign In!"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Account</title>
    <link rel="stylesheet" href="styles/homePage.css">
    <link rel="stylesheet" href="styles/search.css">
    <link rel="stylesheet" href="styles/barAndBackgroundImg.css">
    <link rel="stylesheet" href="styles/footerStyle.css">    
    <link rel="stylesheet" href="styles/myAccount2.css">    
    <link rel="stylesheet" href="styles/myAccount.css">    
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

</head>
<body id="body" class="backgroundPhoto">
 <?php   
include 'db_config.php';
$con =mysqli_connect(DBHOST,DBUSER,DBPWD,DBNAME);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
} ?>
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
        <br><br><?php 
            $userID=$_SESSION["id"];
            $query = "SELECT phoneNumber,user_id,password,bio,userImg,name FROM user_info WHERE user_id='$userID'";
            $np = mysqli_query($con,$query);
            if ($np) {
              $userRow = mysqli_fetch_assoc($np);
              $userName=$userRow["name"];
              $userBio=$userRow["bio"];
              $userImg=$userRow["userImg"];
            }else{die("connection to the database went wrong");}
           /* profile */
      echo  '<div id="profileBio">
                <br>
                <img src="'.$userImg.'" alt="Admin" class="rounded-circle" width="150">
                  <h4>'.$userName.'</h4>
                  <p class="text-secondary mb-1">'.$userBio.'</p>
                  <br>
                  <a href="editProfile.php" style=" margin: 25px 120px;"><button class="editButton" type="submit" 
                  name="accept" value="">Edit my account</button></a>
                  <a href="editServices.php" style=" margin: 25px 120px;"><button class="editButton" type="submit" 
                  name="accept" value="">Edit my services</button></a>
                  <br><br></div>';            
            
                /* Requests for my services */
            ?><br>
        <section id="searchPage">

        <?php     if (isset($_SESSION['status'])) {
        if ($_SESSION['status'] = "requested") {
            echo '
<label>
<input type="checkbox" class="alertCheckbox" autocomplete="off" />
<div class="alert success">
<span class="alertClose">X</span>
<span class="alertText">Requested successfully '.$_SESSION['StartDate'].'  To '.$_SESSION['endDate'].'<br /> 
<br class="clear"/></span>
</div>
</label>';}}
            unset($_SESSION['status']);
            unset($_SESSION['StartDate']); 
            unset($_SESSION['endDate']); 
            /*  */
          
            if (isset($_SESSION['statAcc'])) {
                  echo '<br>
      <label>
      <input type="checkbox" class="alertCheckbox" autocomplete="off" />
      <div class="alert success">
      <span class="alertClose">X</span>
      <span class="alertText">You have successfully accepted the service request. Get ready to get started! <br /> 
      <br class="clear"/></span>
      </div>
      </label>';
      unset($_SESSION['statAcc']);
    }
      if(isset($_SESSION['statNotAcc'])){
        echo '<br>
        <label>
        <input type="checkbox" class="alertCheckbox" autocomplete="off" />
        <div class="alert error">
        <span class="alertClose">X</span>
        <span class="alertText">You have successfully declined the service request.
        <br /> 
        <br class="clear"/></span>
        </div>
        </label>';
        unset($_SESSION['statNotAcc']);
      }
                  unset($_SESSION['stat']);
            ?>
        <div id="servicesRequested"><br>
            <h1>Requests for my services</h1><br><br>
            <ul>
                <?php
                $phon =$_SESSION['phone'];
                $sql = 'SELECT ui.phoneNumber as ownerphone,si.title as titleOfService,description,img_name,si.service_id,o.price,o.title as titleOfOrder
                ,o.startDate,o.endDate	, o.phoneNumber as requestedphone
                ,ui.name as ownerName,o.order_service_id, `condition` FROM `order` AS o JOIN service_item AS si ON o.service_ID = si.service_ID 
                JOIN user_info AS ui ON si.phone = ui.phoneNumber Join imagesofservice as ios on si.service_ID = ios.serviceID  
                WHERE ui.phoneNumber = '."$phon".' ORDER BY order_service_id DESC';
                $result = $con->query($sql);
                $repeat ="";
                if($result->num_rows >0 ){
                while ($row = $result->fetch_assoc()) {
                    if($repeat != $row["order_service_id"]){
                      $sid =$row["service_id"];
                    if($row["condition"] == 'waiting' && $_SESSION["phone"]= $row['ownerphone']){
                    echo "<li> <a href='servicePag.php?value=" . $sid . "' class='styleFora'>
                            <img src='img/".$row["img_name"]."' >
                            <div class='service-details'>
                                <h3>".$row["titleOfService"]."</h3>
                                <p>The request: ".$row["titleOfOrder"]."</p>
                                <p>Price: ".$row["price"]."</p>
                                <p>The need of the service is from ".$row["startDate"]." to ".$row["startDate"]."</p>
                                <p style='color: #FDDA0D;'>waiting</p>";
                                $sqlp ='SELECT name FROM user_info where phoneNumber='.$row["requestedphone"].'';
                                $result2 = $con->query($sqlp);
                                $row2 = $result2->fetch_assoc();
                                $oID = $row["order_service_id"];
                                echo " <p>Requested by: ".$row2['name'].".</p>
                            </div>
                            <div class='btnOfAccRef'>
                                <form action='refuseOrAccept.php' method='post'>
                                    <input type='hidden' name='service_id' value='5'>
                                    <button class='accepTbutton' type='submit' name='accept' value='$oID'>Accept</button>
                                    <button class='refusebutton' type='submit' name='refuse' value='$oID'>Refuse</button>
                                </form>
                            </div></a>
                        </li>";
                    }elseif ($row["condition"] == 'accept' && $_SESSION["phone"]= $row['ownerphone']){
                    echo "<li> <a href='servicePag.php?value=" . $sid . "' class='styleFora'>
                            <img src='img/".$row["img_name"]."'>
                            <div class='service-details'>
                            <h3>".$row["titleOfService"]."</h3>
                            <p>The request: ".$row["titleOfOrder"]."</p>
                            <p>Price: ".$row["price"]."</p>
                            <p>The need of the service is from ".$row["startDate"]." to ".$row["startDate"]."</p>
                            <p style='color: #13a809;'>Accepted</p>";
                                $sqlp ='SELECT name FROM user_info where phoneNumber='.$row["requestedphone"].'';
                                $result2 = $con->query($sqlp);
                                $row2 = $result2->fetch_assoc();
                                echo " <p>Requested by: ".$row2['name'].".</p>
                                <p>".$row2['name']." phone number: ".$row['requestedphone']."</p>
                            </div> </a>
                            </li>";
                
            }
            $repeat=$row["order_service_id"];
        }}}else {
            echo "<p>No Result Found.</p>";
        }
        
                ?>
            </ul><br>
        </div>
    </section>
    <?php     
    include 'functions/footer.php';
    //Footer
    footer();  
    ?>
</body>
</html>







