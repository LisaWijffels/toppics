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
                        
                        <div class="flexrow flex_between"><p class="feed__postUser"><?php echo $p['username']?></p><?php if($p['username'] == $_SESSION['username']): ?><a class="link__edit" href="editpost.php?post=<?php echo $p['post_id']; ?>">Edit post</a><?php endif; ?></div>
                        <a href="details.php?post=<?php echo $p['post_id']; ?>">
                        <img class="feed__postImg" src="post_images/ <?php echo $p['post_image']; ?>"></a>
                        <p class="feed__postDesc"><?php echo $p['post_desc']; ?></p>
                        
                        <div class="feed__flex">  
                            <p class="feed__postLikes">💗<?php echo $p['post_likes']; ?> likes</p>
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
    
    <script>
        function readURL(input) {

            if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                var image = e.target.result;
                $('#posted_image').css('background-image', 'url('+image+')');
                
            }

            reader.readAsDataURL(input.files[0]);
            }
        }

        $("#post_image").change(function() {
            console.log("file changed");
            $('#posted_image').toggleClass('hidden visible');
            readURL(this);
        });

        $("#buttondrop").on("click", function(e) {
            e.preventDefault();

            var file = $('#post_image')[0].files[0];
            var post_desc = $(".post_desc").val();
            
            try {
                if(file == null){
                    throw "Please upload a picture";
                }

                if(post_desc == ""){
                    throw "Please enter a description.";
                }

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
                        $(".feed").prepend(newPost);
                        
                    } else {
                        console.log("Ajax not getting right value");
                    }
                    
            }).fail(function(res)  {
               console.log("Sorry. Ajax failed ");
            });

            } catch($e) {
                var newError = `<div class="error"><p>${$e}</p></div>`;
                $("main").prepend(newError);
            }

            
            
            
            
            
            
            
            
        });
    
    </script>
</body>
</html>