<?php

include_once("../classes/Db.class.php");
include_once("../classes/Post.class.php");

    if (!empty($_POST)) 
    {

        session_start();
        $post_user = $_SESSION['username'];

    
            $likesUpdate = $_POST['likes'];
            $postID = $_POST['postID'];
            $likeUnlike = $_POST['likeUnlike'];

            $db = Db::getInstance();
            $l = new Post($db);
            $l->setPost_id($postID);
            $l->setPost_user_id($post_user);
            

            if($likeUnlike == "like")
            {
                $post_likes = $likesUpdate + 1;
                $response['status'] = 'success';
                $response['likes'] = $post_likes;
                $response['likeUnlike'] = 'unlike';
                $l->Likes($post_likes);

                
            }
            else if($likeUnlike == "unlike") 
            {
                $post_likes = $likesUpdate -1;
                $response['status'] = 'success';
                $response['likes'] = $post_likes;
                $response['likeUnlike'] = 'like';
                $l->Likes($post_likes);
                
            }

        header('Content-Type: application/json');
        echo json_encode( $response );

    }

    ?>