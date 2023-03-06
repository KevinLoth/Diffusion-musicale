<?php
require __DIR__."/../template/_header.php";
?>
<main>
    <div class="searchbar">
        <span>
            <i class="fa-solid fa-magnifying-glass"></i>
        </span>
        <input type="search" name="search" id="search" class="" placeholder="Que recherchez-vous ?">
    </div>
    <div class="recentsearch">
        <h2>Recherche récente</h2>
        <div class="recentcontent">
                <p>Genre : ?</p>
                <p>Genre : ?</p>
                <p>Genre : ?</p>
        </div>
    </div>
    <div class="searchcategory">
        <h2>Recherche par catégories</h2>
        <div class="recentcontentscroll">
                    <p>Rap</p>
                    <p>Hip-Hop</p>
                    <p>Pop</p>
                    <p>Électro</p>
                    <p>Rock</p>
                    <p>Rnb</p>
                    <p>Zouk</p>
                    <p>Reggae</p>
                    <p>Jazz</p>
            </div>
    </div>
</main>


<?php 
require __DIR__."/../template/_footer.php";
?>