<?php
include_once("../classes/Db.class.php");
include_once("../classes/Post.class.php");
include_once("../classes/User.class.php");

    if( !empty($_POST) ){
             
        $db = Db::getInstance();
        $post = new Post($db);
        $post->setPost_id($_POST['post_id']);
        
        $post_desc = $_POST['post_desc'];
        $post->setPost_desc($post_desc);
        $post->editDesc();
        
        $response = [
            "test" => "test",
            "post_desc" => $post_desc
        ];
        
        echo $post_desc;
    }
?>