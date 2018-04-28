<?php
include_once("../classes/Db.class.php");
include_once("../classes/Post.class.php");


    if( !empty($_POST) ){
             
        $tag_id = $_POST['tag_id'];
        $conn = Db::getInstance();
        $stm = $conn->prepare("DELETE FROM tags WHERE id = :id");
        $stm->bindValue(":id", $tag_id);
        
        $response = $stm->execute();
        
        echo $response;
    }
?>