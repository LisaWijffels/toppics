<?php
session_start();

if(isset ($_SESSION['username'])){
    echo "logged user is ".$_SESSION['username'];
} else {
    header('Location: login.php');
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
        <a href="#" class="navItems">Profile</a>
        <a href="#" class="navItems">Discover</a>
        <a href="#" class="navItems">Friends</a>

        <form action="" method="get" id="searchNav">
            <input type="text" name="search" value="search">
        </form>
    </nav>

    <main>
        <h1>DROP A TOP PIC</h1>

    <form class="formToppic">
        <input class="inputfield" type="text" name="topic" value="What's your topic about?"><br>
        <input class="button" id="buttonplus" type="file" value="+">
        <input class="button postForm__Button" id="buttondrop" type="submit" value="Drop it like it's hot">
    </form>
    </main>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    
    <script>
        $(".postForm__button").on("click", function(e) {
            var comment = $(".inputfield").val();
            var postId = <?php echo $_GET['id']; ?>;

            //TO DATABASS?
            $.ajax({
                //post want we willen het plaatsen onder de post
                method: "POST",
                //Data brengen naar addComment
                url: "ajax/addPost.php",
                data: { comment: comment, postId: postId }
            })
            .done(function( res ) {
                //alert( "Data Saved: " + res );
                if(res.status == "success") {
                    //append new comment
                    var newComment = `<div><strong class="post__commentUser">Some Wan</strong>
                    <p class="post__commentText">${res.comment}</p></div>`;
                    $(".post__comment").append(newComment);

                }
            });
            //
            console.log("clicked");
            //als je klinkt mag je pagina niet refreshen
            e.preventDefault();
        });
    </script>
</body>
</html>