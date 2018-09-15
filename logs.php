<?php
include_once("navigateur.php");



function logs($auteur, $action){
    include_once("bdd.php");

    $req = $bdd->prepare("SELECT id FROM bots WHERE ip = :ip");
    $req->execute(array("ip" => $_SERVER["REMOTE_ADDR"]));

    if($req->rowCount()){
        $auteur = "bot";
    }
    $req = $bdd->prepare('INSERT INTO logs_admins(  admin,
                                                    date,
                                                    IP,
                                                    navigateur,
                                                    action) 
                            VALUES( :admin,
                                    NOW(),
                                    :ip,
                                    :navigateur,
                                    :action)');
    $req->execute(array(
        "admin" => $auteur,
        "ip" => $_SERVER["REMOTE_ADDR"],
        "navigateur" => get_browsername(),
        "action" => $action
    ));
    $req->closeCursor();
}

if(isset($_GET)){
    /* une personne a tenté d'acceder au fichier php des logs -> avec des parametres GET -> les mettres */
    /* === === === Le fait à chaque include donc inutile === === ===
    if(isset($_SESSION['pseudo'])){
        logs($_SESSION['pseudo'], "A tenté d'acceder au fichier php avec les parametres GET suivants :" . serialize($_GET));
    } else {
        logs("inconnu", "A tenté d'acceder au fichier php avec les parametres GET suivants :" . serialize($_GET));
    }
    */
} elseif(!isset($_POST)) {
    if(isset($_SESSION['pseudo'])){
        logs($_SESSION['pseudo'], "A tenté d'acceder au fichier php avec les parametres POST suivants :" . serialize($_POST));
    } else {
        logs("inconnu", "A tenté d'acceder au fichier php avec les parametres POST suivants :" . serialize($_POST));
    }
}



?>