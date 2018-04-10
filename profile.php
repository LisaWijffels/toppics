<?php
include_once("classes/Db.class.php");
include_once("classes/User.class.php");
include_once("helpers/Security.class.php");

session_start();


// Enkel deze pagina tonen als er een user ingelogged is
if(isset ($_SESSION['username']) ){
    $loggeduser = $_SESSION['username'];
    echo "logged user is ".$loggeduser;
} else {
    header('Location: login.php');
}



<<<<<<< HEAD
=======

>>>>>>> mybranch
// Alle gegevens van ingelogde user binnenhalen
$db = Db::getInstance();
$user = new User($db);
$user->setUsername($_SESSION['username']);

$userInfo = $user->getValues();

// Wijzig profile text
/*if(isset($_POST["btnprofileText"]) ){
    $user_text = $_POST['profileText'];
    $user->setUsertext($user_text);
    $user->editText();
}*/

// Wijzig profielfoto
if(isset($_POST["btnprofilePicture"]) ){
    if($_FILES['profilePicture']['name']){
        
        $user_picture = $_FILES['profilePicture'];
        $user->setUser_picture($user_picture);
        $user->editPicture();
        header("Refresh:0");
    }
}

// Wijzig ww
if(isset($_POST["btnPassword"]) ){
    try{
        $user->canIlogin($_POST['password']);

        $security = new Security();
        $security->password = $_POST['password_new'];
        $security->passwordConfirmation = $_POST['password_confirmation'];

        try{
            $security->passwordsAreSecure();
            $hash = password_hash($_POST['password_new'], PASSWORD_DEFAULT);
                    
            try{
                $user->editPassword($hash);
            
            } catch(Exception $e) {
                $error = $e->getMessage();
            }

        } catch(Exception $e) {
            $error = $e->getMessage();
        }
        
    } catch(Exception $e){
        $error = $e->getMessage();
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
    <h2>Profiel bewerken</h2>
        <div class="profile">
        <?php if(isset($error) ): ?>
            <?php echo $error ?>
        <?php endif; ?>
            <div>
                <h3>Profielfoto</h3>
<<<<<<< HEAD
                <img class="profile__img" src="user_images/ <?php echo $userInfo['user_picture'] ?>"><br>
                <div id="formEditPic" class="hidden">
                    <form method="post" enctype="multipart/form-data">
                        <input class="profile__form inputfield" type="file" name="profilePicture"><br>
                        <input class="profile__form button" type="submit" name="btnprofilePicture" value="Bevestig">
=======
                <p><img src="user_images/ <?php echo $userInfo['user_picture'] ?>" class="profile__img"></p>
                <div id="formEditPic" class="hidden">
                    <form method="post" enctype="multipart/form-data">
                        <label class="label" for="profilePicture">Profielfoto</label><br>
                        <input class="inputfield" type="file" name="profilePicture"><br>
                        <input class="button profile__form" type="submit" name="btnprofilePicture" value="Wijzig profielfoto">
>>>>>>> mybranch
                    </form>
                </div>
                <a href="#" class="btnedit editPic visible">Wijzig profielfoto</a>
            </div>
            <div>
                <h3>Biografie</h3>
                <p id="valueEditText" class="visible"><?php echo $userInfo['user_text']; ?></p>
                <div id="formEditText" class="hidden">
                    <form method="post">
<<<<<<< HEAD
                        <input class="profile__form inputfield" type="text" name="profileText" value="<?php echo $userInfo['user_text'] ?>"><br>
                        <input class="profile__form button" type="submit" name="btnprofileText" value="Bevestig">
                    </form>
                </div>
                <a href="#" class="btnedit editProfileText visible">Wijzig biografie</a>
=======
                        <input class="inputfield" type="text" name="profileText" value="<?php echo $userInfo['user_text'] ?>"><br>
                        <input class="profile__form button" type="submit" name="btnprofileText" value="Wijzig profieltekst">
                    </form>
                </div>
                <a href="#" class="btnedit editProfileText visible">Wijzig profieltekst</a>
>>>>>>> mybranch
            </div>
            <div>
                <h3>Email</h3>
                <p id="valueEditEmail" class="visible"><?php echo $userInfo['email']; ?></p>
                
                <div id="formEditEmail" class="hidden">
                    <form method="post">
<<<<<<< HEAD
                        <input class="profile__form inputfield" type="text" name="email" value="<?php echo $userInfo['email'] ?>"><br>
                        <input class="profile__form button" type="submit" name="btnEmail" value="Bevestig">
                    </form>
                </div>
                <a href="#" class="btnedit editEmail visible">Wijzig email</a>
=======
                        <input class="inputfield" type="text" name="email" value="<?php echo $userInfo['email'] ?>"><br>
                        <input class="profile__form button" type="submit" name="btnEmail" value="Wijzig email">
                    </form>
                </div>
                <a href="#" class="btnedit editEmail">Wijzig email</a>
>>>>>>> mybranch
            </div>

            <div>
            <h3>Wachtwoord</h3>
                
                <div id="formEditPassword" class="hidden">
                    <form method="post">
                        <label for="passord" class="formEdit__label">Huidig wachtwoord</label><br>
                        <input class="profile__form inputfield" type="password" name="password"><br>

<<<<<<< HEAD
                        <label for="passord" class="formEdit__label">Nieuw wachtwoord</label><br>
                        <input class="profile__form inputfield" type="password" name="password"><br>

                        <label for="passord" class="formEdit__label">Bevestig nieuw wachtwoord</label><br>
                        <input class="profile__form inputfield" type="password" name="password" ><br>
                        <input class="profile__form button" type="submit" name="btnEmail" value="Bevestig">
=======
                        <label for="passord">Nieuw wachtwoord</label><br>
                        <input class="inputfield" type="password" name="password_new"><br>

                        <label for="passord">Bevestig nieuw wachtwoord</label><br>
                        <input class="inputfield" type="password" name="password_confirmation"><br>
                        <input class="profile__form button" type="submit" name="btnPassword" value="Wijzig wachtwoord">
>>>>>>> mybranch
                    </form>
                </div>
                <a href="#" class="btnedit editPassword visible">Wijzig wachtwoord</a>
            </div>

        </div>
        
        

    </main>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<<<<<<< HEAD
<script>
    $(".editProfileText").on("click", function(e){
            e.preventDefault();
            $("#formEditText").toggleClass('hidden visible');
            $("#valueEditText").toggleClass('visible hidden');
            $(".editProfileText").toggleClass('visible hidden');
            console.log("check");
    });

    $(".editEmail").on("click", function(e){
            e.preventDefault();
            $("#formEditEmail").toggleClass('hidden visible');
            $("#valueEditEmail").toggleClass('visible hidden');
            $(".editEmail").toggleClass('visible hidden');
            console.log("check");
    });

    $(".editPic").on("click", function(e){
            e.preventDefault();
            $("#formEditPic").toggleClass('hidden visible');
            
            $(".editPic").toggleClass('visible hidden');
            console.log("check");
    });

    $(".editPassword").on("click", function(e){
            e.preventDefault();
            $("#formEditPassword").toggleClass('hidden visible');
            
            $(".editPassword").toggleClass('visible hidden');
            console.log("check");
    });

    
</script>
=======
<script src="script/editProfile.js"></script>
>>>>>>> mybranch
</body>
</html>