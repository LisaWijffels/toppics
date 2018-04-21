<?php
    include_once("../classes/Post.class.php");
    session_start();

    

    $post = new Post();

    

    try{
        $post_image = $_FILES['post_image'];
        $post_desc = $_POST['post_desc'];
        $post_user = $_SESSION['username'];
        
        $post->setPost_user_id($post_user);
        $post->setPost_desc($post_desc);
        $post->setPost_image($post_image);
        $id = $post->Save();
        $feedback['post_id'] = $id;
        $feedback['post_date'] = date('Y-m-d');
        $feedback['post_image'] = $post->getPost_image();
        $feedback['post_user'] = $post_user;
        $feedback['status'] = "success";
    } catch(Exception $e){
		$feedback['status'] = "error";
    }
        
    header('Content-Type: application/json');
	echo json_encode($feedback);
            
    

?>