<?php

include_once("../classes/Db.class.php");
include_once("../classes/Post.class.php");

    if (!empty($_POST)) {
        try
		{
            $likesUpdate = $_POST['likes'];
            $postID = $_POST['postID'];
            $likeUnlike = $_POST['likeUnlike'];

            $db = Db::getInstance();
            $l = new Post($db);
            $l->setPost_id($postID);
            

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

        
        }

        catch(Exception $e)
		{
			$response['status'] = 'error';
		}

        header('Content-Type: application/json');
        echo json_encode( $response );

    }

    ?>