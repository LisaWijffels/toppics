<?php
session_start();

spl_autoload_register(function($class) {
    include_once("classes/" . $class . ".class.php");
});

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

if ( isset($_GET['search']) ){
    $search = $_GET['search'];
    header('Location: index.php?search='.$search);
}

if(!isset($_SESSION['username']) ){
    header('Location: login.php');
}

if($_SESSION['username'] != $postDetails[0]['username']){
    $myPost = false;
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
    <?php if(!isset($error) ): ?>
    <?php if(!isset($myPost) ): ?>
    <main id="mainEditPost">
    
        

        <div id="post_id" data-id="<?php echo $postId ?>">
            <img class="feed__postImg" src="post_images/ <?php echo $postDetails[0]['post_image']; ?>">
        </div>
        <div id="postEditBlock">
            <div>
                <h3>Description</h3>
                <p id="valueDesc" class="visible"><?php echo $postDetails[0]['post_desc']; ?></p>
                <div id="formEditDesc" class="hidden">
                    <form method="post">
                        <input class="inputfield" type="text" name="postDesc" value="<?php echo $postDetails[0]['post_desc'] ?>"><br>
                        <input class="button" type="submit" name="btnPostDesc" value="Confirm">
                    </form>
                </div>
                <div>
                    <a href="#" id="editPostDesc" class="button">Edit description</a>
                </div>    
            </div>
            <div>
                <h3>Tags</h3>
                <p id="taglist">
                    <?php foreach($postTags as $t): ?>
                        <div class="flexrow flex_between">
                            <?php echo $t['tag_name']; ?>
                            <a href="#" class="delete_tag link__delete" data-tag-id="<?php echo $t['id']; ?>">Delete</a>
                        </div>
                    <?php endforeach; ?>
                </p>
                
                <form method="post">
                    <div class="flexrow flex_between flex_align_center addTag">
                        <input type="text" name="addTag" id="addTag" class="taginput" placeholder="type a tag">
                        <input type="submit" value="Voeg tag toe" class="button" id="btnAddTag">
                    </div>  
                </form>
            </div>
                 
        </div>
        
    
    </main>
    
    <a class="center button btn__delete" id="btnDeletePost" href="deletepost.php?post=<?php echo $postDetails[0]['post_id']; ?>">Delete post</a>
    <?php else: ?>
        <p> You are not authorized to edit this post.</p>
    <?php endif; ?>
    <?php endif; ?>
    

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="script/editPost.js"></script>
    
</body>
</html>