<?php

include_once("../classes/Db.class.php");
include_once("../classes/Comment.class.php");

    if (!empty($_POST)) {
        $comment = $_POST['comment'];
        $postID = $_POST['post_id'];

        $db = Db::getInstance();
        $c = new Comment($db);
        $c->setcomment($comment);
        $c->setPostId($postId);
        $c->Save();

        $response = [
            "status" => "succes",
            "comment" => $comment,
        ];

        header('Content-Type: application/json');
        echo json_encode( $response );
    }

?>