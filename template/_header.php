<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/ressources/images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="./stylesheets/CSS/main.css">
    <!-- <link rel="stylesheet" href="./stylesheets/CSS/register.css"> -->
    <link rel="stylesheet" href="./stylesheets/CSS/nav.css">
    <!-- <link rel="stylesheet" href="./stylesheets/CSS/library.css"> -->
    <!-- <link rel="stylesheet" href="./stylesheets/CSS/search.css"> -->
    <!-- <link rel="stylesheet" href="./stylesheets/CSS/sliderhome.css"> -->
    <!-- <link rel="stylesheet" href="./stylesheets/CSS/add-music.css"> -->
    <!-- <link rel="stylesheet" href="./stylesheets/CSS/account.css"> -->
    <?php 
        if($_SERVER['REQUEST_URI'] == "/")
        {
            echo '<link rel="stylesheet" href="./stylesheets/CSS/sliderhome.css">';
        }
        else{
            $url = $_SERVER['REQUEST_URI'];
            echo '<link rel="stylesheet" href="./stylesheets/CSS'.$url.'.css">';
<<<<<<< HEAD

=======
>>>>>>> 9a850ca623eca5a9281990c7b27584c0cfe1cc17
        }
    ?>
    <link rel="stylesheet" href="./ressources/node_modules/@fortawesome/fontawesome-free/css/all.css">
    <script src="./ressources/node_modules/@fortawesome/fontawesome-free/js/all.js" defer></script>
    <script src="../Javascript/nav.js" defer></script>
    <script src="../Javascript/scrollcontent.js" defer></script>
    <script src="../Javascript/search.js" defer></script>
    <script src="../Javascript/login.js" defer></script>
</head>
<body>
    <?php require __DIR__.'/_nav.php'; ?>

