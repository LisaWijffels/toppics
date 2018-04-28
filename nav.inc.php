<nav>
        <a href="index.php" id="aLogo"><img id="navLogo" src="img/logo2.png" alt="logo"></a>
        <a href="index.php" class="navItems">Home</a>
        <a href="profile.php" class="navItems">Profile</a>
        <a href="#" class="navItems">Discover</a>
        <a href="#" class="navItems">Friends</a>
        
        <div class="nav__right">
            <form action="" method="get" id="searchNav">
                <input type="text" name="search" placeholder="Search a toppic!">
            </form>
            <a class="button__logout button" href="logout.php">Hi <?php echo $_SESSION['username'] ?>, logout?</a>

        </div>
        
</nav>