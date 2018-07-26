<?php
session_cache_limiter('private_no_expire, must-revalidate');
session_start();
include_once("test_session.php");
include_once("navigateur.php");
include_once("compteur_vues.php");
include_once("logs.php");

$navigateur = get_browsername();

if ($id_session != "hacker_du_93" && $id_session != "user"){
    $action = "A tenté d'acceder à la page de compte sans etre admin ou utilisateur inscrit";
    logs(isset($_SESSION["pseudo"])?$_SESSION["pseudo"]:"inconnu", $action);
    header("Location: index.php");
    exit; //ou die, c'est pareil
} else {
    $action = "Acces à lapage de compte";
    logs(isset($_SESSION["pseudo"])?$_SESSION["pseudo"]:"inconnu", $action);
}

//$bdd->exec('INSERT INTO logs_admins(admin, date, IP, navigateur, action) VALUES("'. $user_session .'" , NOW(), "'. $_SERVER["REMOTE_ADDR"] .'", "'. $navigateur .'" , "'. $action .'")');

// nb de pages max
$ELEMENTSPARPAGE = 48; //  <<<<< CHANGER LE SYSTEME
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>DFDC Compte</title>
        <meta name="description" content="Gestion de compte intergénérationnelle" />

        <link rel="stylesheet" href="index.css" >
        <link rel="icon" type="image/png" href="favicon2.png" />

        <link rel="shortcut icon" type="image/png" href="favicon2.png">
        <meta name="theme-color" content="#6cbbff">
        <meta name="keywords" content="desfichesdescartes, cours, annales, corrigés, td, tp" />
        <meta name="msapplication-TileColor" content="#6cbbff">
        <meta name="msapplication-TileImage" content="iconmetrowin10.png">
        <meta name="application-name" content="DesFichesDescartes">
        <meta property="og:title" content="DesFichesDescartes" />
        <meta property="og:description" content="Site qui contient des TD/TP/Cours/Annales/Fiches/Corrigés/.. pour toutes les matières de math=info de l'université Paris Descartes" />
        <meta property="og:image" content="iconmetrowin10.png" />
    </head>

    
    <body>

        <background id="background"></background>
        <?php include_once("bande_session.php"); if($id_session == "hacker_du_93") print("<br style='line-height: 24px;'/>") // Si l'user est un admin ?>

        <?php

            

            /////////////////////////////////////////////////////////////
            //         TRAITEMENT DE LA DEMANDE D'INVALIDATION         //
            /////////////////////////////////////////////////////////////

            /*
            if($id_session == "hacker_du_93" and isset($_POST)){
                //print("<pre>"); print_r($_POST); print("</pre>");
                $navigateur = get_browsername();
                
                while($fichier_demande = current($_POST)){
                    //print(key($_POST) . "<br/>");
                    $nom_du_fichier_xpl = explode("¤", key($_POST));
                    $nom_du_fichier_deb = current($nom_du_fichier_xpl);
                    $nom_du_fichier_fin = next($nom_du_fichier_xpl);
                    $nom_simple = end($nom_du_fichier_xpl);
                    $action = "Invalidation du fichier: " . htmlspecialchars($nom_simple);
                    $bdd->exec('INSERT INTO logs_admins(admin, date, IP, navigateur, action) VALUES("'. $user_session .'" , NOW(), "'. $_SERVER["REMOTE_ADDR"] .'", "'. $navigateur .'" , "'. $action .'")');
                    $bdd->exec("UPDATE fichiers SET valide = 0 WHERE nom_fichier = '" . $nom_du_fichier_deb . "." . $nom_du_fichier_fin . "'");
                    next($_POST);
                }
                
            }
            */


            /////////////////////////////////////////////////////////////
            //                RECUPERATION DES MATIERES                //
            /////////////////////////////////////////////////////////////

            //$req_L1 = $bdd->query("SELECT code, nom FROM matiere WHERE niveau = 'L1_math_info'");
            //$req_L2 = $bdd->query("SELECT code, nom FROM matiere WHERE niveau = 'L2_math_info'");
            //$req_L3 = $bdd->query("SELECT code, nom FROM matiere WHERE niveau = 'L3_math_info'");
        ?>


                                                
        <div class="page" id="page">
            <div class="entete">
            <a title="logo du site" href="index.php"><img src="logos/logo<?php print(rand(1, 22)); ?>.png" alt="DESFICHESDESCARTES" width="847"></a>
                <!--<a class="nomSite" href="index.php"><img src="logo.png"></a>-->
            </div>


            <table style="width: 100%;">
                <td valign="top" style="width: 232px;">
                    <?php
                        include_once("caseMat.php");
                    ?>

                    </td>
                    <?php
                        if(isset($_GET["onglet"])){
                            print("
                            <script>
                                changeOnglet('". $_GET["onglet"] ."', 'case". $_GET["onglet"] ."');
                            </script>
                            ");
                        }
                    ?>





                <td valign="top">
                    <div class="droite arrondi padding20px" style="background-color: #fff9;">


                        <?php
                            $req = $bdd->prepare("SELECT id_number, id, old_u_u_s_e_r, atavar_001, mivault, cadecount FROM ventilateur WHERE old_u_u_s_e_r = :old_u_u_s_e_r and old_m_m_d_p__ = :old_m_m_d_p__");
                            //print("aaaaaaaaaaaa". (int) $req ."aaaaaaaaaaaaa");
                            $req->execute(array("old_u_u_s_e_r" => $_SESSION['pseudo'],
                                                "old_m_m_d_p__" => $_SESSION['mdp']));
                            $donnees = $req->fetch();
                        ?>

                        <h2 class="t_admin">Compte</h2>

                        <table style="width: 100%; table-layout:fixed;">
                            <tr>
                                <td style="width: 220px;" valign="top"> <!-- Avatar + ID compte -->
                                    <div class="cadre_modifier_avatar">
                                        <img src="uploads/<?php print($donnees["atavar_001"]); ?>" alt="sabeug2partou" />
                                        <div class="modifier_avatar"><br>Modifier</div>
                                    </div>

                                    <div class="id_compte">ID compte: <strong><?php print($donnees["id_number"]); ?></strong></div>

                                </td>
                                <td valign="top"> <!-- Reste -->
                                Pseudo : <input style="width: 500px;" type="text" name="pseudo" value=<?php htmlspecialchars(print("'" . $donnees["old_u_u_s_e_r"] . "'")) ?>/>
                                <br><div class="bouton" onClick="changerMotDePasse()">Changer de mot de passe</div>
                                <!-- <input style="width: 500px;" type="text" name="nom" value=<?php htmlspecialchars(print("'" . $donnees["old_u_u_s_e_r"] . "'")) ?>/> -->
                                <br>Niveau : 
                                <select name="niveau">
                                    <option value=<?php print($donnees["mivault"]) ?> id="to_hide"><?php print($donnees["mivault"]) ?></option>
                                    <option value="L1_math_info">L1</option>
                                    <option value="L2_math">L2 (maths)</option>
                                    <option value="L2_info">L2 (info)</option>
                                    <option value="L2_math_info">L2 (double licence)</option>
                                    <option value="L3_math">L3 (maths)</option>
                                    <option value="L3_info">L3 (info)</option>
                                    <option value="L3_math_info">L3 (double licence)</option>
                                </select>


                                
                                </td>
                            </tr>
                        </table>


                
                    </div>
                </td>
            </table>


            
        </div>

        
        <!--<script src="quidinedort.js"></script>-->
    </body>
</html>


