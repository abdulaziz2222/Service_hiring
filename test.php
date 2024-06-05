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
    <link rel="stylesheet" href="styles/myAccount.css">    
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    
    <style>
    
    </style>
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
           /* profile */
      echo  '<div id="profileBio">
                <br>
                <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle" width="150">
                  <h4>'.$_SESSION["name"].'</h4>
                  <p class="text-secondary mb-1">Full Stack Developer</p>
                  <p class="text-muted font-size-sm">Bay Area, San Francisco, CA</p>
                  <br>
                </div>
                ';            
            
            
            
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
        <a href="editProfile.php" style=" margin: 25px 120px;"><button class='editButton' type='submit' name='accept' value='$oID'>Edit my account</button></a>
        <a href="editServices.php" style=" margin: 25px 120px;"><button class='editButton' type='submit' name='accept' value='$oID'>Edit my services</button></a>
        <div id="servicesRequested">
            <h1>Requests for my services</h1><br><br>
            <ul>
                <?php
                $phon =$_SESSION['phone'];
                $sql = 'SELECT ui.phoneNumber as ownerphone,si.title,description,img_name,si.service_id, o.phoneNumber as requestedphone
                ,ui.name as ownerName,o.order_service_id, `condition` FROM `order` AS o JOIN service_item AS si ON o.service_ID = si.service_ID 
                JOIN user_info AS ui ON si.phone = ui.phoneNumber Join imagesofservice as ios on si.service_ID = ios.serviceID  WHERE ui.phoneNumber = '."$phon".' ORDER BY order_service_id DESC';
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
                            </div></a>
                        </li>";
                    }elseif ($row["condition"] == 'accept' && $_SESSION["phone"]= $row['ownerphone']){
                    echo "<li> <a href='servicePag.php?value=" . $sid . "' class='styleFora'>
                            <img src='img/".$row["img_name"]."'>
                            <div class='service-details'>
                                <h3>".$row["title"]."</h3>
                                <p>".$row["description"]."</p>
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










<?php /*<!DOCTYPE html>
<head>
  <title>Test</title>
  <link rel="stylesheet" href="testCss.css">
</head>
<body>
<div class="container">
    <div class="main-body">
          <!-- Breadcrumb -->
          <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.html">Home</a></li>
              <li class="breadcrumb-item"><a href="javascript:void(0)">User</a></li>
              <li class="breadcrumb-item active" aria-current="page">User Profile</li>
            </ol>
          </nav>
          <!-- /Breadcrumb https://bootdey.com/img/Content/avatar/avatar7.png" -->
          <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex flex-column align-items-center text-center">
                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle" width="150" style="
                    border-radius: 50%;
                    width: 10rem;
                    height: 10rem;">
                    <div class="mt-3">
                      <h4>John Doe</h4>
                      <p class="text-secondary mb-1">Full Stack Developer</p>
                      <p class="text-muted font-size-sm">Bay Area, San Francisco, CA</p>
                     </div>
                  </div>
                </div>
              </div>
            </div>
    </div>
</body> </html> */
