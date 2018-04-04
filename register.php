<?php
include_once("classes/Db.class.php");
include_once("classes/User.class.php");
include_once("helpers/Security.class.php");
    
if ( !empty($_POST) ) {
    
    try{
        $security = new Security();
        $security->password = $_POST['password'];
        $security->passwordConfirmation = $_POST['password_confirmation'];

        if($security->passwordsAreSecure() ){
            $db = Db::getInstance();
            $user = new User($db);
            $user->setEmail($_POST['email'] );
            $user->setPassword($_POST['password'] );
            $user->setUsername($_POST['username'] );
            if ($user->register() ){
                $user->login();
                
            }
        } else {
            echo "nope can't register";
             
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

    <?php if (isset($error)): ?>
		<div class="form__error hidden">
			<p>
				Some error here, oops
			</p>
		</div>
	<?php endif; ?>

    <form action="" method="post" class="formlogin">

        <label class="label" for="username">Username</label><br>
        <input class="inputfield" type="text" name="username"><br>

        <label class="label" for="email">Email</label><br>
        <input class="inputfield" type="text" name="email"><br>

        <label class="label" for="password">Password</label><br>
        <input class="inputfield" type="password" name="password"><br>

        <label class="label" for="password_confirmation">Confirm Password</label><br>
        <input class="inputfield" type="password" name="password_confirmation"><br>

        <input class="button" type="submit" value="Register">
    </form>

</body>
</html>