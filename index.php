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
        <h1>DROP A TOP PIC</h1>

        <form action="" method="post" enctype="multipart/form-data" class="formToppic" id="postForm">
            <input type="file" name="post_image" id="post_image"><br>
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
                        <p class="feed__postUser"><?php echo $p['username']?></p>
                        <a href="details.php?post=<?php echo $p['post_id']; ?>">
                        <img class="feed__postImg" src="post_images/ <?php echo $p['post_image']; ?>"></a>
                        <p class="feed__postDesc"><?php echo $p['post_desc']; ?></p>
                        <p class="feed__postTag">Tags <?php echo $p['tag_name']; ?></p>
                        <div class="feed__flex">  
                            <p class="feed__postLikes">💗<?php echo $p['post_likes']; ?> likes</p>
                            <p class="feed__postDate"><?php echo $p['post_date']; ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
        </div>

        <div class="show_more_main">
            <span class="show_more">Show more</span>
        </div>
    </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    
    <script>
        $("#buttondrop").on("click", function(e) {
            e.preventDefault();

            var file = $('#post_image')[0].files[0];
            var post_desc = $(".post_desc").val();
            var post_tags = $(".post_tags").val();
            
            var form = new FormData();
            form.append("post_image", file);
            form.append("post_desc", post_desc);
            form.append("post_tags", post_tags);
            
            $.ajax({
                type: "POST",
                url: "ajax/addPost.ajax.php",
                data: form,
                contentType: false,
                processData: false,
            }).done(function( res ) {
                console.log( "Data Saved: " + res.status );
                if(res.status == "success") {
                    //append new post
                    console.log("Ajax was successfull");
                    
                    var newPost = `
                    <div class="feed__post">
                        <p class="feed__postUser">${res.post_user}</p>
                        <img class="feed__postImg" src="post_images/ ${res.post_image}"></a>
                        <p class="feed__postDesc">${post_desc}</p>
                        <div class="feed__flex">  
                            <p class="feed__postLikes">💗${"0"} likes</p>
                            <p class="feed__postDate">${res.post_date}</p>
                        </div>
                        
                    </div>`;
                    $(".feed").append(newPost);
                    
                } else {
                    console.log("Ajax not getting right value");
                }
            }).fail(function(res)  {
               console.log("Sorry. Ajax failed ");
            }); 
            
            
            
        });
    
    </script>
</body>
</html>