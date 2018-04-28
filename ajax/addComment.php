<?php

include_once("../classes/Db.class.php");
include_once("../classes/Comment.class.php");

    if (!empty($_POST)) {
        $comment = $_POST['comment'];
        $postID = $_POST['postID'];

        $db = Db::getInstance();
        $c = new Comment($db);
        $c->setcomment($comment);
        $c->setPostId($postID);
        $c->Save();

        $response = [
            "status" => "success",
            "comment" => $comment,
        ];

        header('Content-Type: application/json');
        echo json_encode( $response );
    }

?>