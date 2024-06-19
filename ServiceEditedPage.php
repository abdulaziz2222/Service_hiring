<?php session_start();
if (!isset($_SESSION["login"]))
    header("location:signin.html?eror=Please Sign In!"); ?>
<!DOCTYPE html>

<head>
    <link rel="stylesheet" href="styles/barAndBackgroundImg.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="stylesheet" href="styles/itemsEdit.css">
    <link rel="stylesheet" href="styles/itemsEdit2.css">
    <link rel="stylesheet" href="styles/footerStyle.css">
    <link rel="stylesheet" href="styles/breadcrumb.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <title>Edit service</title>

    <style>
        .preImg {
            border-radius: 10px;
            width: 23%;
            height: 10%;
        }
    </style>
</head>

<body id="body" class="backgroundPhoto">
    <div class="topnav">
        <a class="active" href="homepage.php">Home</a>
        <a href="Profile.php">My account</a>
        <a href="myRequestsPage.php">My request</a>
        <a href="postService.php">Post a service</a>
        <a href="signout.php">Sign out</a>
        <div class="search-container">
            <form action="search.php" method="post">
                <input type="text" placeholder="Search.." name="search" required>
                <button type="submit" name="submit">Search</button>
            </form>
        </div>
    </div>
    <ul class="breadcrumb">
        <li><a href="Profile.php">my account</a></li>
        <li><a href="editServices.php">my services</a></li>
        <li>selected service</li>
    </ul>
    <!-- -->
    <?php 
    $sid =$_POST["edit"];
    $tit ='';
    $descr ="";
    include 'db_config.php';
$con =mysqli_connect(DBHOST,DBUSER,DBPWD,DBNAME);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
    }
$renon ="";
$phone =$_SESSION["phone"];  
$imgesOfService = [];
$sql = "SELECT title,description,img_name,si.service_ID,phone,ui.name FROM service_item as si join imagesofservice as ios 
on si.service_ID = ios.serviceID join user_info as ui on ui.phoneNumber = si.phone where si.service_ID=".$sid." ";
$result = $con->query($sql);
if ($result->num_rows > 0) {
    while (($row = $result->fetch_assoc()) ) {
        $sid = $row["service_ID"];
        $tit = $row["title"];
        $descr = $row["description"];
        $na = $row["name"];
        $im =$row["img_name"];
        array_push($imgesOfService, $im);
    }
} 
$imTest =$imgesOfService[0];
?>
    <!-- POST service -->
    <div id="login-form-wrap">
        <h2>Post new service</h2><br>
        <form id="login-form" action="update_service.php" method="POST" enctype="multipart/form-data" onsubmit="return validateFileCount()">
            <p>
                <input type="text" id="name" name="title" placeholder="Title of your service" value="<?php echo $tit; ?>" maxlength="256" required><i class="validation"></i>
                <span id="errorName" class="errorMessage">
                </span>
            </p><br>
            <p>
                <input type="text" id="email" name="description" placeholder="Description of your service" value="<?php echo $descr; ?>" maxlength="700" required><i class="validation"></i>
                <span id="errorEmail" class="errorMessage">
                </span>
                <input style="display: none;" name="sid" value="<?php echo $sid; ?>">
            </p><br>
            <p>
            <div id="fmg">
                <label for="im" style="font-size: 14px;">Upload images of your service
                    <img src="img/upload.png" style="height: 14px;width: 30px;" />
                    <input id="im" type="file" style="display: none;" name="images[]" multiple>
            </div>
            <p style="margin-top: 10px; font-size: 0.85rem; color: #666; text-align: center;">
                Please select up to 4 images.
            </p>
            </label>
            <br>
            <div id="imgPreCon" style="display:inline;padding: 8px; ;padding-bottom: 13rem; margin:2%;">
            <?php
            if(!empty($imgesOfService[0])){ ?>
                <img class="preImg" src="<?php echo 'img/'.$imgesOfService[0].''; ?>" />
                <?php }else { ?>
                    <img class="preImg" />
                <?php } ?>
                <?php
            if(!empty($imgesOfService[1])){ ?>
                <img class="preImg" src="<?php echo 'img/'.$imgesOfService[1].''; ?>" />
                <?php }else { ?>
                    <img class="preImg" />
                <?php } ?>
                <?php
            if(!empty($imgesOfService[2])){ ?>
                <img class="preImg" src="<?php echo 'img/'.$imgesOfService[2].''; ?>" />
                <?php }else { ?>
                    <img class="preImg" />
                <?php } ?>
                <?php
            if(!empty($imgesOfService[3])){ ?>
                <img class="preImg" src="<?php echo 'img/'.$imgesOfService[3].''; ?>" />
                <?php }else { ?>
                    <img class="preImg" />
                <?php } ?>
            </div>
            
            <br>
            <br>
            <br>
            <p style="padding-bottom: 15px;">
                <input type="submit" id="login" value="save changes">
                <i class="validation"></i>
            </p><br>
            <br>
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

                const inpFile = document.getElementById("im");
                const previewContainer = document.getElementById("imgPreCon");
                const previewImgs = previewContainer.querySelectorAll(".preImg"); // Selects all preview slots
                
                inpFile.addEventListener("change", function() {
                    previewContainer.style.display = "inline"; // Show container initially

                    for (let i = 0; i < previewImgs.length; i++) {
                        const file = this.files[i];

                        if (file) {
                            const reader = new FileReader();
                            reader.addEventListener("load", function() {
                                previewImgs[i].setAttribute("src", this.result);
                                previewImgs[i].style.display='inline';
                            });

                            reader.addEventListener("error", function(error) {
                                console.error("Error reading file:", error);
                                // You can display an error message to the user here
                            });

                            if (!file.type.match("image/")) {
                                alert("Please select image files only.");
                                return;
                            }

                            reader.readAsDataURL(file);
                        } else {
                            previewImgs[i].setAttribute("src", ""); // Clear preview if no file selected
                            previewImgs[i].style.display = "none"; // Show container initially
                        }
                    }
                });
            </script></form></div>
        <?php       include 'functions/footer.php';
                    //Footer
                    footer(); ?>
</body>

</html>