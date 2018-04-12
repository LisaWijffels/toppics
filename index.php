<?php
/*session_start();

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
*/


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

        <form action="" method="post" class="formToppic">
            <input class="inputfield post_desc" type="text" name="post_desc" placeholder="What's your topic about?"><br>
            <!--<input class="button" id="buttonplus" type="file" value="+">!-->
            <input class="button postForm__Button" id="buttondrop" type="submit" value="Drop it like it's hot">
        </form>
    </main>    

    <div class="postList">
        
        <div class=feed>

                <?php foreach ($posts as $p): ?>
                    <div class="feed__post">
                    <p class="feed__postUser">Dwayne johnson</p>
                    <a href="details.php?post=<?php echo $p['post_id']; ?>"><img class="feed__postImg" src="<?php echo $p['post_image']; ?>"></a>
                    <p class="feed__postDesc"><?php echo $p['post_desc']; ?></p>
                    <div class="feed__flex">  
                        <p class="feed__postLikes">💗<?php echo $p['post_likes']; ?> likes</p>
                        <p class="feed__postDate"><?php echo $p['post_date']; ?></p>
                    </div>
                 </div>
                <?php endforeach; ?>
        </div>

        <div class="show_more_main" id="show_more_main<?php echo $postID; ?>">
            <span id="<?php echo $postID; ?>" class="show_more">Show more</span>
        </div>
    </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    
    <script>
        $(".postForm__button").on("click", function(e) {
            var post_desc = $(".post_desc").val();
            
            
            /*var post_id = <?php echo $_GET['post_id']; ?>;*/

            //start Ajax
            $.ajax({
                //stuurt gevens naar ajax addPost file
                type: "POST",
                //Data brengen naar addPost
                url: "ajax/addPost.php",
                data: { post_desc: post_desc},
                
            }).done(function( res ) { //als ajax antwoord (echo) terugstuurt
                console.log( "Data Saved: " + res );
                if(res == post_desc) {
                    //append new post
                    var newPost = `<div><strong class="feed__postUser">Dwayne johnson</strong><p class="feed__postText">${res}</p></div>`;
                    $(".feed__post").append(newPost);
                    
                } else {
                    console.log("Ajax not getting right value");
                }
            }).fail(function(res)  {
               console.log("Sorry. Ajax failed "+ res);
            }); 
            
            //als je klinkt mag je pagina niet refreshen
            e.preventDefault();
        });

        //loadmore met ajax
        $(document).on('click','.show_more',function(){
            var showLimit = showLimit + 20;
            var ID = $(this).attr('id');

            $.ajax({
                url:"index.php",
                type: "POST",
                data:'id='+ID,
                success:function(html){
                    $('#show_more_main'+ID).remove();
                    $('.postList').append(html);
                }
            });

         
        
           
        });
    });
        });
    </script>
</body>
</html>