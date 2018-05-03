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
            $l->setPostId($postID);
            $l->Save();
        }

        catch(Exception $e)
		{
			$response['status'] = 'error';
		}

        header('Content-Type: application/json');
        echo json_encode( $response );

    }

    ?>