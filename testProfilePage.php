<?php session_start();
    if(!isset($_SESSION["login"]))
        header("location:signin.html?eror=Please Sign In!"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Services</title>
    <link rel="stylesheet" href="homepage.css"> <!-- Ensure your CSS path is correct -->
    <style>
        /* Overall body styles */
body {
    background-color: #9f9da7;
    font-size: 1.6rem;
    font-family: 'Open Sans', sans-serif;
    color: #2b3e51;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
}

/* Container for content to centralize and shadow */
.container {
    background-color: #fff;
    font-weight: 300;
    width: 80%;
    margin-top: 20px;
    text-align: center;
    padding-bottom: 20px;
    border-radius: 4px;
    box-shadow: 0 30px 50px 0 rgba(0, 0, 0, 0.2);
}

/* Navigation bar styling */
.topnav {
    overflow: hidden;
    background-color: #e9e9e9;
    width: 100%;
    border-radius: 4px 4px 0 0;
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

.topnav a.active, .topnav a:hover {
    background-color: #ddd;
    color: black;
}

/* Styling for service lists */
#servicesProvided, #servicesRequested {
    margin: 20px auto;
    width: 90%;
}

ul {
    list-style-type: none;
    padding: 0;
}

li {
    background: #f0f0f0;
    margin: 10px 0;
    padding: 10px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.service-details {
    flex-grow: 1;
}

.service-actions {
    flex-grow: 0;
    flex-shrink: 0;
}

button {
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    background-color: #4CAF50; /* Green for accept */
    color: white;
    margin-left: 5px;
}

button:last-of-type {
    background-color: #f44336; /* Red for refuse */
}

button:hover {
    opacity: 0.8;
}

@media screen and (max-width: 600px) {
    .topnav a, .topnav input[type=text], .topnav .search-container button {
        width: 100%;
        margin: 0;
        padding: 14px;
    }

    .topnav input[type=text] {
        border: 1px solid #ccc;  
    }

    li {
        flex-direction: column;
        align-items: start;
    }

    li img {
        margin-bottom: 10px;
    }

    .service-actions {
        width: 100%;
        order: 3; /* Reorder to appear last */
    }
}

    </style>
</head>
<body>
    <div class="container">
        <div class="topnav">
            <a class="active" href="homepage.php">Home</a>
            <a href="profile.php">My Account</a>
            <a href="add-item.html">Post a Service</a>
            <a href="signout.php">Sign Out</a>
            <div class="search-container">
                <form action="search.php" method="post">
                    <input type="text" placeholder="Search.." name="search">
                    <button type="submit">Search</button>
                </form>
            </div>
        </div>
        <br>
        <h2>Hi <?php echo $_SESSION["name"]; ?></h2>
        <div id="servicesRequested">
            <h3>Services I Requested</h3>
            <ul>
                <?php
                $i =0;
                // Assume $resultRequested is fetched before this point
                while ($i<2) {
                    echo "<li>
                            <img src='img/123.png' style='width: 100px;'>
                            <div class='service-details'>
                                <h3>pla</h3>
                                <p>plaplaplaplaplaplaplaplaplaplaplaplaplapla</p>
                            </div>
                            <div class='service-actions'>
                                <form action='homepage.php' method='post'>
                                    <input type='hidden' name='service_id' value='5'>
                                    <button type='submit' name='response' value='accept'>Accept</button>
                                    <button type='submit' name='response' value='refuse'>Refuse</button>
                                </form>
                            </div>
                        </li>";
                $i++;}
                ?>
            </ul>
        </div>
    </div>
</body>
</html>
