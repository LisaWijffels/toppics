<?php
include_once("../classes/Db.class.php");
include_once("../classes/Post.class.php");

    if( !empty($_POST) ){
        //deze functie wordt aangeroepen wanneer ajax functie start

        //data opslagen in databank
            $post_desc = $_POST['post_desc'];
        
            //$postId = $_POST['postId'];

            $db = Db::getInstance();
            
            $c = new Post($db);
            $c->setPost_desc($post_desc);
            //$c->setPostId($postId);
            $c->Save();
            
        //ajax antwoord geven -> start functie .done / als het niet lukt start functie .fail
            $response = [
                "test" => "test",
                "post_desc" => $post_desc

            ];
        
        
        
        //header('Content-Type: application/json');
        //echo json_encode($response);

        // LISA: Json doorgeven lukt niet, de res die aankomt in index.php is de echo

        echo $post_desc;
    }

?>