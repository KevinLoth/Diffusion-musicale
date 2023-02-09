<?php 
require __DIR__."/../ressources/services/_database.php";

require __DIR__."/../template/_header.php";


$error = $target_file = $target_name = "";

$target_dir = __DIR__."/../music/";
$_typePermis = ["audio/mp3", "audio/wav"];

if($_SERVER["REQUEST_METHOD"]=='POST' && isset($_POST['upload']))
{    if(!is_uploaded_file($_FILES["superFichier"]["tmp_name"]))
    $error = "Ancun fichier transmis, veuillez choisir un fichier";    else
    {        $oldName = basename($_FILES["superFichier"]["name"]);

        $target_name = uniqid(time()."-",true)."-".$oldName;
        $target_file = $target_dir.$target_name;


        $mime_type = mime_content_type($_FILES["superFichier"]["tmp_name"]);
        if(file_exists($target_file))
            $error = "Le fichier existe déjà";

        if($_FILES["superFichier"]["size"] > 500000)
            $error = "Le fichier est trop volumineux";

        if(!in_array($mime_type, $_typePermis))
            $error = "Le type de fichier n'est pas autorisé";
        if (empty($error)) {
            if(move_uploaded_file($_FILES["superFichier"]["tmp_name"], $target_file))
                $success = "Le fichier a bien été uploadé";
            else
                $error = "Erreur lors de l'upload du fichier";

        }
    }
}
?>

<form action="" method="post" enctype="multipart/form-data">
    <label for="fichier">Choisir un Fichier :</label>
    <input type="file" name="uploadedMusic" id="uploadedMusic">
    <input type="submit" value="Envoyer" name="upload">
    <span class="error"><?php echo $error??"" ?></span>
</form>
<?php if(isset($_POST["upload"]) && empty($error)): ?>
    <p>
        Votre fichier a bien été envoyé sous le nom : <?php echo $target_name ?>
    </p>




<?php 
endif;
require __DIR__."/../template/_footer.php";

?>