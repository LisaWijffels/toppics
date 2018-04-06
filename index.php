<?php
/*session_start();

if(isset ($_SESSION['username'])){
    echo "logged user is ".$_SESSION['username'];
} else {
    header('Location: login.php');
}
*/

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

                <p class="feed__postUser">Grant Gustin</p>
                <img class="feed__postImg" src="img/grantgustin.jpg">
                <p class="feed__postDesc">Grant Gustin is een Amerikaanse acteur. Hij is vooral bekend van de serie Glee en de rol van Barry Allen in The Flash. </p>
                <div class="feed__flex">   
                    <p class="feed__postLikes">💗 42 likes</p>
                    <p class="feed__postDate">2018/04/08</p>
                </div>

            </div>

            <div class="feed__post">

                <p class="feed__postUser">Colton Haynes</p>
                <img class="feed__postImg" src="img/coltonhaynes.jpg">
                <p class="feed__postDesc">Colton Haynes is een Amerikaanse acteur en model. Hij kreeg bekendheid door zijn rollen in series zoals Teen Wolf en Arrow. </p>
                <div class="feed__flex">   
                    <p class="feed__postLikes">💗 24 likes</p>
                    <p class="feed__postDate">2018/04/04</p>
                </div>

            </div>

            <div class="feed__post">

                <p class="feed__postUser">Handsome man</p>
                <img class="feed__postImg" src="img/handsome.jpg">
                <p class="feed__postDesc">knap! </p>
                <div class="feed__flex">   
                    <p class="feed__postLikes">💗 12 likes</p>
                    <p class="feed__postDate">2018/04/02</p>
                </div>

                </div>
        </div>
    </main>

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
    </script>
</body>
</html>