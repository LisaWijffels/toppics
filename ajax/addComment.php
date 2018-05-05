<?php

include_once("../classes/Db.class.php");
include_once("../classes/Comment.class.php");
session_start();

    if (!empty($_POST)) {
        try
		{
            $comment = $_POST['comment'];
            $postID = $_POST['postID'];
            $userId = $_SESSION['username'];

            $c = new Comment();
            $c->setcomment($comment);
            $c->setPostId($postID);
            $c->setUser_id($userId);
            $c->Save();
            $response['user'] = $userId;
            $response['status'] = 'success';
			$response['comment'] = htmlspecialchars($_POST['comment']);
        }

        catch(Exception $e)
		{
			$response['status'] = 'error';
		}

        header('Content-Type: application/json');
        echo json_encode( $response );
    }

?>