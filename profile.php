<?php
include_once("classes/Db.class.php");
include_once("classes/User.class.php");
include_once("helpers/Security.class.php");

session_start();

// Enkel deze pagina tonen als er een user ingelogged is
if(isset ($_SESSION['username']) ){
    $loggeduser = $_SESSION['username'];
    
} else {
    header('Location: login.php');
}

// Alle gegevens van ingelogde user binnenhalen
$db = Db::getInstance();
$user = new User($db);
$user->setUsername($_SESSION['username']);

$userInfo = $user->getValues();



// Wijzig profielfoto
if(isset($_POST["btnprofilePicture"]) ){
    if($_FILES['post_image']['name']){
        
        $user_picture = $_FILES['post_image'];
        $user->setUser_picture($user_picture);
        $user->editPicture();
        header("Refresh:0");
    }
}

// Wijzig password
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
<body>

    <?php include_once("nav.inc.php"); ?>


    <main>
    <h2 class="h2">Profiel bewerken</h2>
        <div class="profile">
        <?php if(isset($error) ): ?>
            <div class="errorMessage"><p><?php echo $error ?></p></div>
        <?php endif; ?>
            <div>
                <h3>Profile picture</h3>
                <div id="posted_image" style='background-image:url("<?php if($userInfo['user_picture'] ==""){
                    echo "default-user-photo.png";
                } else {
                    echo "user_images/ ".$userInfo['user_picture'];
                }
                    
                ?>")'></div>
                
                <div id="formEditPic" class="hidden">
                    <form method="post" enctype="multipart/form-data">
                        <label for="post_image" class="file_upload">Upload an image</label>
                        <input type="file" name="post_image" id="post_image"><br>

                        <input class="profile__form button" type="submit" name="btnprofilePicture" value="Confirm">

                        
                    </form>
                </div>
                <div class="editProfileButton">
                    <a href="#" id="editPic" class="btnedit">Edit profiel picture</a>
                </div>
            </div>
            <div>
                <h3>Biography</h3>
                <p id="valueEditText" class="visible"><?php echo $userInfo['user_text']; ?></p>
                <div id="formEditText" class="hidden">
                    <form method="post">
                        <input class="profile__form inputfield" type="text" name="profileText" value="<?php echo $userInfo['user_text'] ?>"><br>
                        <input class="profile__form button" type="submit" name="btnprofileText" value="Confirm">
                    </form>
                </div>
                <div class="editProfileButton">
                    <a href="#" id="editProfileText" class="btnedit">Edit biography</a>
                </div>      
            </div>
            <div>
                <h3>Email</h3>
                <p id="valueEditEmail" class="visible"><?php echo $userInfo['email']; ?></p>
                
                <div id="formEditEmail" class="hidden">
                    <form method="post">
                        <input class="profile__form inputfield" type="email" name="email" value="<?php echo $userInfo['email'] ?>"><br>
                        <input class="profile__form button" type="submit" name="btnEmail" value="Confirm">
                    </form>
                </div>
                <div class="editProfileButton">
                <a href="#" id="editEmail" class="btnedit">Edit email</a>
                </div>
            </div>

            <div>
            
                
                <div id="formEditPassword" class="hidden">
                    <form method="post">
                        <label for="password" class="formEdit__label">Current password</label><br>
                        <input class="profile__form inputfield" type="password" name="password"><br>

                        <label for="password_new" class="formEdit__label">New password</label><br>
                        <input class="profile__form inputfield" type="password" name="password_new"><br>

                        <label for="password_confirmation" class="formEdit__label">Confirm new password</label><br>
                        <input class="profile__form inputfield" type="password" name="password_confirmation" ><br>
                        <input class="profile__form button" type="submit" name="btnPassword" value="Confirm">
                    </form>
                </div>
                <div class="editProfileButton">
                <a href="#" id="editPassword" class="btnedit">Edit password</a>
                </div>
            </div>

        </div>
    </main>
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="script/editProfile.js"></script>
</body>
</html>