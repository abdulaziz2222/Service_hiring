<?php session_start();
    if(!isset($_SESSION["login"]))
        header("location:signin.html?eror=Please Sign In!"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service details</title>
    <style>
        body {
              background-color: #9f9da7;
    font-size: 1.6rem;
    font-family: 'Open Sans', sans-serif;
    color: #2b3e51;
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
}
* {margin: 0; padding: 0;}
 
#services {
  margin: 20px;
}
 
ul {
  list-style-type: none;
  width: 100%;
}

        .buttonNext {
    background-color: #2196F3; /* Blue color for the button */
    color: white;
    border: none;
    padding: 10px 20px;
    margin: 10px;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s ease;
}

button:hover {
    background-color: #1976D2; /* Darker shade of blue on hover */
}

        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
            background: #fff;
            padding: 0;
            border-radius: 8px;
            box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1);
        }
        .header {
            background: #fff;
            color: black;
            padding: 10px 0;
            text-align: center;
        }
        .description {
            font-size: 16px;
            margin: 20px 10px;
        }
        .slider {
            width: 100%;
            overflow: hidden; /* Ensures the extra images are hidden */
            margin: 20px 0;
        }
        .image-container {
            width: 400%; /* Adjust based on number of images * 100% */
            display: flex;
            transition: transform 0.4s ease-in-out;
        }
        img {
            width: 25%; /* As it's 100% / number of images */
            height: auto;
            flex-shrink: 0;
            border-radius: 4px;
        }
        .button {
        background-color: #4CAF50; /* Green background */
        color: white; /* White text for contrast */
        padding: 10px 20px; /* Padding for better touch area and appearance */
        margin-left: 450px;
        border: none; /* No border for a modern look */
        border-radius: 5px; /* Rounded corners */
        cursor: pointer; /* Cursor indicates it’s clickable */
        font-size: 16px; /* Readable font size */
        transition: background-color 0.3s; /* Smooth transition for hover effect */
    }

    .button:hover {
        background-color: #45a049; /* Darker green on hover */
    }
</style>
    </style>
</head>
<body>
    <div class="container">
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
        <?php
     if (isset($_SESSION['error_message'])) {
    echo "<script>alert('" . $_SESSION['error_message'] . "');</script>"; // Display it as a JavaScript alert
    unset($_SESSION['error_message']);}  ?>
        <div class="search-container">
        <!--     <form action="search.php" method="post" > 
            <input type="text" placeholder="Search.." name="search">
            <button type="submit" name="submit">Search</button></form>*/ -->
    <?php        
    $sid=0;
    include 'db_config.php';
    $conn =mysqli_connect(DBHOST,DBUSER,DBPWD,DBNAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);   
            }
            if (isset($_GET['value'])) {
                $sid = $_GET['value'];
            } 
// Fetch notice details
$result = $conn->query( "SELECT title,description,img_name,si.service_ID,phone /*,o.condition*/ FROM service_item as si join imagesofservice as ios on si.service_ID = ios.serviceID where si.service_ID= '$sid'");
$imagePaths = [];
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $imagePaths[] = $row['img_name'];
    echo '<div class="header"><h1>' . $row['title'] . '</h1><br></div>';
    echo '<p class="description">' . $row['description'] . '</p>';
} else {
    echo '<div class="header"><h1>No notice found</h1></div>';
}
// Fetch images associated with the notice

while ($imgRow = $result->fetch_assoc()) {
    $imagePaths[] = $imgRow['img_name'];
}
// Close connection
$conn->close();
        ?>
        <div class="slider">
            <div style="height: 700px;" class="image-container" id="imageContainer">
                <?php
                foreach ($imagePaths as $image) {
                    echo '<img style ="width:25%;" src="img/' . $image . '" alt=""/>';
                }
                ?>
            </div>
        </div>
        <button style ='background-color: #2196F3;' class ="buttonNext" onclick="previousImage()">Previous</button>
        <button style ='background-color: #2196F3;' class ="buttonNext" onclick="nextImage()">Next</button>
        <form method="post" action="requestService.php" style="display: inline;">
        <button id="requestButton" class="button" name="ord" value="<?php echo "$sid"; ?>" onclick="changeButton()">Request the Service</button></form>

    </div>
    <br>

    <script>
        let currentIndex = 0;
        const images = document.getElementById('imageContainer').children;
        const totalImages = images.length;

        function updateImagePosition() {
            const offset = currentIndex * -100 / totalImages;
            document.getElementById('imageContainer').style.transform = 'translateX(' + offset + '%)';
        }

        function nextImage() {
            currentIndex = (currentIndex + 1) % totalImages;
            updateImagePosition();
        }

        function previousImage() {
            currentIndex = (currentIndex - 1 + totalImages) % totalImages;
            updateImagePosition();
        }
        function changeButton() {
        var button = document.getElementById('requestButton');
        button.innerHTML = '&#10004; Requested'; // Changing the button text to include a checkmark
        button.style.backgroundColor = '#008000'; // Optional: change the background color to indicate success
    }
    </script>
</body>
</html>

