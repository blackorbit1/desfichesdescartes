<?php
include_once("bdd.php");

if (isset($_POST) and array_key_exists("Deconnexion", $_POST)){
    $_SESSION['pseudo'] = "";
    $_SESSION['mdp'] = "";
}
$id_session = "hacker_du_92";
if(array_key_exists("pseudo", $_SESSION) and array_key_exists("mdp", $_SESSION)){
//include_once("compteur_vues.php");
    $user_session = htmlentities($_SESSION['pseudo'], ENT_QUOTES);
    $mdp_session = htmlentities($_SESSION['mdp'], ENT_QUOTES);
    //print("test");

    $req = $bdd->prepare("SELECT id, atavar_001 FROM ventilateur WHERE old_u_u_s_e_r = :old_u_u_s_e_r and old_m_m_d_p__ = :old_m_m_d_p__");
    $req->execute(array("old_u_u_s_e_r" => $_SESSION['pseudo'],
                        "old_m_m_d_p__" => $_SESSION['mdp']));

    //$req = $bdd->query('SELECT id, atavar_001 FROM ventilateur WHERE old_u_u_s_e_r = "' . $user_session . '" and old_m_m_d_p__ = "' . $mdp_session . '"'); // envoie de la requete pour savoir si le login est bon
    while ($donnees = $req->fetch()){
        //print($donnees ["id"] . "<br/>"); // Pour le debuggage
        $id_session = $donnees["id"]; // Reception de l'id pour si il est dans la bse de données
        $urlavatar = $donnees["atavar_001"];
        //print($id . "<br/>"); // Pour le debuggage
    }
    $req->closeCursor();
}


?>