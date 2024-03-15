<?php
session_start();
include 'db_config.php';
// Retrieve form data
$name = "";
$phone ="";
$email = "";
$password ="";

// Perform validation and database operations
// ...
if(!isset($_POST["email"])||!isset($_POST["name"]) ||!isset($_POST["phone"])||!isset($_POST["password"])){
    header("location:signin.html?eror(emailorpassword");
}
$email =$_POST['email'];
$phone =$_POST["phone"];
$password=$_POST["password"];
$name =$_POST["name"];
$con =mysqli_connect(DBHOST,DBUSER,DBPWD,DBNAME);
if(mysqli_connect_errno()){
    die("Cannot connect to db ".mysqli_connect_error());
}
$query = "INSERT INTO `user_info` (`user_id` ,`name`, `email`, `password`,`phoneNumber`) VALUES ( NULL,'$name', '$email', '$password', '$phone');";
$result = mysqli_query($con,$query);
    $_SESSION["login"]="yes";
    $_SESSION["phone"]=$phone;
    $_SESSION["email"]=$email;
    $_SESSION["name"]=$name;
    header("location:homepage.php");
    mysqli_close($close);

?>
