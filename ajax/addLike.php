<?php

include_once("../classes/Db.class.php");
include_once("../classes/Post.class.php");

    if (!empty($_POST)) {
        try
		{
            $likes = $_POST['likes'];
            $postID = $_POST['postID'];

            $db = Db::getInstance();
            $l = new Post($db);
            $l->Likes($likes);
            $l->setPost_id($postID);
            $l->Save();

            $lupdate = $likes + 1;

            $response['status'] = 'success';
            $response['likes'] = $lupdate;
        
        }

        catch(Exception $e)
		{
			$response['status'] = 'error';
		}

        header('Content-Type: application/json');
        echo json_encode( $response );

    }

    ?>