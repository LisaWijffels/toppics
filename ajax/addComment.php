<?php

include_once("../classes/Db.class.php");
include_once("../classes/Comment.class.php");

    if (!empty($_POST)) {
        try
		{
            $comment = $_POST['comment'];
            $postID = $_POST['postID'];

            $db = Db::getInstance();
            $c = new Comment($db);
            $c->setcomment($comment);
            $c->setPostId($postID);
            $c->Save();

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