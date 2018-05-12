<?php

spl_autoload_register(function($class) {
    include_once("classes/" . $class . ".class.php");
});

session_start();

if(!isset ($_SESSION['username'])){
    header('Location: login.php');
}

include_once("datetime.php");


if ( !empty($_GET) ){
    $postId = $_GET['post'];
    $db = Db::getInstance();
    $post = new Post($db);
    $post->setPost_id($postId);
    
    $postDetails = $post->postDetails();
    $postTags = $post->postTags();
    
    $postComments = $post->postComments();

    $postLocation = $post->postLocation();
    
} else {
    $error = true;
}

if ( isset($_GET['search']) ){
    $search = $_GET['search'];
    header('Location: index.php?search='.$search);
}

if(isset($_POST['postForm__button'])){
    $c = new Comment($db);
	$c->setcomment($comment);
    $c->setPostId($postID);
	$c->Save();
}

try{
    $allComments = Comment::getAll($postId);
} catch(Exception $e){
    $error_noComments = $e->getMessage();
}



?>
<?php include_once("helpers/colorPalette.php"); ?>
<!DOCTYPE html>
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
            <div class="feed">
                <div class="feed__post">
                    <p class="feed__postUser"><?php echo $postDetails[0]['username']?></p>
                    <?php foreach($postLocation as $l): ?>
                            <div>
                                <p class="locationpost"> 🌍<span class="post_location"><?php echo $l['location_name'] ?></span></p>
                            </div>
                        <?php endforeach; ?>
                    <a href="details.php?post=<?php echo $postDetails[0]['post_id']; ?>" class="post__id" data-id="<?php echo $postDetails[0]['post_id']; ?>">
                    <img class="feed__postImg" src="post_images/ <?php echo $postDetails[0]['post_image']; ?>"></a>
                    <p class="feed__postDesc"><?php echo $postDetails[0]['post_desc']; ?></p>
                    <p class="feed__postTag feed__postDesc">Tags: 
                        <?php foreach($postTags as $t): ?>
                            <?php echo $t['tag_name']; ?>
                        <?php endforeach; ?>
                    </p>
                    <div class="feed__flex">  
                        <p class="feed__postLikes">💗<?php echo $postDetails[0]['post_likes']; ?> likes</p>
                        
                        <?php $timeago=get_timeago(strtotime($postDetails[0]['post_date'])); ?>
                            <p class="feed__postDate"><?php echo $timeago; ?></p>
                    </div>
                
                        <div class="newComment">
                            <div class="feed__line"> </div>
                            <?php if(isset($error_noComments)): ?>
                            <?php echo $error_noComments ?>
                            <?php else: ?>
                            <?php foreach($allComments as $comment): ?>
                            <div class="feed__Comments">
                                <p class="feed__commentUser"><?php echo $postDetails[0]['username']; ?></p>
                                <p class="feed__Comment"><?php echo $comment["text"]; ?></p>
                            </div>
                            <div class="feed__line"> </div>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    
                    
                    <div class="postForm">
                        <form action="" method="post" class="postForm__form">
                            <input type="text" placeholder="Add a comment" class="postForm__text" name="commentText">
                            <input type="submit" value="Post" class="postForm__button button">
                        </form>
                    </div>
                </div>
                <div id="colors">

                    <?php foreach($palette as $p):?>
                    <div class="colorBlock" style="background:#<?php echo $p ?>"> </div>
                    <?php endforeach;?>
                </div>
            </div>
            

        <?php endif; ?>
    </main>

   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <script src="script/likePost.js"></script>
   <script src="script/getPostLocation.js"></script>
   
   
    <script>
        $(".postForm__button").on("click", function(e){
            let comment = $(".postForm__text").val();
            let postID = $(".post__id").attr("data-id");
            //console.log(postID);

            // to database
            $.ajax({
                 method: "POST",
                 url: "ajax/addComment.php",
                 data: { comment: comment, postID: postID }
            })
            .done(function( res ) {

                if( res.status == "success") {
                    // append new comment
                    var newComment = `
                    <div class="feed__Comments">
                    <p class="feed__commentUser">${res.user}</p>
                    <p class="feed__Comment">${res.comment}</p></div>
                    <div class="feed__line"> </div>`;
                    $(".newComment").append(newComment);
                    $(".feed__Comments").slideDown();
                    $(".postForm__text").val("");
                }
            });

            e.preventDefault();
        });
    </script>
</body>
</html>