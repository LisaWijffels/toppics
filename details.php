<?php
session_start();

if(isset ($_SESSION['username'])){
    echo "logged user is ".$_SESSION['username'];
} else {
    header('Location: login.php');
}

include_once("classes/Post.class.php");

if ( !empty($_GET) ){
    $postId = $_GET['post'];
    $db = Db::getInstance();
    $post = new Post($db);
    $post->setPost_id($postId);
    
    $postDetails = $post->postDetails();
    $postComments = $post->postComments();
    
} else {
    $error = true;
}

if ( isset($_GET['search']) ){
    $search = $_GET['search'];
    header('Location: index.php?search='.$search);
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
<body background="img/background2.png">

    <nav>
        <a href="index.php" id="aLogo"><img id="navLogo" src="img/logo2.png" alt="logo"></a>
        <a href="index.php" class="navItems">Home</a>
        <a href="profile.php" class="navItems">Profile</a>
        <a href="#" class="navItems">Discover</a>
        <a href="#" class="navItems">Friends</a>

        <form action="" method="get" id="searchNav">
            <input type="text" name="search" placeholder="Search a toppic!">
            
        </form>
    </nav>

    <main>
    <?php if(!isset($error) ): ?>
        <div class=feed>
            <div class="feed__post">
                <p class="feed__postUser">Dwayne johnson</p>
                <img class="feed__postImg" src="<?php echo $p[0]['post_image']; ?>">
                <p class="feed__postDesc"><?php echo $postDetails[0]['post_desc']; ?></p>
                <div class="feed__flex">  
                    <p class="feed__postLikes">💗<?php echo $postDetails[0]['post_likes']; ?> likes</p>
                    <p class="feed__postDate"><?php echo $postDetails[0]['post_date']; ?></p>
                </div>
            </div>
        </div>
        <?php foreach($postComments as $c): ?>
        <div class="feed__postDesc">
            <p class="feed__postUser"><?php echo $c['username']; ?></p>
            <p class="feed__postDesc"><?php echo $c['text']; ?></p>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
    </main>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    
    
</body>
</html>