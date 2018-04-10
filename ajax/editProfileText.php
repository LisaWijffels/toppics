<?php
include_once("../classes/Db.class.php");
include_once("../classes/Post.class.php");
include_once("../classes/User.class.php");

    if( !empty($_POST) ){
        session_start();
        $loggeduser = $_SESSION['username'];
        
        $db = Db::getInstance();
        $user = new User($db);
        $user->setUsername($loggeduser);
        
        $user_text = $_POST['profile_text'];
        $user->setUsertext($user_text);
        $user->editText();
        
        $response = [
            "test" => "test",
            "user_text" => $user_text
        ];
        
        echo $user_text;
    }
?>