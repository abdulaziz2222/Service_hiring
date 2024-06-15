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
            border-radius: 50%;
            width: 10rem;
            height: 10rem;
            margin: 0 40% ;
            
        }

    </style>
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
                <button type="submit" name="submit">Search</button>
            </form>
        </div>
    </div>
    <ul class="breadcrumb">
        <li><a href="Profile.php">my account</a></li>
        <li>edit my account</li>
    </ul>
    <!-- -->
    <?php 
    $sid =0;
    $tit ='';
    $descr ="";
    include 'db_config.php';
$con =mysqli_connect(DBHOST,DBUSER,DBPWD,DBNAME);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
    }
$phone =$_SESSION["phone"];  
$sql = "SELECT `user_id`, `name`, `email`, `password`, `phoneNumber`, `userImg`, `bio` FROM user_info where phoneNumber=".$phone." ";
$name ="";
$phoneNumber='';
$password = "";
$email="";
$result = $con->query($sql);
$imgBio= "";
$bio="";
if ($result->num_rows > 0) {
    while (($row = $result->fetch_assoc()) ) {
        $name = $row["name"];
        $phoneNumber = $row["phoneNumber"];
        $password = $row["password"];
        $email = $row["email"];
        $imgBio = $row["userImg"];
        $bio = $row["bio"];
    }
}

?>
    <!-- POST service -->
    <div id="login-form-wrap">
        <h2>Edit your account information</h2><br>
            <div id="imgPreCon"  style="display:inline; padding-bottom: 13rem;">
            <br>
            <?php
            if(!empty($imgBio)){
                if($imgBio=="https://bootdey.com/img/Content/avatar/avatar7.png"){ ?>
                <img class="preImg" src="<?php echo 'https://bootdey.com/img/Content/avatar/avatar7.png'; ?>" />
                <?php } else{?>
                            <img class="preImg" src="<?php echo 'img/'.$imgBio.''; ?>" />
            <?php  }}else { ?>
                    <img class="preImg" />
                <?php } ?>
            </div>
            <br><br>
            <form id="login-form" action="update_profile.php" method="POST" enctype="multipart/form-data" onsubmit="return validateFileCount()">

            <div id="fmg">
                <label for="im" style="font-size: 14px;">replace your profile image
                    <img src="img/upload.png" style="height: 14px;width: 30px;" />
                    <input id="im" type="file" style="display: none;" name="accountImg"  >
                </label>
            </div>
            <br><br>
            <p>
                <input type="text" id="name" name="bio" value="<?php echo $bio; ?>" maxlength="256" required><i class="validation"></i>
                <span id="errorName" class="errorMessage">
                </span>
            </p><br><br>  
            <p>
                <input type="text" id="name" name="name" value="<?php echo $name; ?>" maxlength="256" required><i class="validation"></i>
                <span id="errorName" class="errorMessage">
                </span>
            </p><br>
            <p>
                <input type="password" id="name" name="password" value="<?php echo $password; ?>" maxlength="256" required><i class="validation"></i>
                <span id="errorName" class="errorMessage">
                </span>
            </p><br>    
            <p>
                <input type="text" id="name" name="phone" value="<?php echo $phoneNumber; ?>" maxlength="256" required><i class="validation"></i>
                <span id="errorName" class="errorMessage">
                </span>
            </p><br>
            <p>
                <input type="text" id="email" name="email"  value="<?php echo $email; ?>" maxlength="700" required><i class="validation"></i>
                <span id="errorEmail" class="errorMessage">
                </span>
<!--                <input style="display: none;" name="sid" value="">    -->
            </p><br>
            <p>
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
                    if (files.length > 1) {
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