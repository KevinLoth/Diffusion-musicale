<?php 
$title = "Inscription";
require "./ressources/services/_database.php";
require "./ressources/services/_shouldBeLogged.php";

shouldBeLogged(false, "/");

$error = [];
$username = $email = $password = "";
$regex = "/^(?=.*[!?@#$%^&*+-])(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z]).{6,}$/";

if($_SERVER['REQUEST_METHOD']=="POST" && isset($_POST['inscription']))
{
    $db = dbConnect();
    if(empty($_POST["username"]))
        $error['username'] = "Le nom d'utilisateur est requis";
    else
    {
        $username = cleanData($_POST["username"]);
        if(!preg_match("/^[a-zA-Z'\s-]{2,25}$/", $username))
            $error["username"] = "Veuillez saisir un nom d'utilisateur valide";
    }
    // Traitement email :
    if(empty($_POST["email"]))
        $error["email"] = "Veuillez saisir un email";
    else
    {
        $email = cleanData($_POST["email"]);
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            $error["email"] = "Veuillez saisir un email valide";
        $sql = $db->prepare("SELECT * FROM users WHERE email = :em");
        $sql->execute(["em"=>$email]);
        $resultat = $sql->fetch();
        if($resultat)
            $error["email"] = "Cet email est déjà enregistré";
    }
    // Traitement password :
    if(empty($_POST["password"]))
        $error["password"] = "Veuillez saisir un mot de passe";
    else
    {
        $password = cleanData($_POST["password"]);
        if(!preg_match($regex, $password))
            $error["password"] = "Veuillez saisir un mot de passe valide";
        else
            $password = password_hash($password, PASSWORD_DEFAULT);
    }
    // Traitement confirmation password :
    if(empty($_POST["passwordVerify"]))
        $error["password"] = "Veuillez saisir à nouveau votre mot de passe";
    else
    {
        if($_POST["passwordVerify"] != $_POST["passwordVerify"])
            $error["passwordVerify"] = "Veuillez saisir le même mot de passe";
    }
    // envoi des données:
    if(empty($error))
    {
        echo "ok";
        $sql = $db->prepare("INSERT INTO users(name, email, password) VALUES(:name, :email, :password)");
        $sql->execute([":name"=> $username, ":email"=> $email, ":password"=> $password]);
        // header("Location: /");
        exit;
    }
}

?>
<main>
    <h1><?php echo $title; ?></h1>
    <form action="" method="post">
        <!-- username -->
        <label for="username">Nom d'Utilisateur :</label>
        <input type="text" name="username" id="username">
        <span class="error"> <?php echo $error["username"]??"" ?></span>
        <br>
        <!-- Email -->
        <label for="email">Adresse Email :</label>
        <input type="email" name="email" id="email">
        <span class="error"><?php echo $error["email"]??"" ?></span>
        <br>
        <!-- Password -->
        <label for="password">Mot de Passe :</label>
        <input type="password" name="password" id="password">
        <span class="error"><?php echo $error["password"]??"" ?></span>
        <br>
        <!-- password verify -->
        <label for="passwordVerify">Confirmation du mot de passe :</label>
        <input type="password" name="passwordVerify" id="passwordVerify">
        <span class="error"><?php echo $error["passwordVerify"]??"" ?></span>
        <br>
        <input type="submit" value="Inscription" name="inscription">
    </form>
</main>