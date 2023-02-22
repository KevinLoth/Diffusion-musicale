<?php
require __DIR__."/../ressources/services/_shouldBeLogged.php";
shouldBeLogged(true, "./login");
unset($_SESSION);
session_destroy();
setcookie("PHPSESSID","", time()-3600);
header("location: ./login");
exit;
?>