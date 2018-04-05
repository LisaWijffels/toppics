<?php
include_once("../classes/Db.class.php");
include_once("../classes/Post.class.php");

    if(!empty($_POST)){
        //wat je als data meegeeft vanuit die $.ajax 
        $comment = $_POST['comment'];
        $postId = $_POST['postId'];

        $db = Db::getInstance();
        //we gaan een klasse gebruiken zodat we dat nooit meer  2x moeten schrijven.
        $c = new Post($db);
        $c->setPost($comment);
        $c->setPostId($postId);
        $c->Save();

        //echo "oke";
        //echo "status: ok, comment: comment,";

        $response = [
            "status"    =>  "success",
            "comment"   =>  $comment

        ];
        
        header('Content-Type: application/json');
        echo json_encode($response);
    }

?>