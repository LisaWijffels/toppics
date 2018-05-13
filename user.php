<?php
include_once("datetime.php");
include_once("helpers/Security.class.php");

spl_autoload_register(function($class) {
    include_once("classes/" . $class . ".class.php");
});

session_start();

// Enkel deze pagina tonen als er een user ingelogged is
if(isset ($_SESSION['username']) ){
    $loggeduser = $_SESSION['username'];
    //echo "logged user is ".$loggeduser;
} else {
    header('Location: login.php');
}

if ( isset($_GET['search']) ){
    $search = $_GET['search'];
    header('Location: index.php?search='.$search);
}

if ( !empty($_GET) ){
    $username = $_GET['user'];
    $db = Db::getInstance();
    $user = new User($db);
    $user->setUsername($username);
    $Userposts = $user->showUserPosts($username);
    
} else {
    $error = true;
}

try{
    $userfollow = new Follow();
    $username = $_GET['user'];
    $loggeduser = $_SESSION['username'];
    $userfollow->setUsername($username);
    $userfollow->setLoggeduser($loggeduser);
    $userfollow->CheckFollow();
}
catch(Exception $e)
{
    $errorF = $e->getMessage();
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

    <div class="userFollow">
        <p class="followed"> </p>

        <?php if(!isset($errorF)): ?>
            <input type="text" value="+ follow" class="follow button">  
        <?php endif; ?>
    </div>

<div class="postList">

<div class=feed>

        <?php foreach ($Userposts as $u): ?>
            <div class="feed__post" data-id="<?php echo $u[0]['post_id'] ?>">
                
                <div class="flexrow flex_between"><a href="user.php?user=<?php echo $u['username']; ?>" data-id="<?php echo $u['id']; ?>" class="feed__postUser"><?php echo $u['username']?>
                </a><?php if($u['username'] == $_SESSION['username']): ?>
                <a class="link__edit button" title="edit picture" href="editpost.php?post=<?php echo $u[0]['post_id']; ?>">✏️</a><?php endif; ?>
                <a class="link__block button <?php if(in_array($o["post_id"], $blockArray)): ?>blocked<?php endif; ?>" href="#" title="report picture" data-id="<?php echo $o['post_id'] ?>">⛔</a>
                </div>
               
                <a href="details.php?post=<?php echo $u['post_id']; ?>" class="post__id" data-id="<?php echo $u[0]['post_id']; ?>">
                <img class="feed__postImg" src="post_images/ <?php echo $u['post_image']; ?>"></a>
                <p class="feed__postDesc"><?php echo $u['post_desc']; ?></p>
                
                <div class="feed__flex">  
                    <p class="feed__postLikes" data-like="like" title="like" data-id="<?php echo $u['post_id']; ?>" >
                    💗<span class="postLikes">
                    <?php echo $u['post_likes']; ?></span> likes</p>

                    <a href="details.php?post=<?php echo $u['post_id']; ?>" title="comment" class="feed__postComments">💬</a>

                    <?php $timeago=get_timeago(strtotime($u['post_date'])); ?>
                    <p class="feed__postDate"><?php echo $timeago; ?></p>

                    
                </div>
            </div>
        <?php endforeach; ?>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="script/follow.js"></script>
<script src="script/likePost.js"></script>

</body>
</html>