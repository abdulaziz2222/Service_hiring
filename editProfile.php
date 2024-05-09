<?php
    session_start();
    if(!isset($_SESSION["login"]))
        header("location:signin.html?eror=Please Sign In!");    
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit my profile</title>
  <!--<link rel="stylesheet" type="text/css" href="styles.css">-->
  <link rel="stylesheet" href="add-item.css">
  <style>
  .inputsepdate {
    margin: 40px 60px;
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
  
.button-19 {
    appearance: button;
    background-color:#3ca9e2;
    border: solid transparent;
    border-radius: 16px;
    border-width: 0 0 4px;
    box-sizing: border-box;
    color: #FFFFFF;
    cursor: pointer;
    display: inline-block;
    font-family: din-round,sans-serif;
    font-size: 15px;
    font-weight: 700;
    letter-spacing: .8px;
    line-height: 20px;
    margin: 0;
    outline: none;
    overflow: visible;
    padding: 13px 16px;
    text-align: center;
    text-transform: uppercase;
    touch-action: manipulation;
    transform: translateZ(0);
    transition: filter .2s;
    user-select: none;
    -webkit-user-select: none;
    vertical-align: middle;
    white-space: nowrap;
    width: 30%;
  }
  
.button-19:after {
    background-clip: padding-box;
    background-color: #3ca9e2;
    border: solid transparent;
    border-radius: 16px;
    border-width: 0 0 4px;
    bottom: -4px;
    content: "";
    left: 0;
    position: absolute;
    right: 0;
    top: 0;
    z-index: -1;
  }
  
.button-19:main,
.button-19:focus {
    user-select: auto;  
}
.button-19:hover:not(:disabled) {
    filter: brightness(1.1);
    -webkit-filter: brightness(1.1);
}  
.button-19:disabled {
    cursor: auto;
}  
.button-19:active {
    border-width: 4px 0 0;
    background: none;
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
    <a href="profile.php">My account</a>
    <a href="add-item.html">Post a service</a>
    <a href="signout.php">Sign out</a>  
    <div class="search-container">
    <form action="search.php" method="post">
        <input type="text" placeholder="Search.." name="search">
        <button type="submit"  name="submit" >Search</button>
    </form>
    </div>
</div>
<?php 
       $name =$_SESSION["name"];
       $phone =$_SESSION["phone"];
       $email =$_SESSION["email"];
       $password =$_SESSION["password"];
       $id =$_SESSION["id"];

?>
  <h1>Edit my profile</h1>
  <form action="update_profile.php" method="POST">
    <label for="name">Name:</label>
    <input type="text" class="inputsepdate" id="name" name="name" value="<?php echo $name; ?>" required><br>

    <label for="phone">Phone:</label>
    <input type="text" class="inputsepdate" id="phone" name="phone" value="<?php echo $phone; ?>" required><br>

    <label for="email">Email:</label>
    <input type="email" class="inputsepdate" id="email" name="email" value="<?php echo $email; ?>" required><br>

    <label for="password">Password:</label>
    <input type="password" class="inputsepdate" id="password" name="password" value="<?php echo $password; ?>" required><br>
    <br><p><input class="button-19" style="
      background-color: #3ca9e2;
      border: none;
      color: white;
      padding: 15px 32px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      margin: 4px 2px;
      cursor: pointer;" type="submit" value="SAVE"></p>
      <input style="display: none;" name="id" value="<?php echo $id; ?>">
</form></div>
  <script src="jquery.min.js"></script>
  <script src="add-item.js"></script>
</body>
</html>
