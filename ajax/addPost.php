<?php
include_once("../classes/Db.class.php");
include_once("../classes/Post.class.php");

    if(!empty($_POST)){
        //wat je als data meegeeft vanuit die $.ajax 
        $post = $_POST['post'];

        $db = Db::getInstance();
        //we gaan een klasse gebruiken zodat we dat nooit meer  2x moeten schrijven.
        $c = new Post($db);
        $c->setPost($post);
        $c->Save();

        //echo "oke";
        //echo "status: ok, comment: comment,";

        $response = [
            "status"    =>  "success",
            "post"   =>  $post

        ];
        
        header('Content-Type: application/json');
        echo json_encode($response);
    }

?>