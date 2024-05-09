<?php
session_start();
include 'db_config.php';
// Retrieve form data
$email = "";
$password ="";
// Perform validation and database operations
// ...
if(!isset($email)||!isset($password)){
    header("location:signin.html?eror(emailorpassword");
}
$email =$_POST['email'];
$password=$_POST["password"];
$con =mysqli_connect(DBHOST,DBUSER,DBPWD,DBNAME);

if(mysqli_connect_errno()){
    die("Cannot connect to db ".mysqli_connect_error());
}
$query = "SELECT * FROM user_info WHERE email='$email' AND password='$password'";
$result = mysqli_query($con,$query);

if(mysqli_num_rows($result) == 0){
    header("location:signin.html?eror(wrong emailorpassword");
    mysqli_close($close);}
    else{
    $_SESSION["login"]="yes";
    $_SESSION["email"]=$email;


    $query = "SELECT phoneNumber,user_id,password FROM user_info WHERE email='$email' AND password='$password'";
    $np = mysqli_query($con,$query);
    if ($np) {
        $rowP = mysqli_fetch_assoc($np);
        $valueP = $rowP['phoneNumber'];
        $_SESSION["id"]=$rowP['user_id'];
        // You can now use the value stored in the variable
        $_SESSION["phone"]=$valueP;
        $_SESSION["password"]=$rowP["password"];
        } else {
        // Handle query error
        echo "Error executing the query: " . mysqli_error($con);
    }  


    $query = "SELECT name FROM user_info WHERE email='$email' AND password='$password'";
    $na = mysqli_query($con,$query);
    if ($na) {
        $rowN = mysqli_fetch_assoc($na);
        $valueN = $rowN['name'];
        // You can now use the value stored in the variable
        $_SESSION["name"]= $valueN;
    } else {
        // Handle query error
        echo "Error executing the query: " . mysqli_error($con);
    }    
//    $_SESSION["name"]=$na;
    header("location:homepage.php");
    mysqli_close($close);
}



?>
