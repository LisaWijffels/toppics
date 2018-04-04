<?php

include_once("classes/User.class.php");
include_once("helpers/Security.class.php");
    
if ( !empty($_POST) ) {
    
    try{
        $security = new Security();
        $security->password = $_POST['password'];
        $security->passwordConfirmation = $_POST['password_confirmation'];

        if($security->passwordsAreSecure() ){
            $user = new User();
            $user->setEmail($_POST['email'] );
            $user->setPassword($_POST['password'] );
            if ($user->register() ){
                $user->login();
            }
        } else {
            echo "nope";
             
        }
        
    } catch(Exception $e){
        
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
    <img src="img/logo2.png" alt="logo" id="logo">

    <form action="/action_page.php" method="post" class="formlogin">

        <label class="label" for="username">Username</label><br>
        <input class="inputfield" type="text" name="username"><br>

        <label class="label" for="email">Email</label><br>
        <input class="inputfield" type="text" name="email"><br>

        <label class="label" for="password">Password</label><br>
        <input class="inputfield" type="text" name="password"><br>

        <label class="label" for="repeatPassword">Repeat Password</label><br>
        <input class="inputfield" type="text" name="repeatPassword"><br>

        <input class="button" type="submit" value="Login">
    </form>

</body>
</html>