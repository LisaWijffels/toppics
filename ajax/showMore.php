<?php

include_once("../classes/Db.class.php");
include_once("../classes/Post.class.php");

    if(isset($_POST['lastmsg'])) {
    try {
        $lastmsg=$_POST['lastmsg'];
        $lastmsg=mysql_real_escape_string($lastmsg);

        $db = Db::getInstance();
        $result=mysql_query("SELECT posts.post_id, post_desc, post_image, post_likes, post_date, username FROM posts, users WHERE posts.post_user_id = users.id < '$lastmsg' ORDER BY post_date desc limit 20");
        $result->fetchAll(PDO::FETCH_ASSOC);

        $response['status'] = 'success';
    }

    catch(Exception $e)
		{
			$response['status'] = 'error';
		}

        header('Content-Type: application/json');
        echo json_encode( $response );

    }
?>