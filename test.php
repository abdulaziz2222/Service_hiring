<?php session_start();
    if(!isset($_SESSION["login"]))
        header("location:signin.html?eror=Please Sign In!"); ?>
<!DOCTYPE html>
<head>
<link rel="stylesheet" href="styles/barAndBackgroundImg.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel="stylesheet" href="styles/itemsEdit.css">

    <title>Post service</title>
</head>
<body id="body" class="backgroundPhoto">
<div class="topnav">
    <a class="active" href="homepage.php">Home</a>
    <a href="Profile.php">My account</a>
    <a href="add-item.html">Post a service</a>
    <a href="signout.php">Sign out</a>  
    <div class="search-container">
    <form action="search.php" method="post">
        <input type="text" placeholder="Search.." name="search" required>
        <button type="submit"  name="submit" >Search</button>
    </form>
</div>
</div>
    <!-- POST service -->
    <div id="login-form-wrap">
    <h2>Post new service</h2><br>
    <form id="login-form" action="add-item.php" method="POST" enctype="multipart/form-data" onsubmit="return validateFileCount()">
    <p>
    <input type="text" id="name" name="name" placeholder="Title of your service" required><i class="validation"></i>
    <span id="errorName" class="errorMessage">
    </span>  
    </p><br>
    <p>
    <input type="text" id="email" name="email" placeholder="Description of your service" required><i class="validation"></i>
    <span id="errorEmail" class="errorMessage">
    </span>
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
    <p style="padding-bottom: 15px;">
    <input type="submit" id="login" value="post">
    <i class="validation"></i>
    </p><br>
    <br>
</body>
</html>

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
  </script>
</body>

</html>