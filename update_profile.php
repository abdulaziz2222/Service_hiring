<?php

   session_start();
    if(!isset($_SESSION["login"]))
        header("location:signin.html?eror=Please Sign In!");    
    include 'db_config.php';
    $conn =mysqli_connect(DBHOST,DBUSER,DBPWD,DBNAME);
    if(mysqli_connect_errno()){
        die("Cannot connect to db ".mysqli_connect_error());
        }  
$hasImage = isset($_FILES['accountImg']) && !empty($_FILES['accountImg']['name']);

$bio = $_POST["bio"];
$phone = $_POST["phone"];
$name = $_POST["name"];
$email = $_POST["email"];
$password = $_POST["password"];
$id = $_SESSION["id"];
if($hasImage){
// Prepare the SQL statement for updating the user info
$imgBio = $_FILES['accountImg']['name']; 
}else{
    $sql = "SELECT `userImg` FROM `user_info` where `user_id` = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        if($row = $result->fetch_assoc()) {
                $imgBio =$row['userImg'];
        }
    }
}   
$sql1 = "UPDATE `user_info` SET `name` = ?, `email` = ?, `password` = ?, `phoneNumber` = ?, `userImg` = ?, `bio` = ? WHERE `user_id` = ?;";
$stmt = $conn->prepare($sql1);
// Check if the statement was prepared correctly
if (!$stmt) {
    die('MySQL prepare error: ' . $conn->error);
}
// Bind the variables to the prepared statement as parameters
$stmt->bind_param("ssssssi", $name, $email, $password, $phone, $imgBio, $bio, $id);

// Execute the statement
if ($stmt->execute()) {
    $_SESSION['proEdit']="yes";
    echo "Profile updated successfully.";
    sleep(4);
    session_destroy();
    header("location:signin.html?message=edited successfully".$imgBio."");
} else {
    $_SESSION['proNotEdit']="not";
    echo "Error updating profile: " . $stmt->error;
    sleep(4);
    header("Location: editProfile.html"); 
}

// Close statement
$stmt->close();

   ?>