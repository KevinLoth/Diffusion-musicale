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
                // Vérification côté users
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
                        $error[] = "Email ou Mot de passe incorrect";
                }
                
                // Vérification côté Artists
                else 
                {
                    $sql = $db->prepare("SELECT * FROM artists WHERE email = :email");
                    $sql->execute([":email"=> $email]);
                    $artist = $sql->fetch();
                    
                    if($artist)
                    {
                        if(password_verify($password, $artist["password"]))
                        {
                            $_SESSION["logged"] = true;
                            $_SESSION["id"] = $artist["idArtist"];
                            $_SESSION["user"] = $artist["name"];
                            $_SESSION["email"] = $artist["email"];
                            $_SESSION["role"] = "artist";
                            $_SESSION["expire"] = time()+ (60*60);
                            header("Location: /");
                            exit;
                        }
                        else
                            $error[] = "Email ou Mot de passe incorrect";
                    }
                }
            }
    }
?>
<main>
    <img src="../../ressources/images/logo_transparent.png" width="200px" height="200px" alt="">
    <form action="" method="post">
        <label for="email" class="emailetmdp">Adresse Email</label>
        <br>
        <input type="email" name="email" id="email">
        <br>
        <span class="error"><?php echo $error["email"]??""; ?></span>
        <br>
        <label for="password" class="emailetmdp">Mot de passe</label>
        <br>
        <input type="password" name="password" id="password">
        <br>
        <span class="error"><?php echo $error["pass"]??""; ?></span>
        <br>
        <input type="submit" value="Connexion" name="login" class="connexion">
        <br>
        <span class="error"><?php echo $error["login"]??""; ?></span>
    </form>
</main>
<?php 
    require __DIR__."/../template/_footer.php";
?>
