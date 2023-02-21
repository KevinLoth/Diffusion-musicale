<?php 
require __DIR__."/../ressources/services/_database.php";
require __DIR__."/../ressources/services/_shouldBeLogged.php";
require __DIR__."/../template/_header.php";

// shouldBeLogged(true, "/");

$error = $target_file = $target_name = "";

$target_dir = "/../ressources/music/";
$_typePermis = ["audio/mp3", "audio/wav", "audio/mpeg", "audio/ogg"];

if($_SERVER["REQUEST_METHOD"]=='POST' && isset($_POST['upload']))
{   
    $db = dbConnect();
    if(!is_uploaded_file($_FILES["uploadedMusic"]["tmp_name"]))
    {
        $error = "Ancun fichier transmis, veuillez choisir un fichier";
    } 
    else
    {        
        $mime_type = mime_content_type($_FILES["uploadedMusic"]["tmp_name"]);

        $oldName = $_POST["musicName"];
        $target_name = $oldName.".mp3";
        $target_file = __DIR__.$target_dir.$target_name;

        if(empty($oldName))
        $error = "Veuillez saisir un nom de musique";
        
        $oldName = cleanData($oldName);
        $target_name = $oldName.".mp3";

        if($_FILES["uploadedMusic"]["size"] > 50000000)
            $error = "Le fichier est trop volumineux";
        if(!in_array($mime_type, $_typePermis))

            $error = "Le type de fichier n'est pas autorisé";
        if (empty($error)) {
            if(move_uploaded_file($_FILES["uploadedMusic"]["tmp_name"], $target_file))
            {
                $sql = $db->prepare("INSERT INTO musics(name, path) VALUES(:name, :path)");
                $sql->execute([":name"=> $oldName, ":path"=> $target_dir]);
                $success = "Le fichier a bien été uploadé";
            }
            else
                $error = "Erreur lors de l'upload du fichier";

        }
    }
}
?>
<main>
    <h2>Publiez votre musique</h2>
    <form action="" method="post" enctype="multipart/form-data" class="addMusic-form">
        <label for="uploadedMusic">
            <i class="fa-solid fa-cloud-arrow-up"></i>
        </label>
        <input type="text" name="musicName" id="musicName" placeholder="Nom de la musique">
        <input type="file" name="uploadedMusic" id="uploadedMusic">
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