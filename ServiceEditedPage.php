<?php 
    session_start();
    if(!isset($_SESSION["login"]))
        header("location:signin.html?eror=Please Sign In!"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Service</title>
    <link rel="stylesheet" href="add-item.css">
    <style>

body {
    font-family: Arial, sans-serif;
    background-color: #9f9da7;
    margin: 0;
    padding: 20px;
}

.container, div[style] {
    background-color: #fff;
    font-weight: 300;
    width: 80%;
    margin: -8px auto;
    text-align: center;
    padding: 20px 0;
    border-radius: 4px;
    box-shadow: 0px 30px 50px 0px rgba(0, 0, 0, 0.2);
}

.topnav {
    overflow: hidden;
    background-color: #e9e9e9;
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

.topnav input[type=text], .topnav button {
    padding: 6px;
    margin-top: 8px;
    font-size: 17px;
    border: none;
}

.topnav .search-container button {
    float: right;
    background: #ddd;
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

.inputsepdate {
    width: 40%;
    padding: 10px;
    margin: 20px auto;
    border: 1px solid #ccc;
    border-radius: 5px;
    display: inline;
}

.button-19 {
    appearance: button;
    background-color: #3ca9e2;
    border: solid transparent;
    border-radius: 16px;
    border-width: 0 0 4px;
    color: #FFFFFF;
    cursor: pointer;
    font-family: din-round, sans-serif;
    font-size: 15px;
    font-weight: 700;
    letter-spacing: .8px;
    line-height: 20px;
    margin: 0 auto;
    outline: none;
    padding: 13px 16px;
    text-align: center;
    text-transform: uppercase;
    touch-action: manipulation;
    transition: filter .2s;
    user-select: none;
    vertical-align: middle;
    white-space: nowrap;
    width: 30%;
}

.button-19:hover:not(:disabled) {
    filter: brightness(1.1);
}

.button-19:active {
    background-color: #318AC9;
    border-width: 4px 0 0;
}
    </style>
</head>
<body>
<div style="
background-color: #fff;
font-weight: 300;
width: 80%;
margin: -8px auto;
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
    <h1>Edit Service</h1>
    <?php 
    $sid =$_POST["edit"];
    $title ='';
    $description ="";
    include 'db_config.php';
$con =mysqli_connect(DBHOST,DBUSER,DBPWD,DBNAME);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
    }
$renon ="";
$phone =$_SESSION["phone"];  
$sql = "SELECT title,description,img_name,si.service_ID,phone,ui.name FROM service_item as si join imagesofservice as ios 
on si.service_ID = ios.serviceID join user_info as ui on ui.phoneNumber = si.phone where si.service_ID=".$sid." order by service_ID desc ";
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
        ?> 
        
        <form action="update_service.php" method="POST" enctype="multipart/form-data" onsubmit="return validateFileCount()">
        <label for="title">Title:</label>
        <input type="text" class="inputsepdate" id="title" name="title" value="<?php echo $tit; ?>" required><br>
        <label for="description">Description:</label>
        <input id="description" class="inputsepdate" name="description" value="<?php echo $descr;?>" required ><br>
        <input style="display: none;" name="sid" value="<?php echo $sid; ?>">
        <div class="button-19">
        <label for="im" style="font-size: 14px;">replace images   
        <input id="im"  type="file" style="display: none;" name="images[]" multiple>
        <img src="img/upload.png" style="height: 14px;width: 30px;" /></div>
        <p style="margin-top: 10px; font-size: 0.85rem; color: #666;">
                Please select up to 4 images.
            </p>
        <br>
        <br>
        <input class="button-19" type="submit" value="save">
        </form>
        <?php }
        }
    }
else {
    echo "No results found.";
}
$con->close();
    ?>
</div>
<script>
    function validateFileCount() {
        var input = document.getElementById('im');
        var files = input.files;
        if (files.length > 4) {
            alert('You may upload up to 4 images only.');
            return false;
        }
        return true;
    }
    </script>
</body>
</html>
