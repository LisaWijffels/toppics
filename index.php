<?php
session_start();

if(isset ($_SESSION['username'])){
    echo "logged user is ".$_SESSION['username'];
} else {
    header('Location: login.php');
}

include_once("classes/Post.class.php");

if ( isset($_GET['search']) ){
    $search = $_GET['search'];
    $posts = Post::searchPosts($search);
    echo $search;
    
} else {
    $posts = Post::ShowPosts();
    
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
        <h1>DROP A TOP PIC</h1>

        <form action="" method="post" enctype="multipart/form-data" class="formToppic" id="postForm">
            <label for="post_image" class="file_upload">Upload an image</label>
            <input type="file" name="post_image" id="post_image"><br>
            <div id="posted_image" class="hidden post_image_size"></div>
            <input class="inputfield post_desc" type="text" name="post_desc" placeholder="What's your topic about?"><br>
            <label for="post_tags">Fill in tags, separate them with ,</label><br>
            <input class="inputfield post_tags" type="text" name="post_tags" placeholder="summer, beach, ..."><br>
            <input class="button postForm__Button" id="buttondrop" type="submit" value="Drop it like it's hot">
        </form>
    </main>    

    <div class="postList">

        <div class=feed>

                <?php foreach ($posts as $p): ?>
                    <div class="feed__post">
                        
                        <div class="flexrow flex_between"><p class="feed__postUser"><?php echo $p['username']?></p><?php if($p['username'] == $_SESSION['username']): ?><a class="link__edit button" href="editpost.php?post=<?php echo $p['post_id']; ?>">✏️</a><?php endif; ?></div>
                        <a href="details.php?post=<?php echo $p['post_id']; ?>" class="post__id" data-id="<?php echo $p['post_id']; ?>">
                        <img class="feed__postImg" src="post_images/ <?php echo $p['post_image']; ?>"></a>
                        <p class="feed__postDesc"><?php echo $p['post_desc']; ?></p>
                        
                        <div class="feed__flex">  
                            <p class="feed__postLikes" data-id="<?php echo $p['post_id']; ?>" >💗<span class="postLikes" data-id="<?php echo $p['post_id']; ?>"><?php echo $p['post_likes']; ?></span> likes</p>
                            <a href="details.php?post=<?php echo $p['post_id']; ?>" class="feed__postComments">💬</a>
                            <p class="feed__postDate"><?php echo $p['post_date']; ?></p>
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
<script src="script/likePost.js"></script>
<script>
    $('.show_more').on("click", function(){
        console.log("Clicked loadmoare");
    });
</script>
    

</body>
</html>