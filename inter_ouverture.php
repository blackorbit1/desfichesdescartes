<?php
include_once("bdd.php");
include_once("logs.php");
include_once("bots_control.php");

if(isset($_GET["pied"])){
    $action = "Une personne a regardé l'image de pied";
    logs(isset($_SESSION["pseudo"])?$_SESSION["pseudo"]:"inconnu", $action);
    header('Location: Pied.jpg');
} elseif(isset($_GET) and array_key_exists("fichier", $_GET) and isset($_GET["application"])){
    if(isset($_GET["externe"])){
        $req = $bdd->prepare("SELECT nom_fichier FROM fichiers WHERE id = :id");
        $req->execute(array("id" => $_GET["fichier"]));
        $donnees = $req->fetch();
        //print(('Location: ' . $donnees["nom_fichier"]));
        //$bdd->exec("UPDATE fichiers SET nb_visionnage = nb_visionnage+1 WHERE id = '" . htmlentities($_GET["fichier"], ENT_QUOTES) . "'");
        $req = $bdd->prepare("UPDATE fichiers SET nb_visionnage = nb_visionnage+1 , nb_visionnage_mobile = nb_visionnage_mobile+1 WHERE id = :fichier");
        $req->execute(array("fichier" => $_GET["fichier"]));
        header('Location: ' . $donnees["nom_fichier"]);
    } else {
        //$bdd->exec("UPDATE fichiers SET nb_visionnage = nb_visionnage+1 WHERE nom_fichier = '" . htmlentities($_GET["fichier"], ENT_QUOTES) . "'");
        $req = $bdd->prepare("UPDATE fichiers SET nb_visionnage = nb_visionnage+1 , nb_visionnage_mobile = nb_visionnage_mobile+1 WHERE nom_fichier = :fichier");
        $req->execute(array("fichier" => $_GET["fichier"]));
        header('Location: uploads/' . $_GET["fichier"]);
    }
} elseif(isset($_GET["fichier"]) and $_GET["fichier"] == "db4534a910db5d169cd70000109f0ae48146da815957.pdf") {
    logs(isset($_SESSION["pseudo"])?$_SESSION["pseudo"]:"inconnu", "est allé sur le fichier piegé");

    /// /// /// --- Page piege pour les robots qui ne respectent pas robots.txt --- /// /// ///
    
    ?>
        <!doctype html>
        <html lang="fr">
            <head>
                <meta name="robots" content="none"> <!-- Doctype HTML -->
	            <meta name="robots" content="none" /> <!-- Doctype XHTML -->
            </head>
            <body>
                <strong style="color: red;">Cliquer sur ce lien entrainera un ban IP du site</strong> (vous n'etes pas sensé être sur cette page)<br>
                <a href="dissident.php">lien</a>
            </body>
        </html>
    <?php
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
        //$bdd->exec("UPDATE fichiers SET nb_visionnage = nb_visionnage+1 WHERE id = '" . htmlentities($_GET["fichier"], ENT_QUOTES) . "'");
        $req = $bdd->prepare("UPDATE fichiers SET nb_visionnage = nb_visionnage+1 WHERE id = :fichier");
        $req->execute(array("fichier" => $_GET["fichier"]));
        header('Location: ' . $donnees["nom_fichier"]);
    } else {
        //$bdd->exec("UPDATE fichiers SET nb_visionnage = nb_visionnage+1 WHERE nom_fichier = '" . htmlentities($_GET["fichier"], ENT_QUOTES) . "'");
        $req = $bdd->prepare("UPDATE fichiers SET nb_visionnage = nb_visionnage+1 WHERE nom_fichier = :fichier");
        $req->execute(array("fichier" => $_GET["fichier"]));
        header('Location: uploads/' . $_GET["fichier"]);
    }

} elseif(isset($_GET) and array_key_exists("moodle", $_GET)){
    try{
        $req = $bdd->prepare("UPDATE matiere SET acces_moodle = acces_moodle+1 WHERE code = :code");
        $req->execute(array("code" => $_GET["moodle"]));
        $req = $bdd->prepare("SELECT moodle FROM matiere WHERE code = :code");
        $req->execute(array("code" => $_GET["moodle"]));
        $donnees = $req->fetch();
        header('Location: ' . $donnees["moodle"]);
        print("Si c'est un bug, signalez le moi en feedbacks, si vous etes un petit fouineur, le FBI et les services secrets hongrois arriveront chez vous dans à peu près 3 minutes");
    } catch(Exception $e){
        print("Si c'est un bug, signalez le moi en feedbacks, si vous etes un petit fouineur, le FBI et les services secrets hongrois arriveront chez vous dans à peu près 3 minutes");
    }
    

} else {
    print("Si c'est un bug, signalez le moi en feedbacks, si vous etes un petit fouineur, le FBI et les services secrets hongrois arriveront chez vous dans à peu près 3 minutes");
}
?>