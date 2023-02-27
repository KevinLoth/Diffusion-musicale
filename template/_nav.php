<nav>

    <a href="/"><i class="fa-solid fa-house"></i>Accueil</a>
    <a href="#"><i class="fa-solid fa-magnifying-glass"></i> Rechercher</a>
    <a href="#"><i class="fa-solid fa-book"></i> Bibliothèque</a>
    <a href="#"><i class="fa-solid fa-music"></i> Playlist</a>
    <div class="nav-account">
        <div class="nav-account-dropdown">

            
        <?php 
            if(isset($_SESSION["logged"]))
            {
                echo "<a href='/account'><i class='fa-solid fa-user'></i> Mon compte</a>";
                echo "<a href='/logout'><i class='fa-solid fa-sign-out'></i> Déconnexion</a>";
            }
            else {
                echo "<a href='/login'><i class='fa-solid fa-user'></i> Connexion</a>";
                echo "<a href='/register'><i class='fa-solid fa-user-plus'></i> Inscription</a>"; 
            }
                
        ?>
        </div>
    </div>
</nav>

