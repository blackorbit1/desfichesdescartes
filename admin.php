<?php 
include_once("logs.php");
$action = "Une personne est allee sur la page admin.php";
logs(isset($_SESSION["pseudo"])?$_SESSION["pseudo"]:"inconnu", $action);
//$bdd->exec('INSERT INTO logs_admins(admin, date, IP, navigateur, action) VALUES("utilisateur" , NOW(), "'. htmlentities($_SERVER["REMOTE_ADDR"], ENT_QUOTES) .'", "'. $navigateur .'" , "'. $action .'")');
header('location: https://www.youtube.com/watch?v=IdK6_SAycS4'); ?>