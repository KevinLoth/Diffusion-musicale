<?php 
    require __DIR__."/../ressources/services/_shouldBeLogged.php";
    shouldBeLogged(false, "/register");
    require __DIR__."/../template/_header.php";
    
    $email = $password = "";
    $error = [];
    
    if($_SERVER["REQUEST_METHOD"]=='POST' && isset($_POST['login']))
    {   
        require __DIR__."/../ressources/services/_database.php";
        $email = cleanData($_POST["email"]);
        $password = cleanData($_POST["password"]);
        if(empty($email))
            $error[] = "Veuillez saisir votre email";
            if(empty($password))
            $error[] = "Veuillez saisir votre mot de passe";
            
            if(empty($error))
            {
                $db = dbConnect();
                $sql = $db->prepare("SELECT * FROM users WHERE email = :email");
                $sql->execute([":email"=> $email]);
                $user = $sql->fetch();
                
                if($user)
                {
                    if(password_verify($password, $user["password"]))
                    {
                        $_SESSION["logged"] = true;
                        $_SESSION["id"] = $user["idUser"];
                        $_SESSION["user"] = $user["name"];
                        $_SESSION["email"] = $user["email"];
                        $_SESSION["role"] = null;
                        $_SESSION["expire"] = time()+ (60*60);
                        header("Location: /");
                        exit;
                    }
                    else
                        $error[] = "Mot de passe incorrect";
                }
            else
                $error[] = "Email incorrect";
        }
    }

    
?>
<main>
    <h2>Connexion</h2>
    <form action="" method="post">
        <label for="email">Email</label>
        <input type="email" name="email" id="email">
        <br>
        <span class="error"><?php echo $error["email"]??""; ?></span>
        <br>
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password">
        <br>
        <span class="error"><?php echo $error["pass"]??""; ?></span>
        <br>
        <input type="submit" value="Connexion" name="login">
        <br>
        <span class="error"><?php echo $error["login"]??""; ?></span>
    </form>
</main>
<?php 
    require __DIR__."/../template/_footer.php";
?>