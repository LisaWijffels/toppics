<?php
session_start();



include_once("classes/Post.class.php");

if ( !empty($_GET) ){
    $postId = $_GET['post'];
    $db = Db::getInstance();
    $post = new Post($db);
    $post->setPost_id($postId);
    
    $postDetails = $post->postDetails();
    $postTags = $post->postTags();
    $postComments = $post->postComments();
    
} else {
    $error = true;
}

if(isset ($_SESSION['username']) && $_SESSION['username'] == $postDetails[0]['username'] ){
    
} else {
    header('Location: login.php');
}

if ( isset($_GET['search']) ){
    $search = $_GET['search'];
    header('Location: index.php?search='.$search);
}

if(isset($_POST["yesDelete"]) ){
    $response = $post->deletePost();
    if($response == 1){
        header('Location: index.php');
    }
}

if(isset($_POST["noDelete"]) ){
    header('Location: editpost.php?post='.$postId);
    
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

    <main>
    <?php if(!isset($error) ): ?>
        <div>
            <div class="text-align-center">
                <p>Are you sure you want to delete this post?</p>
                <div class="flexrow flex_justify_center">
                    <form method="post">
                        <input type="submit" value="No" name="noDelete">
                    </form>

                    <form method="post">
                        <input type="submit" value="Yes" name="yesDelete">
                    </form>
                    
                </div>
            </div>
            
            <div class="feed__post center">
                
                <p class="feed__postUser"><?php echo $postDetails[0]['username']?></p>
                <img class="feed__postImg" src="post_images/ <?php echo $postDetails[0]['post_image']; ?>">
                <p class="feed__postDesc"><?php echo $postDetails[0]['post_desc']; ?></p>
                <p class="feed__postTag feed__postDesc">Tags: 
                    <?php foreach($postTags as $t): ?>
                        <?php echo $t['tag_name']; ?>
                    <?php endforeach; ?>
                </p>
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