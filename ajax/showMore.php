<?php

include_once("../classes/Db.class.php");
include_once("../classes/Post.class.php");
session_start();
    if( !empty($_POST) ){
        $lastId = $_POST['lastId'];
        $feedback['posts'] = Post::LoadMore($lastId);
        $feedback['user'] = $_SESSION['username'];

        

        header('Content-Type: application/json');
	    echo json_encode($feedback);
        
    }
   
?>