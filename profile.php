<!DOCTYPE html>
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
                <h3>Profieltekst</h3>
                <p>Dit is een profieltekst</p>
                <div id="formEditText" class="hidden">
                    <form type="post">
                        <label class="label" for="profileText">Profieltekst</label><br>
                        <input class="inputfield" type="text" name="profileText"><br>
                        <input class="button" type="submit" value="Wijzig profieltekst">
                    </form>
                </div>
                <a href="#" class="editProfileText">Wijzig gegevens</a>
            </div>
            <div>
                <h3>Email</h3>
                <p>test@test.be</p>
                
                <div id="formEditEmail" class="hidden">
                    <form type="post">
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