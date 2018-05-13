<?php

include_once("../classes/Db.class.php");
include_once("../classes/Post.class.php");
session_start();
    if( !empty($_POST) ){
        $lastId = $_POST['lastId'];
        $loggeduser = $_SESSION['username'];

        $showpost = new Post();
        $showpost->setLoggeduser($loggeduser);

        $feedback['posts'] = $showpost->LoadMore($lastId);
        $feedback['user'] = $_SESSION['username'];

        $date = $_POST['date'];
        $feedback['date'] = $timeago=get_timeago(strtotime($date));
            

        header('Content-Type: application/json');
	    echo json_encode($feedback);
        
    }
   
?>