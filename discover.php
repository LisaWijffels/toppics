<?php

spl_autoload_register(function($class) {
    include_once("classes/" . $class . ".class.php");
});

include_once("datetime.php");

session_start();

if(isset ($_SESSION['username'])){
    //echo "logged user is ".$_SESSION['username'];
} else {
    header('Location: login.php');
}

if ( isset($_GET['search']) ){
    $search = $_GET['search'];
    $posts = Post::searchPosts($search);
    var_dump($posts);
        
} else {
    $getposts = new Post();
    $loggeduser = $_SESSION['username'];
    $getposts->setLoggeduser($loggeduser);
    $posts = $getposts->ShowPosts();    
}


$blocked = new Block();
$blocked->setUser_id($_SESSION['username']);
$checkBlock = $blocked->checkBlock();
$blockArray = [];
foreach($checkBlock as $b){
    array_push($blockArray, $b["post_id"]);
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

                <?php foreach ($posts as $p): ?>
                    <div class="feed__post" data-id="<?php echo $p['post_id'] ?>">
                        

                        <div class="flexrow flex_between">
                        <a href="user.php?user=<?php echo $p['username']; ?>" data-id="<?php echo $p['id']; ?>" class="feed__postUser"><?php echo $p['username']?></a>
                            <?php if($p['username'] == $_SESSION['username']): ?>
                                <a class="link__edit button" title="edit picture"  href="editpost.php?post=<?php echo $p['post_id']; ?>">✏️</a>
                            <?php endif; ?>
                            <a class="link__block button <?php if(in_array($p["post_id"], $blockArray)): ?>blocked<?php endif; ?>" href="#" title="report picture" data-id="<?php echo $p['post_id'] ?>">⛔</a>
                        </div>
                        <a href="details.php?post=<?php echo $p['post_id']; ?>" class="post__id" data-id="<?php echo $p['post_id']; ?>">
                        <img class="feed__postImg" src="post_images/ <?php echo $p['post_image']; ?>"></a>
                        <p class="feed__postDesc"><?php echo $p['post_desc']; ?></p>
                        
                        <div class="feed__flex">  
                            <p class="feed__postLikes" title="like" data-like="like" data-id="<?php echo $p['post_id']; ?>" >
                            💗<span class="postLikes">
                            <?php echo $p['post_likes']; ?></span> likes</p>

                            <a href="details.php?post=<?php echo $p['post_id']; ?>" title="comment" class="feed__postComments">💬</a>

                            <?php $timeago=get_timeago(strtotime($p['post_date'])); ?>
                            <p data-date="<?php echo $p['post_date'];?>" class="feed__postDate"><?php echo $timeago; ?></p>

                            
                        </div>
                    </div>
                <?php endforeach; ?>
        </div>

        <div class="show_more_main">
            <span class="show_more button">Show more</span>
        </div>
    </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="script/createPost.js"></script>
<script src="script/showMore.js"></script>
<script src="script/likePost.js"></script>

    
<script>

    $(".link__block").on("click", function(e){
        
        e.preventDefault();
        var clicked = $(this);
        var post_id = $(this).attr("data-id");
        var blocked = "no";
        
        if($(this).hasClass("blocked") == false){
            blocked = "no";
            
        } else {
            blocked = "yes";
            
        }

        $.ajax({
            method: "POST",
            url: "ajax/blockPost.ajax.php",
            data: { post_id: post_id, blocked: blocked },
        }).done(function( res ) {
            if(res.result == 1){
                clicked.addClass("blocked");
            }
            if(res.removed == 1){
                clicked.removeClass("blocked");
            }

            if(res.deleted != undefined){
                
                $('.feed__post[data-id='+post_id+']').fadeOut()
            }
            
        });
    });
    

    
</script>

</body>
</html>