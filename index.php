<?php 

require "../Diffusion-musicale/template/_header.php";
require "../Diffusion-musicale/template/_nav.php";

?>
<?php 
# Inclure les routes :
require "./routes.php";

# Récupérer le chemin de la route :
$url = filter_var($_SERVER["REQUEST_URI"], FILTER_SANITIZE_URL);

$url = explode("?", $url)[0];

$url = trim($url, "/");

if(array_key_exists($url, ROUTES))
    require "./pages/" . ROUTES[$url];
else
    require "./pages/404.php";