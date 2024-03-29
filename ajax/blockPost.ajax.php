<?php

include_once("../classes/Block.class.php");
include_once("../classes/Post.class.php");
session_start();

if( !empty($_POST) ){
    $post_id = $_POST['post_id'];
    $user_id = $_SESSION['username'];
    $isBlocked = $_POST['blocked'];

    $blocked = new Block();

    $blocked->setPost_id($post_id);
    $blocked->setUser_id($user_id);

    if($isBlocked == "yes"){
        $feedback['removed'] = $blocked->Remove();
    } else {
        $feedback['result'] = $blocked->Save();
        $count = $blocked ->Count();
        if($count >= 3){
            $feedback['count'] = "Count exceeded";
            $post = new Post();
            $post->setPost_id($post_id);
            $feedback['deleted'] = $post->hidePost();

        } else {
            $feedback['count'] = $count;
        }
    }
    
    header('Content-Type: application/json');
    echo json_encode($feedback);
    
}
