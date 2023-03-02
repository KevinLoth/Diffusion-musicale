<?php 
$title = "Inscription";
require __DIR__."/../ressources/services/_database.php";
require __DIR__."/../ressources/services/_shouldBeLogged.php";
require __DIR__."/../template/_header.php";

shouldBeLogged(false, "/");

$error = [];
$username = $email = $password = "";
$regex = "/^(?=.*[!?@#$%^&*+-])(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z]).{6,}$/";
$recaptchaCode = $_POST['g-recaptcha-response']??'';

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
        if($_POST["password"] != $_POST["passwordVerify"])
            $error["passwordVerify"] = "Veuillez saisir le même mot de passe";
    }
    // Checkbox Artist
    $isArtist = 0;

    if (isset($_POST['isArtist'])) {
        $isArtist = 1;
    }
    // envoi des données:
    if(is_null($recaptchaCode) || verifyReCaptcha($recaptchaCode) === false)
    {
        $error["recaptcha"] = "Veuillez cocher la case";
    }

    if(empty($error))
    {
        if($isArtist)
        {
            $sql = $db->prepare("INSERT INTO artists(name, email, password) VALUES(:name, :email, :password)");
        }
        else
        {
            $sql = $db->prepare("INSERT INTO users(name, email, password) VALUES(:name, :email, :password)");
        }


        $sql->execute([":name"=> $username, ":email"=> $email, ":password"=> $password]);
        header("Location: /");
        exit;
    } 
}

# Fonction de vérification du captcha coté serveur
function verifyReCaptcha($recaptchaCode)
{
    # On crée une requête pour comparer la clé public et la clé privée
    $postdata = http_build_query(["secret" => "6Lcx1GYkAAAAAKbG57JQJ1p_LuiNpvEqXStsOJcd", "response" => $recaptchaCode]);
    $opts = [
        'http' =>
        [
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => $postdata
        ]
    ];
    $context  = stream_context_create($opts);
    # On exécute la requête
    $result = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
    # On vérifie le résultat
    $check = json_decode($result);
    # On retourne le résultat
    return $check->success;
}
# Gestion des données POST

// if(is_null($email) && filter_var($email, FILTER_VALIDATE_EMAIL)
// && !is_null($recaptchaCode) && verifyReCaptcha($recaptchaCode) === true)
// {
//     echo "Merci pour votre inscription";
// }
// else
// {
//     echo "Erreur lors de l'inscription";
// }

?>
<main>
    <h1><?php echo $title; ?></h1>
    <form action="" method="post">
        <!-- username -->
        <label for="username">Nom d'Utilisateur :</label>
        <input type="text" name="username" id="username">
        <span class="error"> <?php echo $error["username"]??"" ?></span>
        <!-- Email -->
        <label for="email">Adresse Email :</label>
        <input type="email" name="email" id="email">
        <span class="error"><?php echo $error["email"]??"" ?></span>
        <!-- Password -->
        <label for="password">Mot de Passe :</label>
        <input type="password" name="password" id="password">
        <span class="error"><?php echo $error["password"]??"" ?></span>
        <!-- password verify -->
        <label for="passwordVerify">Confirmation du mot de passe :</label>
        <input type="password" name="passwordVerify" id="passwordVerify">
        <span class="error"><?php echo $error["passwordVerify"]??"" ?></span>
        <!-- Checkbox Artist -->
        <label for="isArtist">
        Êtes vous un artiste ?
        <span class="checked">
            <i class="fa-regular fa-square"></i>
        </span>
        <input type="checkbox" name="isArtist" id="isArtist">
        </label>
        <!-- Captcha Google -->
        <div class="g-recaptcha mb-3" data-sitekey="6Lcx1GYkAAAAAPkWuBrzCdi3CCyVgd5jpRVGHHJu"></div>
        <span class="error"><?php echo $error["recaptcha"]??"" ?></span>
        <input type="submit" value="Inscription" name="inscription" class="submit">
    </form>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</main>

<?php 
require __DIR__."/../template/_footer.php";
?>