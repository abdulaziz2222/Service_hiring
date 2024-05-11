<?php
    session_start();
    if(!isset($_SESSION["login"]))
        header("location:signin.html?eror=Please Sign In!");    
    include 'db_config.php';
    $conn =mysqli_connect(DBHOST,DBUSER,DBPWD,DBNAME);
    if(mysqli_connect_errno()){
        die("Cannot connect to db ".mysqli_connect_error());
        }   
$title = $_POST["title"];
$description = $_POST["description"];
$sid = $_POST["sid"];

// Prepare the SQL statement for updating the user info
$sql1 = "UPDATE `service_item` SET `title` = ?, `description` = ? WHERE `service_ID` = ?;";
$stmt = $conn->prepare($sql1);

// Check if the statement was prepared correctly
if (!$stmt) {
    die('MySQL prepare error: ' . $conn->error);
}

// Bind the variables to the prepared statement as parameters
$stmt->bind_param("ssi", $title, $description, $sid);

if (!empty($_FILES['images']['name'])) {
    echo "Files detected.<br>";
    // Delete old images
    $queryFI = "DELETE FROM imagesofservice WHERE serviceID='$sid'";
    if ($conn->query($queryFI)) {
        echo "Old images deleted.<br>";
    } else {
        echo "Error deleting old images: " . $conn->error . "<br>";
    }
    // Process new images
    $fileCount = count($_FILES["images"]["name"]);
    for ($i = 0; $i < $fileCount; $i++) {
        $fileName = mysqli_real_escape_string($conn, $_FILES['images']['name'][$i]);
        $uploadPath = 'img/' . $fileName;
        // SQL to insert new image record
        $sql = "INSERT INTO imagesofservice (`img_id`, `img_name`, `serviceID`) VALUES (NULL, '$fileName', '$sid')";
        if ($conn->query($sql)) {
            echo "Database updated for file: $fileName<br>";
            // Move file to designated folder
            if (move_uploaded_file($_FILES['images']['tmp_name'][$i], $uploadPath)) {
                echo "File uploaded: $uploadPath<br>";
            } else {
                echo "Failed to upload file: $uploadPath<br>";
            }
        } else {
            echo "Database update failed for file: $fileName. Error: " . $conn->error . "<br>";
        }
    }
} else {  echo "No files uploaded.<br>";}

// Execute the statement
if ($stmt->execute()) {
    echo "Service edited successfully.";
    sleep(4);
    header("location:homepage.php?message=edited successfully");
} else {
    echo "Error edited profile: " . $stmt->error;
    sleep(4);
    header("Location:homepage.php?Erorr"); 
}

// Close statement
$stmt->close();

    ?>