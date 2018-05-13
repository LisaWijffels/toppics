<?php

spl_autoload_register(function($class) {
    include_once("classes/" . $class . ".class.php");
});

include_once("helpers/Security.class.php");
    
if ( !empty($_POST) ) {
    
    $security = new Security();
    if(empty($_POST['username'])){
        $error = "Username cannot be empty.";
    } else if(empty($_POST['email'])){
        $error = "Email cannot be empty.";
    } else if(empty($_POST['password'])){
        $error = "Password cannot be empty.";
    } else {
        $security->password = $_POST['password'];
        $security->passwordConfirmation = $_POST['password_confirmation'];

        try{
            $security->passwordsAreSecure();

            $db = Db::getInstance();
            $user = new User($db);
            $user->setEmail($_POST['email'] );
            $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $user->setUsername($_POST['username'] );
                
            try{
                $user->canIregister();
                $user->register($hash);
                $user->login();
            } catch(Exception $e) {
                $error = $e->getMessage();
            }

        } catch(Exception $e) {
            $error = $e->getMessage();
        }
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
    <img src="img/logo2.png" alt="logo" id="logo">

    <?php if(isset($error) ): ?>
        <div class="errorMessage"><p><?php echo $error ?></p></div>
    <?php endif; ?>

    	<form action="" method="post" class="formlogin">

        <label class="label" for="username">Username</label><br>
        <input class="inputfield inlogfield" type="text" name="username" value="<?php if(isset($_POST['username'])) { echo $_POST['username']; } ?>"><br>

        <label class="label" for="email">Email</label><br>
        <input class="inputfield inlogfield" type="email" name="email" value="<?php if(isset($_POST['email'])) { echo $_POST['email']; } ?>"><br>

        <label class="label" for="password">Password</label><br>
        <input class="inputfield inlogfield" type="password" name="password"><br>

        <label class="label" for="password_confirmation">Confirm Password</label><br>
        <input class="inputfield inlogfield" type="password" name="password_confirmation"><br>

        <input class="button registerbutton" type="submit" value="Register">
        <a href="login.php" id="registerlink">Already have an account? Log in here.</a>
    </form>

</body>
</html>