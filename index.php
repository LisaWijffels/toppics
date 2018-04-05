<?php
session_start();

if(isset ($_SESSION['username'])){
    echo "logged user is ".$_SESSION['username'];
} else {
    header('Location: login.php');
}

include_once("classes/Post.class.php");

$posts = Post::showPosts();

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
        <a href="#" class="navItems">Profile</a>
        <a href="#" class="navItems">Discover</a>
        <a href="#" class="navItems">Friends</a>

        <form action="" method="get" id="searchNav">
            <input type="text" name="search" value="search">
        </form>
    </nav>

    <main>
        <h1>DROP A TOP PIC</h1>

    <form action="" method="post" class="formToppic">
        <input class="inputfield post_desc" type="text" name="post_desc" placeholder="What's your topic about?"><br>
        <!--<input class="button" id="buttonplus" type="file" value="+">!-->
        <input class="button postForm__Button" id="buttondrop" type="submit" value="Drop it like it's hot">
    </form>

    <div class=feed>
        <div class="feed__post">

        <?php foreach ($posts as $p): ?>

            <strong class="feed__postUser">Dwayne johnson</strong>
            <img src="<?php echo $p['post_image']; ?>">
            <p class="feed__postDesc"><?php echo $p['post_desc']; ?></p>
            <p class="feed__postLikes"><?php echo $p['post_likes']; ?></p>
            <p class="feed__postDate"><?php echo $p['post_date']; ?></p>

        <?php endforeach; ?>
        </div>
    </div>
    </main>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    
    <script>
        $(".postForm__button").on("click", function(e) {
            var post_desc = $(".post_desc").val();
            
            
            /*var post_id = <?php echo $_GET['post_id']; ?>;*/

            //TO DATABASS?
            $.ajax({
                //post want we willen het plaatsen onder de post
                type: "POST",
                //Data brengen naar addPost
                url: "ajax/addPost.php",
                data: { post_desc: post_desc}
            }).done(function( res ) {
                console.log( "Data Saved: " + res );
                if(res.test == "test") {
                    //append new post
                    var newPost = `<div><strong class="feed__postUser">Dwayne johnson</strong><p class="feed__postText">${res.post_desc}</p></div>`;
                    $(".feed__post").append(newPost);
                    
                } else {
                    console.log("??");
                }
            });
            // code testing
            //console.log("clicked");
            //console.log("This is post_desc "+post_desc);
            //als je klinkt mag je pagina niet refreshen
            e.preventDefault();
        });
    </script>
</body>
</html>