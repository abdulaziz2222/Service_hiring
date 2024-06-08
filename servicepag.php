<?php session_start();
if (!isset($_SESSION["login"]))
    header("location:signin.html?eror=Please Sign In!"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service details</title>
    <link rel="stylesheet" href="styles/signinstyle.css">
    <link rel="stylesheet" href="styles/barAndBackgroundImg.css">
    <link rel="stylesheet" href="styles/footerStyle.css">
    <link rel="stylesheet" href="styles/servicePage.css">
    <link rel="stylesheet" href="styles/servicePage2.css">
    
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
</head>

<body class="backgroundPhoto">

    <div class="topnav">
        <a class="active" href="homepage.php">Home</a>
        <a href="Profile.php">My account</a>
        <a href="postService.php">Post a service</a>
        <a href="signout.php">Sign out</a>
    </div>
    <br><br>

    <div class="containerForImages">

        <br>
        <?php
        if (isset($_SESSION['error_message'])) {
            echo "<script>alert('" . $_SESSION['error_message'] . "');</script>"; // Display it as a JavaScript alert
            unset($_SESSION['error_message']);
        }  ?>

        <?php
        $sid = 0;
        include 'db_config.php';
        $conn = mysqli_connect(DBHOST, DBUSER, DBPWD, DBNAME);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        if (isset($_GET['value'])) {
            $sid = $_GET['value'];
        }
        // Fetch notice details
        $result = $conn->query("SELECT title,description,img_name,si.service_ID,phone FROM service_item as si 
join imagesofservice as ios on si.service_ID = ios.serviceID where si.service_ID= '$sid'");
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
        <section class="NextPrevButton">
            <button class="buttonNext" onclick="previousImage()">Previous</button>
            <button class="buttonNext" onclick="nextImage()">Next</button>
        </section>
        <!-- test -->
        <button id="request-service-btn" class="buttonReq">Request Service</button>
        <div id="service-modal" class="modal">
            <div class="modal-content">
                <h2>Request Service</h2>
                <form method="post" action="requestService.php" style="display: inline;">
                    <label for="start-date">Start Date:</label><br>
                    <input type="datetime-local" id="start-date" class="asdasd" name="start_date" onchange="changeTheEndDate()" required><br>

                    <label for="end-date">End Date:</label><br>
                    <input type="datetime-local" id="end-date" class="asdasd" name="end_date" onchange="checkDate()" required><br>

                    <label for="title">Title:</label><br>
                    <input type="text" id="title" name="title" required><br><br>

                    <label for="price">Price:</label><br>
                    <input type="text" id="price" name="price" required><br><br>

                    <button type="submit" name='ord' class="buttonReq" onclick="return checkDate();" value="<?php echo "$sid"; ?>">Submit Request</button>
                </form>
                <button class="modal-close-btn">Close</button><br>

            </div>
        </div>
        <br><br>
    </div>
    <?php
    include 'functions/footer.php';
    //Footer
    footer();
    ?>
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
        const serviceModal = document.getElementById("service-modal");
        const requestBtn = document.getElementById("request-service-btn");
        const closeBtn = document.querySelector(".modal-close-btn");

        requestBtn.addEventListener("click", function() {
            serviceModal.style.display = "block";
        });

        closeBtn.addEventListener("click", function() {
            serviceModal.style.display = "none";
        });

        // Optional: Close the modal by clicking outside the modal content
        window.addEventListener("click", function(event) {
            if (event.target.className === "modal") {
                serviceModal.style.display = "none";
            }
        });
        /*               Date js                              */        
        const now = new Date();
        now.setHours(now.getHours() + 3); // Add 3 hours to the current time
        now.setMilliseconds(0); // Set milliseconds to 0 for cleaner time display
        const input = document.getElementById("start-date");
        input.value = now.toISOString().slice(0, 16); // Format date and time (YYYY-MM-DDTHH:mm)
        input.min = input.value;

        function changeTheEndDate() {
            document.getElementById("end-date").value = document.getElementById('start-date').value;
        }


        function checkDate() {
            var dateString = document.getElementById('start-date').value;
            var dateString2 = document.getElementById('end-date').value;
            var DateStart = new Date(dateString);
            var DateEnd = new Date(dateString2);
            if (DateEnd < DateStart) {
                alert("End date cannot be less than Start date.");
                return false;
            }
            return true;
        }
/*              finish Date js                              */
    </script>
</body>

</html>