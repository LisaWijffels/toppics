<?php

include_once("../classes/Db.class.php");
include_once("../classes/Follow.class.php");

session_start();
    if( !empty($_POST) ){
        $lastId = $_POST['lastId'];

        $showposts = new Follow();

        $response['posts'] = $showposts->LoadMoreFollowPosts($lastId);
        $response['user'] = $_SESSION['username'];

        $response['status'] = "success";

        header('Content-Type: application/json');
	    echo json_encode($response);
        
    }
   
?>