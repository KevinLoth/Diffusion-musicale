<?php 
function dbConnect()
{
    $config = require "./ressources/config/_config.php";

    $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
    $db = new \PDO($dsn, $config['user'], $config['password'], $config['options']);
    return $db;
}
function cleanData(string $data): string
{
    $data = trim($data);
    $data = stripslashes($data);
    return htmlspecialchars($data);
}
?>