<?php
   /*session_start();   
    
    //get number of users or single user
    
    else
    {   after login
        if($_SESSION["BookmarkStart"] == 1)
        {
            header("Location: http://localhost/familyalbum/pages/media.php");
        }
        else
        {
            header("Location: http://localhost/familyalbum/pages/albums.php");
        }
    }*/
    require_once('database.php');

	if (isset($_GET['controller']) && isset($_GET['action'])) {
		$controller = $_GET['controller'];
		$action		= $_GET['action'];
	} else {
		$controller = 'user';
		$action		= 'log_in';
	}

	require_once('views/layout.php');
?>