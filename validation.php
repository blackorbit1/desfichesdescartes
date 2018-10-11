<?php
session_cache_limiter('private_no_expire, must-revalidate');
session_start();
include_once("test_session.php");
include_once("navigateur.php");
include_once("compteur_vues.php");
include_once("logs.php");

if ($id_session != "hacker_du_93"){
    $action = "Une personne non administrateur a tenté d'acceder à la page de validation";
    logs($user_session, $action);
    //$bdd->exec('INSERT INTO logs_admins(admin, date, IP, navigateur, action) VALUES("utilisateur" , NOW(), "'. htmlentities($_SERVER["REMOTE_ADDR"], ENT_QUOTES) .'", "'. $navigateur .'" , "'. $action .'")');

    header("Location: index.php");
    exit; //ou die, c'est pareil
}
$navigateur = get_browsername();

$action = "Utilisation de la page de validation";
logs($user_session, $action);
//$bdd->exec('INSERT INTO logs_admins(admin, date, IP, navigateur, action) VALUES("'. $user_session .'" , NOW(), "'. $_SERVER["REMOTE_ADDR"] .'", "'. $navigateur .'" , "'. $action .'")');

// nb de pages max
$ELEMENTSPARPAGE = 48; //  <<<<< CHANGER LE SYSTEME
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>DFDC Validation</title>
        <meta name="description" content="Bienvenu sur le site DesFichesDescartes, un site totallement indépendant de l’université et de tout organisme. Vous trouvez ici toutes les fiches que j’ai en ma disposition." />

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
        
        <script src="jquery.min.js"></script>
    </head>

    
    <body>
        <?php include_once("model_fichier_externe.php"); ?>
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
                    <p style="background-color: #fff9;color: black;padding: 5px;border-radius: 5px;font-size: 11px;margin: 15px;margin-bottom: 0;">
                        <b>Exemples de noms corrects:</b><br>
                        -> Examen jan 2017<br>
                        -> TD12 corrigé ex2<br>
                        -> TD3<br>
                        -> CM7 PHP<br>
                        -> Partiel 2007 corrigé
                    </p>
                    <div class="bouton_ouvrir_fichier_externe" onClick="ouvrirFichierExterne()">Ajouter fichier externe</div>
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


                            // EXECUTER LA REQUETE

                            //print("<pre>"); print_r($_POST); print("</pre>"); 
                            //print(is_numeric($_POST["id"]));
                            if (isset($_POST) and array_key_exists("supprimer", $_POST) and is_numeric($_POST["id"])) { // Si on a demandé de supprimer le fichier
                                $bdd->exec("UPDATE fichiers SET supprime = 1 WHERE id = ". $_POST["id"]);
                                $action = "Refus/suppression du fichier: " . htmlspecialchars($_POST["nomfichier"]) . " - (id: " . $_POST["id"] . ")";
                                logs($user_session, $action);
                                //$bdd->exec('INSERT INTO logs_admins(admin, date, IP, navigateur, action) VALUES("'. $user_session .'" , NOW(), "'. $_SERVER["REMOTE_ADDR"] .'", "'. $navigateur .'" , "'. $action .'")');
                                //die(print_r($bdd->errorInfo()));
                                ?><div class="deleted">Le fichier <strong><?php print(htmlspecialchars($_POST["nomfichier"]))?></strong> a bien été supprimé</div><br/><?php
                                //print("Le fichier a été refusé");
                            } elseif (isset($_POST["idannuler"]) and is_numeric($_POST["idannuler"])) {
                                $bdd->exec("UPDATE fichiers SET valide = 0 WHERE id = ". $_POST["idannuler"]);
                                $action = "Annulation de la validation du fichier: " . htmlspecialchars($_POST["nomfichier"]) . " - (id: " . $_POST["idannuler"] . ")";
                                logs($user_session, $action);
                                //$bdd->exec('INSERT INTO logs_admins(admin, date, IP, navigateur, action) VALUES("'. $user_session .'" , NOW(), "'. $_SERVER["REMOTE_ADDR"] .'", "'. $navigateur .'" , "'. $action .'")');
                            } elseif (isset($_POST) and array_key_exists("id", $_POST) and is_numeric($_POST["id"])) { // Si on a demandé de modifier et valider le fichier
                                //print("Le fichier a été accepté");

                                // Fonction d'enregistrement de chaque fichiers dans la base de données
                                function fichiers_BDD($bdd, 
                                                        $nom, 
                                                        $niveau,
                                                        $annee,
                                                        $matiere,
                                                        $type,
                                                        $corrige,
                                                        $id){
                                    $req = $bdd->prepare('UPDATE fichiers SET
                                                                            nom = :nom,
                                                                            niveau = :niveau,
                                                                            annee = :annee,
                                                                            matiere = :matiere,
                                                                            type = :type,
                                                                            corrige = :corrige,
                                                                            valide = :valide
                                                                        WHERE id = :id ');
                                    $erreur = $req->execute(array(
                                        "nom" => $nom,
                                        "niveau" => $niveau,
                                        "annee" => $annee,
                                        "matiere" => $matiere,
                                        "type" => $type,
                                        "corrige" => $corrige,
                                        "valide" => 1,
                                        "id" => $id
                                    ));
                                    $req->closeCursor();
                                    return($erreur);
                                }


                                if($_POST["ext_fichier"] == "pdf" or $_POST["ext_fichier"] == "png" or $_POST["ext_fichier"] == "JPG" or $_POST["ext_fichier"] == "jpeg"){

                                    $utilise = 'uploads/'. $_POST["nom_fichier"] .'.'. $_POST["ext_fichier"];
                                    $rendu = 'uploads/'. $_POST['nom_fichier'] .'.jpg';
                                    //$requete = 'gs -dSAFER -dBATCH -sDEVICE=jpeg -dTextAlphaBits=4 -dGraphicsAlphaBits=4 -r300 -sOutputFile='.$rendu.' '.$utilise;
                                    //$requete = 'convert "'.$utilise.'" -colorspace RGB -resize 800 "'.$rendu.'"';
                                    $requete = 'convert "'.$utilise.'[0]" "'.$rendu.'"';

                                    //print("<br/>Requete: ". $requete ."<br/>_________");

                                    //putenv( 'PATH=' . getenv( 'PATH' ) . ':' . dirname( '/usr/local/bin/gs' ) );
                                    //exec( '/usr/local/bin/convert uploads/'. $_POST["nom_fichier"] .'.'. $_POST["ext_fichier"] . '[0] -thumbnail 600x "uploads/'. $_POST['nom_fichier'] .'.jpg"', $output, $return );
                                    //exec( "/usr/local/bin/convert '/path/to/file.pdf'[0] -thumbnail 600x '/path/to/file.pdf.png'", $output, $return );
                                    exec($requete, $output, $return);
                                    
                                    /*
                                    print("<pre>"); print_r($output); print("</pre>");
                                    print("<br/>Output: ". $output . "<br/>_________<br/>");

                                    print("<pre>"); print_r($return); print("</pre>");
                                    print("<br/>Return: ". $return . "<br/>_________<br/>");

                                    
                                    print("<br/>Métadonnées du fichier utilisé: ". file_exists('uploads/'. $_POST["nom_fichier"] .'.'. $_POST["ext_fichier"]) ."<br/>");
                                    print("<pre>"); print_r(get_meta_tags($utilise)); print("</pre>");
                                    */
                                    //print($utilise["description"]);
                                    //print($utilise);
                                    /*
                                    print("<br/>__________<br/>");

                                    print("<br/>Métadonnées du fichier créé: ". file_exists('uploads/'. $_POST['nom_fichier'] .'.jpg') ."<br/>");
                                    print("<pre>"); print_r(get_meta_tags('rendu')); print("</pre>");
                                    */


                                    //exec('gs -sDEVICE=jpeg -dAutoRotatePages=/None -o D:\temp\cover_thumb.jpg -dFirstPage=1 -dLastPage=1 -dNOPAUSE -dJPEGQ=100 -dGraphicsAlphaBits=4 -dTextAlphaBits=4 -r150 -dUseTrimBox D:\temp\pdfs\a.pdf -q');

                                    // Création d'une miniature du pdf
                                    /*
                                    $imagick = new \Imagick("uploads/". $_POST['nom_fichier'] .".". $_POST["ext_fichier"] . '[0]');
                                    $imagick->setFormat("jpg");
                                    $imagick->writeImage("uploads/". $_POST['nom_fichier'] .".jpg");
                                    */
                                    // Redimentionnement
                        
                                    $source = imagecreatefromjpeg("uploads/". $_POST['nom_fichier'] .".jpg");
                                    $destination = imagecreatetruecolor(150, 133);         
                        
                                    $largeur_source = imagesx($source);
                                    $hauteur_source = imagesy($source);
                                    $largeur_destination = imagesx($destination);
                                    $hauteur_destination = imagesy($destination);
                        
                                    imagecopyresampled($destination, $source, 0, 0, 0, 0, $largeur_destination, $hauteur_destination, $largeur_source, $hauteur_source);
                                    imagejpeg($destination, "uploads/". $_POST['nom_fichier'] .".jpg");
                                } /*else {
                                    copy("no_template.jpg", "uploads/". $_POST['nom_fichier'] . "jpg");
                                }*/

                                

                                // Donner des valeurs par défaut aux variables qui vont etre modifier (pour éviter erreur si mauvais POST)
                                
                                $niveau = "inconnu";
                                $matiere = "inconnu";
                                $valide = 0;
                                $id = 0;

                                $verif[] = preg_match("#DELETE#i", $_POST["nom"]);
                                $verif[] = preg_match("#SELECT#i", $_POST["nom"]);
                                $verif[] = preg_match("#MODIFY#i", $_POST["nom"]);
                                $verif[] = preg_match("#WHERE#i", $_POST["nom"]);
                                $verif[] = preg_match("#CHANGE#i", $_POST["nom"]);
                                $verif[] = preg_match("#admin#i", $_POST["nom"]);
                                $verif[] = preg_match("#UNION#i", $_POST["nom"]);
                                $verif[] = preg_match("#FROM#i", $_POST["nom"]);
                                $verif[] = preg_match("#'#i", $_POST["nom"]);
                                $verif[] = preg_match('#"#i', $_POST["nom"]);

                                // Donne les valeurs qui ont été reçus par le POST aux variables
                                $nom = (array_key_exists("nom", $_POST) && ($_POST["nom"] != "")) ? htmlspecialchars($_POST["nom"]) : "inconnu";
                                $annee = (array_key_exists("annee", $_POST) && is_numeric($_POST["annee"]))? $_POST["annee"] : 0;
                                $type = (array_key_exists("type", $_POST) && ($_POST["type"] != "")) ? htmlentities($_POST["type"]) : "inconnu";
                                $corrige = array_key_exists("corrige", $_POST)? 1 : 0 ;
                                if(array_key_exists("id", $_POST) and is_numeric($_POST["id"])){
                                    $id = htmlentities($_POST["id"]);
                                    if(array_key_exists($_POST["id"], $_POST)){
                                        $matiere = htmlentities($_POST[$_POST["id"]]);
                                        //$bdd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
                                        $niveau = $bdd->query('SELECT niveau FROM matiere WHERE code = "' . $matiere . '"');
                                        $niveau = $niveau->fetch();
                                        $niveau = $niveau["niveau"];
                                    }
                                }

                                
                                if(in_array(1, $verif)){
                                    ?><div class='deleted'>Nom incorrect (guillemets, apostrophe, commandes SQL, ou autre)</div><br/><?php
                                } elseif($nom != "inconnu" and $niveau != "inconnu" and $annee != 0 and $matiere != "inconnu" and $type != "inconnu" and $id != 0){
                                    // Si le POST est bon --> Lancement de la fonction qui fait la requete
                                    if(fichiers_BDD($bdd, $nom, $niveau, $annee, $matiere, $type, $corrige, $id)){
                                        $action = "Ajout du fichier: " . $nom . " - (id: " . $id . "; niveau: " . $niveau . "; annee: " . $annee . "; matiere: " . $matiere . "; type: " . $type . "; corrige: " . $corrige . ")";
                                        logs($user_session, $action);
                                        //$bdd->exec('INSERT INTO logs_admins(admin, date, IP, navigateur, action) VALUES("'. $user_session .'" , NOW(), "'. $_SERVER["REMOTE_ADDR"] .'", "'. $navigateur .'" , "'. $action .'")');
                                        ?>
                                        <div class='success'>
                                            <form action="" method="post" enctype="multipart/form-data">
                                                Le fichier <strong><?php print($nom)?></strong> a bien été mis en ligne
                                                <input type="hidden" name="nomfichier" value=<?php print("'". htmlspecialchars($_POST["nom_fichier"]) ."'"); ?> />
                                                <input type="hidden" name="idannuler" value=<?php print("'". $_POST["id"] ."'") ?>/>
                                                <input style="background-color: rgb(147, 255, 152); border-color: #05050580;border-radius: 3px;border-width: 1px;border-style: solid;float: right;" type="submit" value="Annuler" />
                                            </form>
                                        </div><br/><?php
                                    } else {
                                        ?><div class='deleted'>Error xxts432.34000000: root where deleted, toto became Soto !</div><br/><?php
                                    }
                                    
                                } else {
                                    ?><div class='deleted'>Il manque des informations !</div><br/><?php
                                }


                            } //else { print("<pre>"); print_r($_POST); print("<pre>"); } // A SUPPRIMER AVANT LA SORTIE
                            //print("<pre>"); print_r($_POST); print("<pre>");
                            //print("<pre>"); print_r($_FILES); print("<pre>"); // IDEM Juste pour le debug

                            // FIN DU TRAITEMENT DE LA REQUETE

                            $req = $bdd->query("SELECT count(*) as nombre FROM fichiers WHERE valide = 0 and supprime = 0");
                            $donnees = $req->fetch();
                        ?>

                        <h2 class="t_admin">Validez validez !! (reste <?php print($donnees["nombre"]); ?> fichiers à valider)</h2>

                        <table style="width: 100%; table-layout:fixed;">
                            <tr>
                                <td><a class="boutonNiveauValidation" href="validation.php?niveau=tous" <?php print(((!isset($_GET["niveau"])) || ($_GET["niveau"] == "tous"))?("style='background-color: #0009;'"):"") ?>>Tous <?php print(" <span class='filtreTypeAmountValidation'>". $donnees["nombre"] ."</span>"); ?></a></td>
                                <?php $req = $bdd->query("SELECT count(*) as nombre FROM fichiers WHERE valide = 0 and supprime = 0 and niveau = 'L1_math_info'"); $donnees = $req->fetch(); ?>
                                <td><a class="boutonNiveauValidation" href="validation.php?niveau=L1_math_info" <?php print((isset($_GET["niveau"]) && ($_GET["niveau"] == "L1"))?("style='background-color: #0009;'"):"") ?>>L1 <?php print(" <span class='filtreTypeAmountValidation'>". $donnees["nombre"] ."</span>"); ?></a></td>
                                <?php $req = $bdd->query("SELECT count(*) as nombre FROM fichiers WHERE valide = 0 and supprime = 0 and niveau = 'L2_math_info'"); $donnees = $req->fetch(); ?>
                                <td><a class="boutonNiveauValidation" href="validation.php?niveau=L2_math_info" <?php print((isset($_GET["niveau"]) && ($_GET["niveau"] == "L2"))?("style='background-color: #0009;'"):"") ?>>L2 <?php print(" <span class='filtreTypeAmountValidation'>". $donnees["nombre"] ."</span>"); ?></a></td>
                                <?php $req = $bdd->query("SELECT count(*) as nombre FROM fichiers WHERE valide = 0 and supprime = 0 and niveau = 'L3_math_info'"); $donnees = $req->fetch(); ?>
                                <td><a class="boutonNiveauValidation" href="validation.php?niveau=L3_math_info" <?php print((isset($_GET["niveau"]) && ($_GET["niveau"] == "L3"))?("style='background-color: #0009;'"):"") ?>>L3 <?php print(" <span class='filtreTypeAmountValidation'>". $donnees["nombre"] ."</span>"); ?></a></td>

                                <?php $req = $bdd->query("SELECT count(*) as nombre FROM fichiers WHERE valide = 0 and supprime = 0 and niveau = 'M1_info'"); $donnees = $req->fetch(); ?>
                                <td><a class="boutonNiveauValidation" href="validation.php?niveau=M1_info" <?php print((isset($_GET["niveau"]) && ($_GET["niveau"] == "M1_info"))?("style='background-color: #0009;'"):"") ?>>M1 info <?php print(" <span class='filtreTypeAmountValidation'>". $donnees["nombre"] ."</span>"); ?></a></td>
                                <?php $req = $bdd->query("SELECT count(*) as nombre FROM fichiers WHERE valide = 0 and supprime = 0 and niveau = 'M2_info'"); $donnees = $req->fetch(); ?>
                                <td><a class="boutonNiveauValidation" href="validation.php?niveau=M2_info" <?php print((isset($_GET["niveau"]) && ($_GET["niveau"] == "M2_info"))?("style='background-color: #0009;'"):"") ?>>M2 info <?php print(" <span class='filtreTypeAmountValidation'>". $donnees["nombre"] ."</span>"); ?></a></td>
                                <?php $req = $bdd->query("SELECT count(*) as nombre FROM fichiers WHERE valide = 0 and supprime = 0 and niveau = 'M1_math'"); $donnees = $req->fetch(); ?>
                                <td><a class="boutonNiveauValidation" href="validation.php?niveau=M1_math" <?php print((isset($_GET["niveau"]) && ($_GET["niveau"] == "M1_math"))?("style='background-color: #0009;'"):"") ?>>M1 maths <?php print(" <span class='filtreTypeAmountValidation'>". $donnees["nombre"] ."</span>"); ?></a></td>
                                <?php $req = $bdd->query("SELECT count(*) as nombre FROM fichiers WHERE valide = 0 and supprime = 0 and niveau = 'M2_math'"); $donnees = $req->fetch(); ?>
                                <td><a class="boutonNiveauValidation" href="validation.php?niveau=M2_math" <?php print((isset($_GET["niveau"]) && ($_GET["niveau"] == "M2_math"))?("style='background-color: #0009;'"):"") ?>>M2 maths <?php print(" <span class='filtreTypeAmountValidation'>". $donnees["nombre"] ."</span>"); ?></a></td>

                            </tr>
                        </table>


                        <!--
                        <p>Dans le nom d'un TP, TD, CM, préciser:<br>
                            -> <b>Type</b> (TD, TP, CM, ...)<br>
                            -> <b>Numéro</b> (TD7, CM3, ...)<br>
                            -> <b>Intitulé</b> (TP2 Gestion des fichiers, CM5 Expr régulières, ...)<br>
                            Dans le nom d'un Partiel, CC, DM, préciser:<br>
                            -> <b>Type</b> (Examen, CC, Partiel, Rattrapage/session 2, ...)<br>
                            -> <b>Année</b> (Examen session 2 2013, Partiel 2016, Examen janvier 2017, ...)<br>
                            -> <b>si c'est corrigé ou non<b>
                        </p>
                        -->
                        
                        







                        <?php

                        

                        


                                                        ////////////////////////////////////////////////////////
                                                        /////  AFFICHER LA PAGE (seulement de la lecture)  /////
                                                        ////////////////////////////////////////////////////////





                        $page = 1;
                        if(isset($_GET["page"]) and is_numeric($_GET["page"])) $page = $_GET["page"];
                        $page_niveau = (isset($_GET["niveau"]) && ($_GET["niveau"] != "tous"))?("and niveau = '". htmlspecialchars($_GET["niveau"]) ."'"):("");
                        //print($page_niveau);

                        //$bdd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
                        $req = $bdd->query("SELECT  id,
                                                    nom_fichier, 
                                                    nom_fichier_old,
                                                    nom,
                                                    taille_fichier, 
                                                    extension_fichier, 
                                                    date_envoi, 
                                                    ip_user, 
                                                    navigateur, 
                                                    langue,
                                                    niveau,
                                                    annee,
                                                    matiere,
                                                    type,
                                                    corrige 
                                            FROM fichiers 
                                            WHERE valide = 0 and supprime = 0 ". $page_niveau ."
                                            ORDER BY id DESC LIMIT " . ($page-1)*5 . ", " . $page*5);

                        while ($donnees = $req->fetch()){
                            ?>
                            <div class="caseAdm arrondi">
                                <div class="infosFicFixes">
                                    <p style="margin: 0;"><?php print("Fichier n°" . $donnees["id"] . " : <strong>" . htmlspecialchars($donnees["nom_fichier"]) . "</strong> "); ?><input type="button" value="Ouvrir" onclick="window.location='uploads/<?php print($donnees["nom_fichier"]) ?>';">
                                    <br/><?php  print("Poids: <strong>" . $donnees["taille_fichier"] . "</strong>");
                                                print("<br/>Date envoi: <strong>" . $donnees["date_envoi"] . "</strong>");
                                                print("<br/>IP uploader: <strong>" . $donnees["ip_user"] . "</strong>");
                                                print("<br/>Navigateur: <strong>" . htmlspecialchars($donnees["navigateur"]) . "</strong>&nbsp&nbsp&nbsp&nbsp&nbsp " . htmlspecialchars($donnees["langue"]));
                                    ?></p>
                                </div>
                                <script>
                                    function hide()
                                    {
                                    document.getElementById('to_hide').style.display = 'none';
                                    }
                                </script>
                                <div>
                                    <form action="" style="color: #363636;" method="post" enctype="multipart/form-data">
                                    <p>
                                        Nom: 
                                            <input style="width: 500px;" type="text" name="nom" placeholder=<?php print("'Ancien nom: " . htmlspecialchars($donnees["nom_fichier_old"]) . "'") ?> value=<?php htmlspecialchars(print("'" . $donnees["nom"] . "'")) ?>/>
                                            <aze style="color: rgb(56, 56, 56);border: 1px solid white;border-radius: 2px;background-color: #ffffff4d;padding-left: 10px;padding-right: 10px;"><?php print(htmlspecialchars($donnees["nom_fichier_old"])) ?></aze>
                                            <br/>
                                            
                                            
                                            Année: 
                                            <select name="annee" id="preselection" onchange="hide()">
                                                <option value=<?php print($donnees["annee"]) ?> id="to_hide"><?php print($donnees["annee"]) ?></option>
                                                <?php
                                                    for($i = 2000; $i<=((int) date("Y")); $i++){
                                                        print('<option value="'. $i .'">'. $i .'</option>');
                                                    }
                                                ?>
                                            </select>

                                            <br/>
                                            Type: 
                                            <select name="type" id="preselection" onchange="hide()">
                                                <option value=<?php htmlspecialchars(print("'" . $donnees["type"] . "'")) ?> id="to_hide"><?php htmlspecialchars(print($donnees["type"])) ?></option>
                                                <option value="annale">annale</option>
                                                <option value="cours">cours</option>
                                                <option value="TD">TD</option>
                                                <option value="TP">TP</option>
                                                <option value="fiche">fiche</option>
                                                <option value="tuto">tuto</option>
                                                <option value="ressource">ressource</option>
                                                <option value="exempleTravail">exemple de travail</option>
                                                <option value="autre">autre</option>
                                            </select>
                                            <br/>
                                            Corrigé: <input type="checkbox" name="corrige" id="corrige" <?php if($donnees["corrige"] == TRUE) print("checked") ?>/>

                                            <br/><br/><?php
                                            $matiere = $bdd->query('SELECT nom FROM matiere WHERE code = "' . $donnees["matiere"] . '"');
                                            $matiere = $matiere->fetch();
                                            if (isset($matiere)){
                                                $matiere = $matiere["nom"];
                                            } else $matiere = "" ;
                                            ?>
                                            Matière entrée: <?php print(htmlspecialchars($donnees["matiere"]) . " <strong>" . htmlspecialchars($matiere) . "</strong>") ?>
                                            <select name="<?php print($donnees["id"]) ?>">
                                                <option value="prerentree">Pré-rentrée / info générales</option>
                                                <?php
                                                    
                                                    $reqMat = $bdd->query("SELECT code, nom, niveau FROM matiere");


                                                    while ($donnees_L1 = $reqMat->fetch()){
                                                        $cochee = "";
                                                        if($donnees_L1["code"] == $donnees["matiere"]){
                                                            $selectionne = ' selected';
                                                        } else {
                                                            $selectionne = '';
                                                        }
                                                        print('<option value="'. $donnees_L1["code"] .'"  '. $selectionne .'/>' . $donnees_L1["nom"] . "</option>");
                                                    } 
                                                ?>
                                                <!--<option value="prerentree">Pré-rentrée / info générales</option>-->
                                            </select>
                                            <br>
                                            Niveau entré: <?php print(htmlspecialchars($donnees["niveau"])) ?> <br>
                                        

                                           
                                            <?php /*
                                            <div>
                                                <div class="matpannel">
                                                    <strong>L1: </strong><br/><?php
                                                    
                                                    $req_L1 = $bdd->query("SELECT code, nom, niveau FROM matiere WHERE niveau = 'L1_math_info'");
                                                    $req_L2 = $bdd->query("SELECT code, nom, niveau FROM matiere WHERE niveau = 'L2_math_info'");
                                                    $req_L3 = $bdd->query("SELECT code, nom, niveau FROM matiere WHERE niveau = 'L3_math_info'");

                                                    while ($donnees_L1 = $req_L1->fetch()){
                                                        $cochee = "";
                                                        if($donnees_L1["code"] == $donnees["matiere"]) $cochee = ' checked="checked" ';
                                                        print(' <div class="matiere"><input type="radio" name="'. $donnees["id"] .'" value="'. $donnees_L1["code"] .'" id="'. $donnees_L1["code"]. $donnees["id"] .'" '. $cochee .'/><label for="'. $donnees_L1["code"]. $donnees["id"] .'" class="casemat">' . $donnees_L1["nom"] . '</label></div>');
                                                    } ?>
                                                </div>
                                                <div class="matpannel">
                                                    <strong>L2: </strong><br/><?php
                                                    while ($donnees_L1 = $req_L2->fetch()){
                                                        $cochee = "";
                                                        if($donnees_L1["code"] == $donnees["matiere"]) $cochee = ' checked="checked" ';
                                                        print(' <div class="matiere"><input type="radio" name="'. $donnees["id"] .'" value="'. $donnees_L1["code"] .'" id="'. $donnees_L1["code"]. $donnees["id"] .'" '. $cochee .'/><label for="'. $donnees_L1["code"]. $donnees["id"] .'" class="casemat">' . $donnees_L1["nom"] . '</label></div>');
                                                    } ?>
                                                </div>
                                                <div class="matpannel">
                                                    <strong>L3: </strong><br/><?php
                                                    while ($donnees_L1 = $req_L3->fetch()){
                                                        $cochee = "";
                                                        if($donnees_L1["code"] == $donnees["matiere"]) $cochee = ' checked="checked" ';
                                                        print(' <div class="matiere"><input type="radio" name="'. $donnees["id"] .'" value="'. $donnees_L1["code"] .'" id="'. $donnees_L1["code"]. $donnees["id"] .'" '. $cochee .'/><label for="'. $donnees_L1["code"]. $donnees["id"] .'" class="casemat">' . $donnees_L1["nom"] . '</label></div>');
                                                    } ?>
                                                </div>
                                            </div>
                                            */ ?>
                                            
                                        
                                            <br/>
                                            <input type="hidden" name="id" value=<?php print($donnees["id"]); ?> />
                                            <input type="hidden" name="nom_fichier" value=<?php print(current(explode('.', htmlspecialchars($donnees["nom_fichier"])))); ?> />
                                            <input type="hidden" name="ext_fichier" value=<?php $ext = explode('.', htmlspecialchars($donnees["nom_fichier"])); print(end($ext)); ?> />

                                            <input class="boutonValider" type="submit" value="Valider" />
                                            

                                    
                                        </p>
                                    </form>
                                    <form action="" method="post" enctype="multipart/form-data" style="color: #d35656; font-size: 11px;" >
                                        <input type="hidden" name="id" value=<?php print($donnees["id"]); ?> />
                                        <input type="hidden" name="nomfichier" value=<?php print(htmlspecialchars($donnees["nom_fichier"])); ?> />
                                        <input type="hidden" name="supprimer" value="supprimer" />
                                        <input class="boutonSupprimer" type="submit" value="Refuser" /> --> irréversible
                                    </form>
                                <br/>
                                </div>
                            </div>
                            <br/>
                        <?php
                        }
                        $req->closeCursor();


                        // Pour choisir la page

                        $page = 1;
                        $suivant = 1;
                        if(isset($_GET) and array_key_exists("page", $_GET) and is_numeric($_GET["page"])) $page = $_GET["page"];
                        $nb_fichiers = $bdd->query('SELECT count(id) as nb FROM fichiers WHERE valide = 0 and supprime = 0 '. $page_niveau);
                        $nb_fichiers = $nb_fichiers->fetch();
                        $nb_fichiers = $nb_fichiers["nb"];
                        if($page*5 > $nb_fichiers) $suivant = 0 ;
                        ?> <div style="overflow: auto;margin-bottom: 8px;"> <?php
                        if($page > 1){ /*Si il peut y avoir une page précédente*/?>
                            <form action="" method="get" enctype="multipart/form-data" style="float: left;" >
                                <input type="hidden" name="page" value="<?php print($page - 1) ?>" />
                                <input type="hidden" name="niveau" value="<?php print($_GET['niveau']) ?>" />
                                <input style="background-color: #fff3;border-style: solid;border-width: 1px;line-height: 20px;border-radius: 4px;" type="submit" value="Précédent (<?php print($page - 1) ?>)" />
                            </form>
                        <?php }
                        if($suivant){ /*Si il y a une page suivante*/?>
                            <form action="" method="get" enctype="multipart/form-data" style="float: left;" >
                                <input type="hidden" name="page" value="<?php print($page + 1) ?>" />
                                <input type="hidden" name="niveau" value="<?php print(isset($_GET['niveau'])?$_GET['niveau']:'tous') ?>" />
                                <input style="background-color: #fff3;border-style: solid;border-width: 1px;line-height: 20px;border-radius: 4px;margin-left: 5px;" type="submit" value="Suivant (<?php print($page + 1) ?>)" />
                            </form>
                        <?php } ?>

                        </div> 



                
                    </div>
                </td>
            </table>


            
        </div>

        
        <!--<script src="quidinedort.js"></script>-->
    </body>
</html>


