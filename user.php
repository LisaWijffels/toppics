<?php
include_once("datetime.php");
include_once("classes/Db.class.php");
include_once("classes/User.class.php");
include_once("classes/Post.class.php");
include_once("classes/Comment.class.php");
include_once("helpers/Security.class.php");

session_start();

// Enkel deze pagina tonen als er een user ingelogged is
if(isset ($_SESSION['username']) ){
    $loggeduser = $_SESSION['username'];
    echo "logged user is ".$loggeduser;
} else {
    header('Location: login.php');
}

if ( !empty($_GET) ){
    $username = $_GET['user'];
    $db = Db::getInstance();
    $user = new User($db);
    $user->setUsername($username);

    $Userposts = User::showUserPosts($username);
    
} else {
    $error = true;
}




?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <title>Top Pics</title>
</head>
<body>

    <?php include_once("nav.inc.php"); ?>

<div class="postList">

<div class=feed>

        <?php foreach ($Userposts as $u): ?>
            <div class="feed__post" data-id="<?php echo $u[0]['post_id'] ?>">
                
                <div class="flexrow flex_between"><a href="user.php?user=<?php echo $p['username']; ?>" class="feed__postUser"><?php echo $u['username']?>
                </a><?php if($u['username'] == $_SESSION['username']): ?>
                <a class="link__edit button" href="editpost.php?post=<?php echo $u[0]['post_id']; ?>">✏️</a><?php endif; ?></div>
                <a href="details.php?post=<?php echo $u[0]['post_id']; ?>" class="post__id" data-id="<?php echo $u[0]['post_id']; ?>">
                <img class="feed__postImg" src="post_images/ <?php echo $u['post_image']; ?>"></a>
                <p class="feed__postDesc"><?php echo $u['post_desc']; ?></p>
                
                <div class="feed__flex">  
                    <p class="feed__postLikes" data-like="like" data-id="<?php echo $u[0]['post_id']; ?>" >
                    💗<span class="postLikes">
                    <?php echo $u['post_likes']; ?></span> likes</p>

                    <a href="details.php?post=<?php echo $u['post_id']; ?>" class="feed__postComments">💬</a>

                    <?php $timeago=get_timeago(strtotime($u['post_date'])); ?>
                    <p class="feed__postDate"><?php echo $timeago; ?></p>

                    
                </div>
            </div>
        <?php endforeach; ?>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


</body>
</html>