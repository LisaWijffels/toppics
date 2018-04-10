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
        
        $user_email = $_POST['profile_email'];
        $user->setEmail($user_email);
        $user->editEmail();
        
        $response = [
            "test" => "test",
            "user_email" => $user_email
        ];
        
        echo $user_email;
    }
?>