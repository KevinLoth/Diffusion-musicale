<?php 
    require "./ressources/services/_shouldBeLogged.php";
    shouldBeLogged(true, "./login");
    require "./template/_header.php";

    require "./ressources/services/_database.php";
    $db = dbConnect();
    $sql = $db->prepare("SELECT * FROM users WHERE idUser = :id");
    $sql->execute([":id"=> $_SESSION["id"]]);
    $user = $sql->fetch();
?>
<main>
    <div class="account">
        <h2>Mon compte</h2>
        <div>
            <div class="account-info">
                <h3>Informations</h3>
                <p>Nom d'utilisateur: <?php echo $user["name"]; ?></p>
                <p>Email: <?php echo $user["email"]; ?></p>
            </div>
            <div class="account-actions">
                <h3>Actions</h3>
                <a href="/logout">Déconnexion</a>
            </div>
        </div>
    </div>
</main>