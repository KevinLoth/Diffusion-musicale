<?php 
require __DIR__."/../ressources/services/_database.php";
require __DIR__."/../ressources/services/_shouldBeLogged.php";
require __DIR__."/../template/_header.php";

shouldBeArtist(true, "/");

$error = $target_file = $target_name = "";

$target_dir = "/../ressources/images/albums/";
$_typePermis = ["image/png", "image/jpeg", "image/jpg", "image/gif"];

if($_SERVER["REQUEST_METHOD"]=='POST' && isset($_POST['upload']))
{   
    $db = dbConnect();
    if(!is_uploaded_file($_FILES["uploadedAlbumCover"]["tmp_name"]))
    {
        $error = "Ancun fichier transmis, veuillez choisir un fichier";
    } 
    else
    {        
        $mime_type = mime_content_type($_FILES["uploadedAlbumCover"]["tmp_name"]);
        $extension = ".".pathinfo(mime_content_type($_FILES["uploadedAlbumCover"]["tmp_name"]))["filename"];
        $target_name = $_POST["albumName"];



        $target_file = __DIR__.$target_dir.$target_name.$extension;
        if(empty($target_name))
        $error = "Veuillez saisir un nom de musique";
        
        $target_name = cleanData($target_name);
        $target_name = $target_name;

        if($_FILES["uploadedAlbumCover"]["size"] > 500000)
            $error = "Le fichier est trop volumineux";
        if(!in_array($mime_type, $_typePermis))

            $error = "Le type de fichier n'est pas autorisé";
        if (empty($error)) {
            if(move_uploaded_file($_FILES["uploadedAlbumCover"]["tmp_name"], $target_file))
            {
                $sql = $db->prepare("INSERT INTO albums(name, image) VALUES(:name, :image)");
                $sql->execute([":name"=> $target_name.$extension, ":image"=> $target_dir.$target_name.$extension]);


                $success = "Le fichier a bien été uploadé";
            }
            else
                $error = "Erreur lors de l'upload du fichier";

        }
    }
}
?>
<main>
    <h2>Ajouter un album</h2>
    <form action="" method="post" enctype="multipart/form-data" class="addMusic-form">
        <label for="uploadedAlbumCover">
            <i class="fa-solid fa-cloud-arrow-up"></i>
        </label>
        <input type="text" name="albumName" id="albumName" placeholder="Nom de l'album">
        <input type="file" name="uploadedAlbumCover" id="uploadedAlbumCover">
        <input type="submit" value="Envoyer" name="upload">
        <span class="error"><?php echo $error??"" ?></span>
    </form>
    <?php
        if(isset($success))
            echo $success;
    ?>
</main>
<?php if(isset($_POST["upload"]) && empty($error)): ?>




<?php 
    endif;
    require __DIR__."/../template/_footer.php";

    
?>