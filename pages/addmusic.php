<?php 
require __DIR__."/../ressources/services/_database.php";

require __DIR__."/../template/_header.php";


$error = $target_file = $target_name = "";

$target_dir = __DIR__."/../ressources/music/";
$_typePermis = ["audio/mp3", "audio/wav", "audio/mpeg", "audio/ogg"];

if($_SERVER["REQUEST_METHOD"]=='POST' && isset($_POST['upload']))
{    if(!is_uploaded_file($_FILES["uploadedMusic"]["tmp_name"]))
    $error = "Ancun fichier transmis, veuillez choisir un fichier";    else
    {        $oldName = basename($_FILES["uploadedMusic"]["name"]);

        $target_name = uniqid(time()."-",true)."-".$oldName;
        $target_file = $target_dir.$target_name;


        $mime_type = mime_content_type($_FILES["uploadedMusic"]["tmp_name"]);
        if(file_exists($target_file))
            $error = "Le fichier existe déjà";

        if($_FILES["uploadedMusic"]["size"] > 50000000)
            $error = "Le fichier est trop volumineux";
        var_dump($mime_type);
        if(!in_array($mime_type, $_typePermis))

            $error = "Le type de fichier n'est pas autorisé";
        if (empty($error)) {
            if(move_uploaded_file($_FILES["uploadedMusic"]["tmp_name"], $target_file))
                $success = "Le fichier a bien été uploadé";
            else
                $error = "Erreur lors de l'upload du fichier";

        }
    }
}
?>
<main>

    <form action="" method="post" enctype="multipart/form-data" class="addMusic-form">
        <input type="file" name="uploadedMusic" id="uploadedMusic">
        <input type="submit" value="Envoyer" name="upload">
        <span class="error"><?php echo $error??"" ?></span>
    </form>
</main>
<?php if(isset($_POST["upload"]) && empty($error)): ?>
    <p>
        Votre fichier a bien été enregistrer
    </p>




<?php 
endif;
require __DIR__."/../template/_footer.php";

?>