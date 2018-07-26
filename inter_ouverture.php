<?php
include_once("bdd.php");
include_once("logs.php");

if(isset($_GET["pied"])){
    $action = "Une personne a regardé l'image de pied";
    logs(isset($_SESSION["pseudo"])?$_SESSION["pseudo"]:"inconnu", $action);
    header('Location: Pied.jpg');
} elseif(isset($_GET) and array_key_exists("fichier", $_GET)){

    $verif[] = preg_match("#DELETE#i", $_GET['fichier']);
    $verif[] = preg_match("#SELECT#i", $_GET['fichier']);
    $verif[] = preg_match("#MODIFY#i", $_GET['fichier']);
    $verif[] = preg_match("#WHERE#i", $_GET['fichier']);
    $verif[] = preg_match("#CHANGE#i", $_GET['fichier']);
    $verif[] = preg_match("#admin#i", $_GET['fichier']);
    $verif[] = preg_match("#UNION#i", $_GET['fichier']);
    $verif[] = preg_match("#FROM#i", $_GET['fichier']);
    $verif[] = preg_match("#'#i", $_GET['fichier']);
    $verif[] = preg_match('#"#i', $_GET["fichier"]);
    //$verif[] = preg_match("#AND#i", $_GET['fichier']); // trop de chances que la suite de caracteres arriver un jour dans le nom du fichier

    if(in_array(1, $verif)){
        $action = "Une personne a tenté une injection SQL sur inter_ouverture.php. GET: ". serialize($_GET);
        logs(isset($_SESSION["pseudo"])?$_SESSION["pseudo"]:"inconnu", $action);
        //$bdd->exec('INSERT INTO logs_admins(admin, date, IP, navigateur, action) VALUES("utilisateur" , NOW(), "'. htmlentities($_SERVER["REMOTE_ADDR"], ENT_QUOTES) .'", "'. $navigateur .'" , "'. $action .'")');    
    } 
    
    //die(print_r($bdd->errorInfo()));
    if(isset($_GET["externe"])){
        $req = $bdd->prepare("SELECT nom_fichier FROM fichiers WHERE id = :id");
        $req->execute(array("id" => $_GET["fichier"]));
        $donnees = $req->fetch();
        //print(('Location: ' . $donnees["nom_fichier"]));
        $bdd->exec("UPDATE fichiers SET nb_visionnage = nb_visionnage+1 WHERE id = '" . htmlentities($_GET["fichier"], ENT_QUOTES) . "'");
        header('Location: ' . $donnees["nom_fichier"]);
    } else {
        $bdd->exec("UPDATE fichiers SET nb_visionnage = nb_visionnage+1 WHERE nom_fichier = '" . htmlentities($_GET["fichier"], ENT_QUOTES) . "'");
        header('Location: uploads/' . $_GET["fichier"]);
    }
    
} else {
    print("Si c'est un bug, signalez le moi en feedbacks, si vous etes un petit fouineur, le FBI et les services secrets hongrois arriveront chez vous dans à peu près 3 minutes");
}
?>