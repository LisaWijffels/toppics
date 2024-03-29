<?php

spl_autoload_register(function($class) {
    include_once("classes/" . $class . ".class.php");
});

include_once("helpers/Security.class.php");
    


if ( !empty($_POST) ) {
    $db = Db::getInstance();
    $user = new User($db);
    $user->setUsername($_POST['username'] );
    
    try{
        $user->canIlogin($_POST['password']);
        $user->login();
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
    <img src="img/logo2.png" alt="logo" id="logo">
    <?php if(isset($error) ): ?>
        <div class="errorMessage"><p><?php echo $error ?></p></div>
    <?php endif; ?>
    <form action="" method="post" class="formlogin">
        <label class="label" for="username">Username</label><br>
        <input class="inputfield inlogfield" type="text" name="username" value="<?php if(isset($_POST['username'])) { echo $_POST['username']; } ?>"><br>
        <label class="label" for="password">Password</label><br>
        <input class="inputfield inlogfield" type="password" name="password"><br>
        <input class="button registerbutton loginbutton" type="submit" value="Login">
    </form>

    <a href="register.php" id="registerlink">Dont have an account yet? Sign up here.</a>

</body>
</html>