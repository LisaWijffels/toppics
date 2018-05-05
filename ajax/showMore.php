<?php

include_once("../classes/Db.class.php");
include_once("../classes/Post.class.php");
    if( !empty($_POST) ){
        $lastId = $_POST['lastId'];
        $posts = Post::LoadMore($lastId);

        

        header('Content-Type: application/json');
	    echo json_encode($posts);
        
    }
   
?>