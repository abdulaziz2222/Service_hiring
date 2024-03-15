<?php
    session_start();
    if(!isset($_SESSION["login"]))
        header("location:signin.html?eror=Please Sign In!");    
    include 'db_config.php';
    $con =mysqli_connect(DBHOST,DBUSER,DBPWD,DBNAME);
    $servID="";
    if(mysqli_connect_errno()){
        die("Cannot connect to db ".mysqli_connect_error());
        }   
        
        $des =$_POST["description"];
        $tit =$_POST["title"];
        $ph =$_SESSION["phone"];
        $sql1 ="INSERT INTO service_item (title,description,phone) values ('$tit','$des','$ph')";
        if($con->query($sql1)===TRUE){          
        }else{    
            die("Can not post this service ");
        }
        $queryFI = "SELECT service_ID FROM service_item WHERE phone='$ph' AND description='$des' AND title='$tit'";
        $rowFI = mysqli_query($con,$queryFI);
    if ($rowFI) {
        $rowSelF = mysqli_fetch_assoc($rowFI);
        $valueFID = $rowSelF['service_ID'];
        $servID=$valueFID;
        } else {
        // Handle query error
        echo "Error executing the query: " . mysqli_error($con);
    }   
        $fileCount = count($_FILES["images"]["name"]);
        for($i=0;$i<$fileCount;$i++){
            $fileName = $_FILES['images']['name'][$i];
            $sql ="INSERT INTO `imagesofservice` (`img_id`, `img_name`, `serviceID`) VALUES (NULL, '$fileName', '$servID');";
            if($con->query($sql)===TRUE){
            }else{    
                die("Can not post service ");
            }
            move_uploaded_file($_FILES['images']['tmp_name'][$i],'img/'.$fileName);    
        }
        header("location:homepage.php");
    mysqli_close($con);   
?>