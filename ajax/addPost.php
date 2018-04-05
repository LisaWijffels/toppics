<?php
include_once("../classes/Db.class.php");
include_once("../classes/Post.class.php");

    if(!empty($_POST)){
        //wat je als data meegeeft vanuit die $.ajax 
        $post_desc = $_POST['post_desc'];
        
        //$postId = $_POST['postId'];

        $db = Db::getInstance();
        //we gaan een klasse gebruiken zodat we dat nooit meer  2x moeten schrijven.
        $c = new Post($db);
        $c->setPost_desc($post_desc);
        //$c->setPostId($postId);
        $c->Save();


        $response = [
            "test" => "test",
            "post_desc" => $post_desc

        ];
        
        header('Content-Type: application/json');
        echo json_encode($response);
    }

?>