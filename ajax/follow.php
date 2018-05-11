<?php

include_once("../classes/Db.class.php");
include_once("../classes/User.class.php");
include_once("../classes/Follow.class.php");
session_start();
       
            $username = $_POST['user'];
            $loggeduser = $_SESSION['username'];

            $f = new Follow();
            $f->setLoggeduser($loggeduser);
            $f->FollowFriends($username);
        
            $response['status'] = 'success';
        
        
        header('Content-Type: application/json');
        echo json_encode( $response );


?>