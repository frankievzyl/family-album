<?php
    session_start();
    
    $conn = NULL;

    if(!isset($_SESSION["connection"]))
    {
        //connect to database.
        $conn = new mysqli("localhost", "root", "", "media_collection"); 
    
        //check Connection 
        if($conn->connect_error)
        { 
            echo "Connection failed: " . $conn->connect_error;
        }
        else
        { 
            $_SESSION["connection"] = $conn; 
        }
    }
    else
    {
        $conn = $_SESSION["connection"];
    }
    
    //get number of users or single user
    if(!isset($_SESSION["userData"]))
    {
        $result = $conn->query("SELECT * FROM `user`"); 

        if($result->num_rows == 1)
        {  
            $_SESSION["userData"] = $result->fetch_assoc();
        }
        else if(null != $pk = $_POST["userPK"])
        {
            $result = $conn->query("SELECT * FROM `user` WHERE `PK` = $pk");
            $_SESSION["userData"] = $result->fetch_assoc();
        }
        else if($result->num_rows > 1)
        {
            header("Location: http://localhost/familyalbum/pages/userlogin.php");
        }
    }
    else
    {
        if($_SESSION["Bookmark_start"] == 1)
        {
            header("Location: http://localhost/familyalbum/pages/media.php");
        }
        else
        {
            header("Location: http://localhost/familyalbum/pages/albums.php");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Family Media</title>
</head>
<body>
    <h1>Getting things ready...</h1>
</body>
</html>