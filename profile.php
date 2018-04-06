<?php
include_once("classes/Db.class.php");
include_once("classes/User.class.php");

session_start();
$userInfo = User::getValues($_SESSION['username']);

if(isset ($_SESSION['username']) ){
    echo "logged user is ".$_SESSION['username'];
} else {
    header('Location: login.php');
}

if(isset($_POST["btnprofileText"]) ){
    $db = Db::getInstance();
    $user = new User($db);

    $user->setUsername($_SESSION['username']);
    $user_text = $_POST['profileText'];
    $user->editText($user_text);
}

if(isset($_POST["btnprofilePicture"]) ){
    if($_FILES['profilePicture']['name']){
        
        $db = Db::getInstance();
        $user = new User($db);
        $user->setUsername($_SESSION['username']);

        
        $picture_file = $_FILES['profilePicture'];
        
        
        $user->editPicture($picture_file);
    }
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
        <div class="profile">
            <div>
                <h3>Profielfoto</h3>
                <img src="images/ <?php echo $userInfo['picture_url'] ?>">
                <div id="formEditPic">
                    <form method="post" enctype="multipart/form-data">
                        <label class="label" for="profilePicture">Profielfoto</label><br>
                        <input class="inputfield" type="file" name="profilePicture"><br>
                        <input class="button" type="submit" name="btnprofilePicture" value="Wijzig profielfoto">
                    </form>
                </div>
                <a href="#" class="editProfileText">Wijzig profielfoto</a>
            </div>
            <div>
                <h3>Profieltekst</h3>
                <p><?php echo $userInfo['user_text'] ?></p>
                <div id="formEditText" class="hidden">
                    <form method="post">
                        <label class="label" for="profileText">Profieltekst</label><br>
                        <input class="inputfield" type="text" name="profileText"><br>
                        <input class="button" type="submit" name="btnprofileText" value="Wijzig profieltekst">
                    </form>
                </div>
                <a href="#" class="editProfileText">Wijzig profieltekst</a>
            </div>
            <div>
                <h3>Email</h3>
                <p><?php echo $userInfo['email'] ?></p>
                
                <div id="formEditEmail" class="hidden">
                    <form method="post">
                        <label class="label" for="email">Email</label><br>
                        <input class="inputfield" type="text" name="email"><br>
                        <input class="button" type="submit" value="Wijzig email">
                    </form>
                </div>
                <a href="#" class="editEmail">Wijzig email</a>
            </div>
        </div>
        
        <a href="#" class="editPassword">Wijzig wachtwoord</a>

    </main>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $(".editProfileText").on("click", function(e){
            e.preventDefault();
            $("#formEditText").toggleClass('hidden visible');
            console.log("check");
    });
    $(".editEmail").on("click", function(e){
            e.preventDefault();
            $("#formEditEmail").toggleClass('hidden visible');
            console.log("check");
    });
</script>
</body>
</html>