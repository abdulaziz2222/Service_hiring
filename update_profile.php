<?php
    session_start();
    if(!isset($_SESSION["login"]))
        header("location:signin.html?eror=Please Sign In!");    
    include 'db_config.php';
    $conn =mysqli_connect(DBHOST,DBUSER,DBPWD,DBNAME);
    if(mysqli_connect_errno()){
        die("Cannot connect to db ".mysqli_connect_error());
        }   
$phone = $_POST["phone"];
$name = $_POST["name"];
$email = $_POST["email"];
$password = $_POST["password"];
$id = $_POST["id"];

// Prepare the SQL statement for updating the user info
$sql1 = "UPDATE `user_info` SET `name` = ?, `email` = ?, `password` = ?, `phoneNumber` = ? WHERE `user_id` = ?;";
$stmt = $conn->prepare($sql1);

// Check if the statement was prepared correctly
if (!$stmt) {
    die('MySQL prepare error: ' . $conn->error);
}

// Bind the variables to the prepared statement as parameters
$stmt->bind_param("ssssi", $name, $email, $password, $phone, $id);

// Execute the statement
if ($stmt->execute()) {
    echo "Profile updated successfully.";
    sleep(4);
    session_destroy();
    header("location:signin.html?message=edited successfully");
} else {
    echo "Error updating profile: " . $stmt->error;
    sleep(4);
    header("Location: editProfile.html"); 
}

// Close statement
$stmt->close();

    ?>