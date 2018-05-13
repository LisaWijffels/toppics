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
    $followposts = Post::searchPosts($search);
        
} else {

    $showfollow = new Follow();
    $loggeduser = $_SESSION['username'];
    $showfollow->setLoggeduser($loggeduser);
    $followposts = $showfollow->ShowFollowedPosts($loggeduser);
}


$blocked = new Block();
$blocked->setUser_id($_SESSION['username']);
$checkBlock = $blocked->checkBlock();
$blockArray = [];
foreach($checkBlock as $b){
    array_push($blockArray, $b["post_id"]);
}

try{
    $checkfollowers = new Follow();
    $loggeduser = $_SESSION['username'];
    $checkfollowers->setLoggeduser($loggeduser);
    $checkfollowers->CheckFollower();

}
catch(Exception $e)
{
    $error = $e->getMessage();
}

try{
    $checkown = new Post();
    $loggeduser = $_SESSION['username'];
    $checkown->setLoggeduser($loggeduser);
    $ownposts = $checkown->CheckOwnPosts();
}
catch(Exception $e)
{
    $errorC = $e->getMessage();
}

$showOwn = new Post();
$loggeduser = $_SESSION['username'];
$showOwn->setLoggeduser($loggeduser);
$showOwnPosts = $showOwn->ShowOwnPosts();


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
    <div class="errorMessage hidden"></div>
    <main>
        <h1>DROP A TOP PIC</h1>

        <form action="" method="post" enctype="multipart/form-data" class="formToppic" id="postForm">
            <label for="post_image" class="file_upload">Upload an image</label>
            <input type="hidden" name="MAX_FILE_SIZE" value="10000" />
            <input type="file" name="post_image" id="post_image"><br>
            <div id="posted_image" class="hidden post_image_size"></div>
            <div>
                <p><span id="location"></span></p>
            </div>
            <input class="inputfield post_desc" type="text" name="post_desc" placeholder="What's your topic about?"><br>
            <label for="post_tags">Tags, separate them with a comma</label><br>
            <input class="inputfield post_tags" type="text" name="post_tags" placeholder="tags: summer, beach, ..."><br>
            <input class="button postForm__Button" id="buttondrop" type="submit" value="Drop it like it's hot">
        </form>
    </main>    

    <div class="friendsFollow">
        <?php if( !isset($error) ): ?>
            <h1>Hey, you don't follow any friends yet!</h3>
            <h3>Go and <a href="discover.php">discover</a> new toppics</h4>
        <?php endif; ?>
    </div>

    <div class="postList">

        <div class=feed>

                <?php if(isset($errorC)): ?>
                    <?php foreach ($showOwnPosts as $o): ?>
                    <div class="feed__post" data-id="<?php echo $o['post_id'] ?>">
                        

                        <div class="flexrow flex_between flex_align_center">
                        <a href="user.php?user=<?php echo $o['username']; ?>" data-id="<?php echo $o['id']; ?>" class="feed__postUser"><?php echo $o['username']?></a>
                            <?php if($o['username'] == $_SESSION['username']): ?>
                                <a class="link__edit button" title="edit picture" href="editpost.php?post=<?php echo $o['post_id']; ?>">✏️</a>
                            <?php endif; ?>
                            <a class="link__block button <?php if(in_array($o["post_id"], $blockArray)): ?>blocked<?php endif; ?>" href="#" title="report picture" data-id="<?php echo $o['post_id'] ?>">⛔</a>
                        </div>
                        <a href="details.php?post=<?php echo $o['post_id']; ?>" class="post__id" data-id="<?php echo $o['post_id']; ?>">
                        <img class="feed__postImg" src="post_images/ <?php echo $o['post_image']; ?>"></a>
                        <p class="feed__postDesc"><?php echo $o['post_desc']; ?></p>
                        
                        <div class="feed__flex">  
                            <p class="feed__postLikes" data-like="like" title="like" data-id="<?php echo $o['post_id']; ?>" >
                            💗<span class="postLikes">
                            <?php echo $o['post_likes']; ?></span> likes</p>

                            <a href="details.php?post=<?php echo $o['post_id']; ?>" title="comment" class="feed__postComments">💬</a>

                            <?php $timeago=get_timeago(strtotime($o['post_date'])); ?>
                            <p class="feed__postDate"><?php echo $timeago; ?></p>
   
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php endif; ?>

                <?php foreach ($followposts as $f): ?>
                    <div class="feed__post" data-id="<?php echo $f['post_id'] ?>">
                        

                        <div class="flexrow flex_between flex_align_center">
                        <a href="user.php?user=<?php echo $f['username']; ?>" data-id="<?php echo $u['id']; ?>" class="feed__postUser"><?php echo $f['username']?></a>
                            <?php if($f['username'] == $_SESSION['username']): ?>
                                <a class="link__edit button" title="edit picture" href="editpost.php?post=<?php echo $f['post_id']; ?>">✏️</a>
                            <?php endif; ?>
                            <a class="link__block button <?php if(in_array($f["post_id"], $blockArray)): ?>blocked<?php endif; ?>" title="report picture" href="#" data-id="<?php echo $f['post_id'] ?>">⛔</a>
                        </div>
                        <a href="details.php?post=<?php echo $f['post_id']; ?>" class="post__id" data-id="<?php echo $f['post_id']; ?>">
                        <img class="feed__postImg" src="post_images/ <?php echo $f['post_image']; ?>"></a>
                        <p class="feed__postDesc"><?php echo $f['post_desc']; ?></p>
                        
                        <div class="feed__flex">  
                            <p class="feed__postLikes" title="like" data-like="like" data-id="<?php echo $f['post_id']; ?>" >
                            💗<span class="postLikes">
                            <?php echo $f['post_likes']; ?></span> likes</p>

                            <a href="details.php?post=<?php echo $f['post_id']; ?>" title="comment" class="feed__postComments">💬</a>

                            <?php $timeago=get_timeago(strtotime($f['post_date'])); ?>
                            <p class="feed__postDate"><?php echo $timeago; ?></p>

                            
                        </div>
                    </div>
                <?php endforeach; ?>
        </div>

    <?php if( isset($errorC) || isset($error) ): ?>
        <div class="show_more_main">
            <span class="show_more_follow button">Show more</span>
        </div>
    <?php endif; ?>
    </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="script/createPost.js"></script>
<script src="script/showMore.js"></script>
<script src="script/likePost.js"></script>
<script src="script/getPostLocation.js"></script>


    
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