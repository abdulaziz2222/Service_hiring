<!DOCTYPE html>
<head>
  <link rel="stylesheet" href="homepage.css">
  <style>
		/* Add a black background color to the top navigation bar */
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
 
h3 {
  font: bold 20px/1.5 Helvetica, Verdana, sans-serif;
}
 
li img {
  float: left;
  margin: 0 15px 0 0;
}
 
li p {
  font: 200 12px/1.5 Georgia, Times New Roman, serif;
}
 
li {
  padding: 10px;
  overflow: auto;
}
 
li:hover {
  background: #eee;
  cursor: pointer;
}	

</style> 
</head>
<body style="    background-color: #9f9da7;
    font-size: 1.6rem;
    font-family: 'Open Sans', sans-serif;
    color: #2b3e51;">
<div style="
    background-color: #fff;
    font-weight: 300;
    width: 80%;
    margin: 0 auto;
    text-align: center;
    padding: 0px 0 20% 0;
    border-radius: 4px;
    box-shadow: 0px 30px 50px 0px rgba(0, 0, 0, 0.2);">
    <div class="topnav">
        <a class="active" href="homepage.php">Home</a>
        <a>My account</a>  <!--add the link -->
        <a>Post a service</a> <!--add the link -->
        <a href="signout.php">Sign out</a>  <!--add the link -->
        <div class="search-container">
        <form method="post"> <!--add the link -->
            <input type="text" placeholder="Search.." name="search">
            <button type="submit" name="submit">Search</button>
        </form>
    </div>
</div>

<h1>Available services</h1>
<div id="services">
  <ul>
    <li>
      <img style="width: 15%;" src="img/Electrical.png" />
      <h3>Electrical</h3>
      <p>With a decade of experience, trust me for all your electrical needs.</p>
    </li>
    <li>
      <img style="width: 15%;" src="img/CarpentryCraft.png" />
      <h3>Carpentry Craft</h3>
      <p>Seven years of carpentry mastery at your service.</p>
    </li>
    <li>
      <img style="width: 15%;" src="img/PaintingPro.png" />
      <h3>Painting Pro</h3>
      <p>Transform your home with my five years of painting expertise.</p>
    </li> 
    <li>
      <img style="width: 15%;" src="img/HVACSpecialist.png" />
      <h3>HVAC Specialist</h3>
      <p>Keep your home comfortable with my eight years of HVAC experience.</p>
    </li>
  </ul>
</div>
<?php 

?></div></body></html>