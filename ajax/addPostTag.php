<?php
include_once("../classes/Db.class.php");
include_once("../classes/Post.class.php");
include_once("../classes/User.class.php");

    if( !empty($_POST) ){
             
        $db = Db::getInstance();
        $post = new Post($db);
        $post->setPost_id($_POST['post_id']);
        
        $tag_name = $_POST['tag_name'];
        $feedback['tag'] = $post->saveTags($tag_name);
        $feedback['id'] = $_POST['post_id'];
        
        
        
        
        header('Content-Type: application/json');
	    echo json_encode($feedback);
    }
?>