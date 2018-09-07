<?php
//setcookie('cookie_name', 'blablabla', (time() + 3600));
error_reporting(E_ALL);
$individuDemandeCookie = false;
//setcookie('popup', 'popup', time() + 1, null, null, false, true); 
/*
if(!isset($_COOKIE['popup']) && !isset($_GET["matiere"])){ // si il n'y a pas de cookies /// /// /// <<< Pour la popup de demande d'aide
    setcookie('popup', 'popup', time() + 24*3600, null, null, false, true); 
    //print("Individu demande cookies");
    $individuDemandeCookie = true;
    
}
*/
//session_cache_limiter('private_no_expire, must-revalidate');
session_start();
include_once("bdd.php");
include_once("test_session.php");
include_once("navigateur.php");
include_once("compteur_vues.php");
include_once("logs.php");

$navigateur = get_browsername();

if ($id_session == "hacker_du_93" and isset($_POST["supprimer"]) and is_numeric($_POST["id"])){ // SUPPRESSION D'UNE ANNONCE //
    $reponse = $bdd->query("SELECT message FROM avis_recherche WHERE id = ". $_POST["id"]);
    $donnees = $reponse->fetch();
    logs($user_session, "Suppression d'une annonce. id:". $_POST["id"] ." /// Contenu: ". $donnees["message"]);
    $bdd->exec("DELETE FROM avis_recherche WHERE id = " . $_POST["id"]);
}

// nb de pages max
$ELEMENTSPARPAGE = 100; //  <<<<< CHANGER LE SYSTEME
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title><?php
            if(isset($_GET["matiere"])){
                $req = $bdd->prepare("SELECT nom FROM matiere WHERE code = ?");
                $req->execute(array($_GET["matiere"]));
                $donnees = $req->fetch();
                print($donnees["nom"]);
            } else {
                print("DesFichesDescartes");
            }
        ?></title>
        <meta name="description" content="Bienvenu sur le site DesFichesDescartes, un site totallement indépendant de l’université et de tout organisme. Vous trouvez ici toutes les fiches que nous avons en notre possession. La partie la plus complète est actuellement celle de la L2 d’informatique (car c’est la classe dans laquel nous sommes) mais les autres parties vont s’étoffer petit à petit. " />

        <link rel="stylesheet" href="index.css" >
        <link rel="icon" type="image/png" href="favicon2.png" />

        <link rel="stylesheet" href="/jquery-ui.css">

        <link rel="shortcut icon" type="image/png" href="favicon2.png">
        <meta name="theme-color" content="#6cbbff">
        <meta name="keywords" content="desfichesdescartes, cours, annales, corrigés, td, tp" />
        <meta name="msapplication-TileColor" content="#6cbbff">
        <meta name="msapplication-TileImage" content="iconmetrowin10.png">
        <meta name="application-name" content="DesFichesDescartes">
        <meta property="og:title" content="DesFichesDescartes" />
        <meta property="og:description" content="Site qui contient des TD/TP/Cours/Annales/Fiches/Corrigés/.. pour toutes les matières de math=info de l'université Paris Descartes" />
        <meta property="og:image" content="iconmetrowin100.png" />


        <link rel="apple-touch-icon" href="apple-touch-icon.png" />
        <link rel="apple-touch-icon" sizes="57x57" href="apple-touch-icon-57x57.png" />
        <link rel="apple-touch-icon" sizes="72x72" href="apple-touch-icon-72x72.png" />
        <link rel="apple-touch-icon" sizes="76x76" href="apple-touch-icon-76x76.png" />
        <link rel="apple-touch-icon" sizes="114x114" href="apple-touch-icon-114x114.png" />
        <link rel="apple-touch-icon" sizes="120x120" href="apple-touch-icon-120x120.png" />
        <link rel="apple-touch-icon" sizes="144x144" href="apple-touch-icon-144x144.png" />
        <link rel="apple-touch-icon" sizes="152x152" href="apple-touch-icon-152x152.png" />
        <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon-180x180.png" />

        <script src="jquery.min.js"></script>
    </head>

    
    <body>
        <?php 
            if(!isset($_GET["matiere"])){
                include_once("proposerfiches.php"); 
                include_once("feedbacks.php"); 
                include_once("popupaideznous.php");
            } else {
                include_once("model_details_fichier.php");
            }
            include_once("auto_log_on_test_server.php");
        ?>

        <background id="background"></background>
        <?php include_once("bande_session.php"); if($id_session == "hacker_du_93") print("<br style='line-height: 24px;'/>") // Si l'user est un admin ?>
        

        <?php

            

            /////////////////////////////////////////////////////////////
            //         TRAITEMENT DE LA DEMANDE D'INVALIDATION         //
            /////////////////////////////////////////////////////////////

            if($id_session == "hacker_du_93" and isset($_POST["invaliderunfic"])){
                //print("<pre>"); print_r($_POST); print("</pre>");
                $navigateur = get_browsername();
                
                while($fichier_demande = current($_POST)){
                    //print(key($_POST) . "<br/>");

                    
                    $nom_du_fichier_xpl = explode("¤", key($_POST));
                    $nom_du_fichier_deb = current($nom_du_fichier_xpl);
                    $nom_du_fichier_fin = next($nom_du_fichier_xpl);
                    $nom_simple = end($nom_du_fichier_xpl);
                    
                    if(is_numeric(key($_POST))){
                        $req = $bdd->prepare("SELECT nom_fichier FROM fichiers WHERE id = :id");
                        $req->execute(array("id" => key($_POST)));
                        $donnees = $req->fetch();
                        $action = "Invalidation du fichier: " . htmlspecialchars($donnees["nom_fichier"]);
                        //print("<script> alert('" . $action . "'); </script>");
                        logs($user_session, $action);
                        //$bdd->exec('INSERT INTO logs_admins(admin, date, IP, navigateur, action) VALUES("'. $user_session .'" , NOW(), "'. $_SERVER["REMOTE_ADDR"] .'", "'. $navigateur .'" , "'. $action .'")');
                        $bdd->exec("UPDATE fichiers SET valide = 0 WHERE id = '" . key($_POST) . "'");

                    }
                    next($_POST);
                }
                
            }


            /////////////////////////////////////////////////////////////
            //                RECUPERATION DES MATIERES                //
            /////////////////////////////////////////////////////////////

            //$req_L1 = $bdd->query("SELECT code, nom FROM matiere WHERE niveau = 'L1_math_info'");
            //$req_L2 = $bdd->query("SELECT code, nom FROM matiere WHERE niveau = 'L2_math_info'");
            //$req_L3 = $bdd->query("SELECT code, nom FROM matiere WHERE niveau = 'L3_math_info'");
            //print("<pre>"); print_r($_POST); print("<pre>");
        ?>



                                                
        <div class="page" id="page">
            <div class="entete">
                <a title="logo du site" href="index.php"><img src="logos/logo<?php print(rand(1, 23)); ?>.png" alt="DESFICHESDESCARTES" width="847"></a>
                <!--<a class="nomSite" href="index.php"><img src="logo.png"></a>-->
            </div>


            <table style="width: 100%;">
                <tr>
                    <td valign="top" style="width: 232px;">

                        
                        
                        
                        <?php
                        include_once("caseMat.php");
                        ?>

                        <form action="postuler.php" method="get" >
                            <p>
                                <input class="jaidutpsadonner bouton" type="submit" value="J'ai du temps à donner pour aider" />
                            </p>
                        </form>

                    </td>
                    
                    <td valign="top">

                        

                            <?php 
            
                                                                    ///////////////////////////////////////
                                                                    ///////////////////////////////////////
                                                                    ////                               ////
                                                                    ////         PARTIE DROITE         ////
                                                                    ////                               ////
                                                                    ///////////////////////////////////////
                                                                    ///////////////////////////////////////
            
            
                            // >> Si on veut afficher la page d'accueil
                            //print("Est ce qu'il y a un GET ?" . (isset($_GET)));
                            //print("<pre>"); print_r($_GET); print("</pre>");

                        if(!(array_key_exists("type", $_GET)) and !(array_key_exists("annee", $_GET)) and !(array_key_exists("corrige", $_GET)) and !(array_key_exists("matiere", $_GET)) and !(array_key_exists("niveau", $_GET))){
                                

                                                                    ///////////////////////////////////////
                                                                    //         LA PAGE D'ACCUEIL         //
                                                                    ///////////////////////////////////////


                            ?>
                            <div class="droite arrondi translucide">

                            

                            

                            <?php
                                $req = $bdd->query("SELECT count(*) as nombre FROM fichiers WHERE valide=1");
                                $donnees = $req->fetch();
                            ?>
                            <div class="nbfichiers"><strong><?php print($donnees["nombre"]) ?></strong> fichiers !</div> <!-- nb de fichiers -->

                            <div>

                            
                                <?php
                                    if(get_browsername() == 'Internet Explorer'){
                                        ?>
                                        <div style="text-align: center;background-color: rgba(255, 0, 0, 0.63);border-radius: 5px;padding: 5px;">
                                            Etes vous conscient que vous utilisez Internet explorer (aka le pire navigateur au monde) ?
                                            <br>Le site risque de bugger avec ce truc ..
                                        </div>
                                        <?php
                                    }
                                    
                                    /*
                                    print($req != false);
                                    if($req != false){
                                    */
                      
                                    //}

                                    include_once("top_bar.php");
                        

                                    if ($id_session == "hacker_du_93"){
                                        ?>
                                        <div class="caseavisrecherche">
                                            <form action="" method="post" enctype="multipart/form-data">
                                                <input type="text" placeholder="Titre post" name="titre" class="champtitrepost"><input type="checkbox" id="important" name="importance" value="1"><label for="important" style="color: red">rouge</label><br>
                                                <textarea style="border: none;resize: none; font: 15px arial, sans-serif;margin-top: 5px;margin-bottom: 5px;" name="messageavis" rows=3 cols=100 placeholder=""></textarea><br />

                                            <?php
                                            if(isset($_POST) and isset($_POST["messageavis"]) and isset($_POST["titre"]) and $_POST["messageavis"] != "" and $_POST["titre"] != ""){
                                                //print("<pre>"); print_r($_POST); print("<pre>");
                                                //print($screen_dim);
                        
                                                $bdd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
                                                $req = $bdd->prepare('INSERT INTO avis_recherche(auteur, importance, message, date, titre) VALUES(:auteur, :importance, :message, NOW(), :titre)');
                                                $req->execute(array(
                                                    "auteur" => $_SESSION['pseudo'],
                                                    "importance" => isset($_POST['importance'])?1:0,
                                                    "message" => $_POST['messageavis'],
                                                    "titre" =>  $_POST['titre'],
                                                ));
                                                $req->closeCursor();
                                                print("<div class='success'>Message posté !</div><br/>");
                                                logs($user_session, "Ajout d'une annonce. Titre: ". $_POST["titre"] ." /// Message: ". $_POST["messageavis"]);
                                            } elseif (isset($_POST) and isset($_POST["messageavis"]) and isset($_POST["titre"])) {
                                                print("<div class='deleted'>Il manque le titre ou le message !</div><br/>");
                                                logs($user_session, "Ajout d'une annonce avec parmetres manquants. Titre: ". $_POST["titre"] ." /// Message: ". $_POST["messageavis"]);
                                            }
                                            ?>
                                                <input class="bouton" type="submit" value="Envoyer" />
                                            </form>
                                        </div>
                                        <?php
                                        
                                    }
                                    $req = $bdd->query("SELECT id, importance, message, titre FROM avis_recherche ORDER BY id DESC");



                                    
                                    
                                    while ($donnees = $req->fetch()){
                                        ?>
                                        
                                            <div class="caseavisrecherche">
                                                <span class="avisrecherche" <?php                                                     
                                                        if($donnees["importance"] == 1){print("style='color: red;'");}
                                                        print(">". htmlspecialchars($donnees["titre"]));
                                                ?> </span>
                                                <br/><?php print(nl2br(htmlspecialchars($donnees["message"]))); 
                                                
                                                if ($id_session == "hacker_du_93") { ?>
                                                    <form action="" method="post" enctype="multipart/form-data">
                                                        <input type="hidden" name="id" value=<?php print($donnees["id"]); ?> />
                                                        <input type="hidden" name="supprimer" value="supprimer" />
                                                        <input style="cursor: pointer; background-color: rgba(255, 0, 0, 0.6); border-color: #05050580; border-radius: 3px; border-width: 1px; border-style: solid; margin-top: 10px;" type="submit" value="Supprimer" />
                                                    </form>
                                                <?php } ?>
                                            </div>
                                        
                                        
                                    <?php
                                    }
                                    //$req->closeCursor();
                                    
                                ?>
                            </div> <!-- actualité -->
                    
                        
                            <div class="listeCases" style="margin: auto;overflow: hidden;">
                                <a class="cadreCase" target="_blank" href="https://app.parisdescartes.fr/cgi-bin/WebObjects/Resultat.woa">
                                    <!--<div class="case" style="background-image: url(mesnotes.jpg);">Voir ses notes</div>-->
                                    <img class="case" src="mesnotes-min.jpg" alt="mes notes">
                                </a>
                                <a class="cadreCase" href="#" onClick="proposerfiches()">
                                    <img class="case" src="upload-min.jpg" alt="Envoyer des fichiers">
                                </a>
                                <a class="cadreCase" target="_blank" href="https://app.parisdescartes.fr/ip-web/cas_authentConsultation.jsf">
                                    <img class="case" src="moncontrapeda-min.jpg" alt="mon contrat pédagogique">
                                </a>
                                <a class="cadreCase" target="_blank" href="index.php?matiere=prerentree">
                                    <img class="case" src="infoprerentree-min.jpg" alt="infos générales">
                                </a>
                                <a class="cadreCase" target="_blank" href="http://www.bu.parisdescartes.fr/">
                                    <img class="case" src="bu-min.jpg" alt="BU">
                                </a>
                                <a class="cadreCase" target="_blank" href="https://moodle.parisdescartes.fr/course/view.php?id=7058">
                                    <img class="case" src="moodle-min.jpg" alt="moodle">
                                </a>
                                <a class="cadreCase" target="_blank" href="http://partenaires.parisdescartes.fr/INFORMATIQUE/Office-365-gratuit-a-usage-prive-pour-les-etudiants">
                                    <img class="case" src="office-min.jpg" alt="office gratos">
                                </a>
                                <a class="cadreCase" target="_blank" href="http://ent-ng.parisdescartes.fr">
                                    <img class="case" src="ent-min.jpg" alt="ENT">
                                </a>
                                <a class="cadreCase" target="_blank" href="https://mediasd.parisdescartes.fr/#/browse?in=zone&zone=MATH%C3%89MATIQUES%20ET%20INFORMATIQUE">
                                    <img class="case" src="videosdescartes-min.jpg" alt="videos officielles de paris descartes">
                                </a>
                                <a class="cadreCase" target="_blank" href="http://www.mi.parisdescartes.fr/">
                                    <img class="case" src="sitemathinfo-min.jpg" alt="site math info">
                                </a>
                                <a class="cadreCase" target="_blank" href="https://discord.gg/5CEfGPn">
                                    <img class="case" src="discord2-min.jpg" alt="discord math info">
                                </a>
                                <a class="cadreCase" target="_blank" href="https://www.facebook.com/sosmathinfo/">
                                    <img class="case" src="facebooksosmi-min.jpg" alt="fb sos math info">
                                </a>
                                <a class="cadreCase" target="_blank" href="http://app.parisdescartes.fr/cgi-bin/WebObjects/AnnuaireSinequa.woa">
                                    <img class="case" src="annuaire-min.jpg" alt="annuaire">
                                </a>
								<a class="cadreCase" target="_blank" href="android/test.apk">
                                    <img class="case" src="appli_mobile-min.jpg" alt="application android">
                                </a>
                            </div> <!-- liste cases -->
                    
            

                            
                            

                            <div class="textedroite">
                                <table>
                                    <tr>
                                        <td valign="top">
                                            <h2 style="margin-right: 30px;margin-top: 0px;">
                                                Configurer une connexion automatique à la wifi DESCARTESPRO: <span style="font-weight: normal; color: gray;">(facile)</span>
                                            </h2>
                                                <ul style="margin-right: 30px;">
                                                    <li><a href="http://wifi.parisdescartes.fr/le-canal-descartes-pro-windows-8-8-1/">Windows</a></li>
                                                    <li><a href="http://wifi.parisdescartes.fr/le-canal-descartes-pro-osx-10-9-mavericks/">Mac</a></li>
                                                    <li><a href="http://wifi.parisdescartes.fr/le-canal-descartes-pro-linux/">Linux</a></li>
                                                    <li><a href="http://wifi.parisdescartes.fr/le-canal-descartes-pro-ipad/">iPad</a></li>
                                                    <li><a href="http://wifi.parisdescartes.fr/le-canal-descartes-pro-iphone/">iPhone</a></li>
                                                    <li><a href="http://wifi.parisdescartes.fr/le-canal-descartes-pro-android/">Android</a></li>
                                                </ul>
                                            
                                                                                
                                            <br/>
                                            <h2>
                                                Se connecter à sa session à distance:
                                            </h2>
                                            <ul>
                                                <li><strong>Mac / Linux:</strong> Aller sur  le terminal et tapper: <strong>ssh aa00000@saphyr.ens.math-info.univ-paris5.fr</strong><br> (remplacer aa00000 par son identifiant)</li>
                                                <li><strong>Windows:</strong> Télécharger <a href="https://the.earth.li/~sgtatham/putty/latest/w32/putty.exe"><strong style="color: blue;">Putty</strong></a>, l'ouvrir, tapper <strong>aa00000@saphyr.ens.math-info.univ-paris5.fr</strong><br> (remplacer aa00000 par son identifiant) dans le champ "Host Name" et cliquer sur "Open" en bas.</li>
                                            </ul>
                                            <br>
                                            <p style="margin-right: 30px;">
                                                Si vous avez des idées, des critiques, ou des conseils, vous pouvez les envoyer via ce formulaire (n’hésitez surtout pas, meme si c’est mal écrit ou que vous pensez que ça a déjà été dit 20 fois):
                                            </p>
                                            <p>
                                                <input class="bouton" type="submit" value="Feedbacks" onClick="feedbacks()"/>
                                            </p>
                                            <p style="margin-right: 30px;">
                                                Si vous voulez voir une image de pied cliquez ici:
                                            </p>
                                            <form action="inter_ouverture.php" method="get" >
                                                <p>
                                                    <input type="hidden" name="pied" valude="pied" />
                                                    <input class="bouton" type="submit" value="Voir une image de pied" />
                                                </p>
                                            </form>
                                            <br/>
                                        </td>
                                        <td valign="top">
                                            <img style="margin: auto;display: block;margin-top: 50px;" src="plan.png" alt="[le plan de l'univ n'a pas pu etre affiché]">
                                        </td>
                                    </tr>
                                </table>
                                
                                <!-- A améliorer plus tard
                                <br><br>
                                <img style="margin: auto;display: block;margin-top: 50px;" src="cookies2.png" width="847">
                                <p style="font-size: smaller;">
                                    <strong style="color: white;">Mais pourquoi est ce que tu veux savoir qui est qui, tu veux nous pister ? Revendre nos infos à google ? à facebook ?</strong>
                                    <br>>> Déjà calme toi, moi j'ai rien demandé, c'est le serveur qui place automatiquement des cookies chez tous les visiteur, et j'ai la flemme d'aller fouiller dans les options du serveur. En plus je crois que c'est ce qui me permet d'avoir des stats sur la fréquentation du site, donc c'est plutot pratique, et si vous etes parano bah c'est pas d'chance
                                    <br><strong style="color: white;">Mais alors si c'est pas pour revendre nos infos à des capitalistes sauvages macronistes islamiques et que c'est pas dangereux, pourquoi est ce que tu met cet avertissement ??</strong>
                                    <br>>> Car la loi l'impose depuis 2015.
                                    <br><strong style="color: white;">Ok mais alors si y a rien de scandaleux dans l'histoire, contre quoi est ce que je peux me révolter ?</strong>
                                    <br>>> Le manque de fichiers dans le site, envoyez vos fichiers, envoyez !
                                </p>
                                -->
                                
                            </div> <!-- texte droite -->
                              
                            



                            <?php 
                                                    ////////////////////////////////////////////////////////
                                                    //         LA PARTIE PRINCIPALE AVEC LES PDFs         //
                                                    ////////////////////////////////////////////////////////




                        } else { 
                            $nom_matiere = "inconnu";    
                        ?>
                        <!--</div>--> <!-- page droite -->
                                                
                        <div> 
                            <?php /*
                            <div class="caracteristiques arrondi <?php if(get_browsername() == "Safari"){ print('carafondmac'); } else print('carafond')  ?>">  <!-- ****  Partie pour faire une recherche personnalisée  **** -->
                                <form action="" method="get" enctype="multipart/form-data" style="padding-left: 70px;" >
                                    <p class="options">
                                        Année: 
                                    <select name="annee">
                                        <?php
                                            for($i = 2000; $i<=((int) date("Y")); $i++){
                                                print('<option value="'. $i .'">'. $i .'</option>');
                                            }
                                        ?>
                                    </select>
                                    &nbsp;&nbsp;&nbsp;&nbsp;

                                    Type: 
                                    <select name="type">
                                        <option value="indifférent">indifférent</option>
                                        <option value="annale">annale</option>
                                        <option value="cours">cours</option>
                                        <option value="TD">TD</option>
                                        <option value="TP">TP</option>
                                        <option value="fiche">fiche</option>
                                        <option value="tuto">tuto</option>
                                        <option value="exempleTravail">exemple de travail</option>
                                        <option value="autre">autre</option>
                                    </select>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                            
                                    Corrigé: 
                                    <select name="corrige">
                                        <option value="indifférent">indifférent</option>
                                        <option value="oui">oui</option>
                                        <option value="non">non</option>
                                    </select>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <!--<input type="checkbox" name="corrige" id="corrige" /> <label for="corrige"></label></p>-->


                                    <?php if(isset($_GET) and array_key_exists("niveau", $_GET)){ // <-- Pour garder le niveau en mémoire si il y en a déjà un ?>
                                        <input type="hidden" name="niveau" value=<?php print(htmlentities($_GET["niveau"])) ?> />
                                        <?php
                                    }?>
                                    <?php if(isset($_GET) and array_key_exists("matiere", $_GET)){ // <-- Pour garder la matière en mémoire si il y en a déjà une ?>
                                        <input type="hidden" name="matiere" value=<?php print(htmlentities($_GET["matiere"])) ?> />
                                        <?php
                                    }?>

                                    
                                    <input type="submit" value="Chercher" />

                                </form>

                            </div>
                            */?>

                            

                            <?php
                            if($id_session == "hacker_du_93"){                                       ///// SI L'USER EST UN ADMIN /////
                                if(isset($_POST["nom_matiere"]) and isset($_POST["intromatiere"]) and isset($_POST["textematiere"])){ // Si il y a eu une requete de modification
                                    //print("<pre>"); print_r($_POST); print("<pre>");
                                    //print($screen_dim);
            
                                    $bdd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);

                                    //print("<pre>"); print_r($req->fetch()); print("<pre>");
                                    if(isset($_POST["affichernotesmatieres"])){
                                        //$req = $bdd->prepare('INSERT INTO notes_matieres(affiche, nom_mat, intro_mat, texte, derniere_maj) VALUES(1, :nom_mat, :intro_mat, :texte, NOW())');
                                        $bdd->exec('UPDATE matiere 
                                                    SET affiche_notes = 1, nom_complet = "'.htmlspecialchars($_POST["nom_matiere"]).'", intro = "'.htmlspecialchars($_POST["intromatiere"]).'", texte = "'.htmlspecialchars($_POST["textematiere"]).'", derniere_maj = NOW() 
                                                    WHERE code = "'. htmlentities($_GET["matiere"], ENT_QUOTES) .'"');
                                    } else {
                                        //$req = $bdd->prepare('INSERT INTO notes_matieres(affiche, nom_mat, intro_mat, texte, derniere_maj) VALUES(1, :nom_mat, :intro_mat, :texte, NOW())');
                                        $bdd->exec('UPDATE matiere 
                                                    SET affiche_notes = 0, nom_complet = "'.htmlspecialchars($_POST["nom_matiere"]).'", intro = "'.htmlspecialchars($_POST["intromatiere"]).'", texte = "'.htmlspecialchars($_POST["textematiere"]).'", derniere_maj = NOW() 
                                                    WHERE code = "'. htmlentities($_GET["matiere"], ENT_QUOTES) .'"');
                                    }
                                    ?><div class='success'>Détails modifiés !</div><br/><?php
                                }
                                ?>
                                    
                                        <?php 
                                            $bdd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
                                            $req = $bdd->query('SELECT affiche_notes, nom_complet, nom, intro, texte, derniere_maj
                                                                FROM matiere 
                                                                WHERE code = "'. (htmlentities($_GET["matiere"], ENT_QUOTES)) .'"
                                                                '); // Envoi de la requete à la base de données
                                            $donnees = $req->fetch();
                                            $nom_matiere = $donnees["nom_complet"];
                                        ?>


                                        <div class="NotesMatieres" >
                                            <form action="" method="post" enctype="multipart/form-data">
                                                <input class="titreAdminNotesMatieres" type="text" placeholder="<?php print($donnees["nom"]); ?>" value="<?php print($donnees["nom_complet"]); ?>" name="nom_matiere">
                                                 Afficher ? <input type="checkbox" name="affichernotesmatieres" <?php if($donnees["affiche_notes"] == 1) print("checked") ?>/><br>
                                                <textarea class="champtexteAdminNotesMatieres" placeholder="Introduction de la matiere" name="intromatiere" rows=10 cols=100 placeholder=""><?php print($donnees["intro"]); ?></textarea><br>
                                                <textarea class="champtexteAdminNotesMatieres" placeholder="Infos sur la matiere" name="textematiere" rows=5 cols=100 placeholder=""><?php print($donnees["texte"]); ?></textarea><br>
                                                <br><input class="bouton" type="submit" value="Valider" style="border-radius: 3px;line-height: 15px;"/> 
                                                <i>Derniere maj: <?php print($donnees["derniere_maj"]); ?></i>
                                                
                                            </form>
                                        </div>


                                    
                                <?php
                            } else {                              ///// SI L'USER N'EST PAS UN ADMIN /////
                            
                                try {
                                    $bdd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
                                    $req = $bdd->query('SELECT nom_complet, intro, texte, derniere_maj, affiche_notes
                                                        FROM matiere 
                                                        WHERE code = "'. htmlentities($_GET["matiere"], ENT_QUOTES) .'"
                                                        '); // Envoi de la requete à la base de données
                                    $donnees = $req->fetch();
                                    if($donnees["affiche_notes"] != 1){
                                        throw new Exception('Rien à afficher');
                                    }
                                    $nom_matiere = $donnees["nom_complet"];
                                    ?>
                                    <div class="NotesMatieres">
                                        
                                        <h2 style="margin: 0;font-size: 45px;font-weight: normal;"><?php print($donnees["nom_complet"]); ?></h2>
                                        
                                        <div class="NotesMatieresIntroCadreMinimise" id="boutonmaximise" onClick="maximise();">
                                            <?php
                                                $texte = $donnees["intro"];
                                                $texte = preg_replace('#(?:https?|ftp)://(?:[\w~%?=,:;+\#@./-]|&amp;)+#', '<a target="_blank" class="lienactif" href="$0">$0</a>', $texte);
                                                //$texte = preg_replace('#www.(?:[\w%?=,:;+\#@./-]|&amp;)+#', '<a target="_blank" class="lienactif" href="http://$0">$0</a>', $texte);
                                            ?>
                                            <p class="NotesMatieresIntroMinimise" id="intromatiere"><?php print(nl2br($texte)); ?></p>
                                            <!--<div class="NotesMatieresBoutonplus" id="boutonmaximise" onClick="maximise();"><div style="margin: auto;">+</div></div>-->
                                            
                                            
                                        </div>
                                        <?php
                                            $texte = $donnees["texte"];
                                            $texte = preg_replace('#(?:https?|ftp)://(?:[\w~%?=,:;+\#@./-]|&amp;)+#', '<a target="_blank" class="lienactif" href="$0">$0</a>', $texte);
                                            //$texte = preg_replace('#www.(?:[\w%?=,:;+\#@./-]|&amp;)+#', '<a target="_blank" class="lienactif" href="http://$0">$0</a>', $texte);
                                            $texte=preg_replace('/(\S+@\S+\.\S+)/','<a class="mail" href="mailto:$0">$0</a>',$texte)
                                        ?>
                                        <p><?php print(nl2br($texte)); ?></p>
                                        <p class="NotesMatieresDateModification">Dernière maj: <b><?php print($donnees["derniere_maj"]); ?></b></p>
                                        

                                    </div>
                                    <?php
                                } catch (Exception $e) {
                                    print("");
                                }
                          
                            } ?>

                            
                            <!--
                            <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
                            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

                            <script>
                                $( function() {
                                    $( "#slider-range" ).slider({
                                        range: true,
                                        min: 2000,
                                        max: 2018,
                                        values: [ 2000, 2018 ],
                                        slide: function( event, ui ) {
                                            $( ".droitee" ).text(" " + ui.values[ 1 ] + " ");
                                            $( ".gauchee" ).text(" " + ui.values[ 0 ] + " ");
                                            
                                        }
                                    });
                                    //$( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) + " - $" + $( "#slider-range" ).slider( "values", 1 ) );
                                } );
                            </script>
                            

                            <form>
                                <table style="width: 50%;padding-right: 60px;margin: auto;text-align: center;">
                                    <tr>
                                        
                                        <td>
                                            <div id="slider-range" style="border-radius: 5px;margin: 10px;margin-right: 50px;border: 1px solid #a6a6a6;height: 15px !important;box-shadow: 0px 1px 10px #0003;">
                                                <div class="ui-slider-range ui-corner-all ui-widget-header arriereSlider" style="width: 100%;"></div>
                                                <div style="margin: auto;display: block;color: #fffc;z-index: 2;position: relative;text-align: center;font-size: smaller;right: -3%;">Choisissez une date</div>

                                                <span tabindex="0" class="gauchee slider ui-slider-handle ui-corner-all ui-state-default slider" id="slidergauche"> 2000 </span>
                                                <span tabindex="0" class="droitee slider ui-slider-handle ui-corner-all ui-state-default" id="sliderdroite"> 2018 </span>
                                            </div>
                                        </td>
                                        <td style="width: 90px;">
                                            <input class="bouton" type="submit" value="Valider"/>
                                        </td>
                                    </tr>
                                </table>
                            
                            </form>
                            -->

                            

                            <?php
                            function filtreType($url, $ecrit, $bdd){
                                $req = $bdd->prepare("SELECT count(id) as count FROM fichiers WHERE type = :type and matiere = :matiere and valide = 1 and supprime = 0");
                                $req->execute(array("matiere" => $_GET["matiere"], "type" => $url));
                                $donnees = $req->fetch();
                                if($donnees["count"] > 0) {
                                    ?>
                                    <a id="type" style="float:left; margin: 8px; margin-right: 0;" href="index.php?matiere=<?php print($_GET["matiere"]); ?>&type=<?php print($url);
                                                                                 if(isset($_GET["annee"])) print("&annee=". $_GET["annee"]); 
                                                                                 if(isset($_GET["corrige"])) print("&corrige=". $_GET["corrige"]); 
                                                                                 if(isset($_GET["niveau"])) print("&niveau=". $_GET["niveau"]); 
                                                                                 if(isset($_GET["onglet"])) print("&onglet=". $_GET["onglet"]); ?>">
                                        <div class="filtreType"><?php print($ecrit ." <span class='filtreTypeAmount'>". $donnees["count"] ."</span>"); ?></div>
                                    </a>
                                    <?php
                                }
                                //$req = $bdd->query('SELECT count(id) as count FROM fichiers WHERE matiere = "'. htmlentities($_GET["matiere"], ENT_QUOTES) .'" and valide = 1 and supprime = 0'); $donnees = $req->fetch();
                               
                            }
                            

                            ?>

                            <div style="overflow: auto;">
                                <?php
                                    //$a = 1;

                                    $req = $bdd->prepare("SELECT count(id) as count FROM fichiers WHERE matiere = :matiere and valide = 1 and supprime = 0");
                                    $req->execute(array("matiere" => $_GET["matiere"]));
                                    $donnees = $req->fetch();
                                    if($donnees["count"] > 0) {
                                        ?>
                                        <a id="type" style="float:left; margin: 8px; margin-right: 0;" href="index.php?matiere=<?php print($_GET["matiere"]); ?>&type=<?php print("indifférent");
                                                                                    if(isset($_GET["annee"])) print("&annee=". $_GET["annee"]); 
                                                                                    if(isset($_GET["corrige"])) print("&corrige=". $_GET["corrige"]); 
                                                                                    if(isset($_GET["niveau"])) print("&niveau=". $_GET["niveau"]); 
                                                                                    if(isset($_GET["onglet"])) print("&onglet=". $_GET["onglet"]); ?>">
                                            <div class="filtreType"><?php print("TOUT <span class='filtreTypeAmount'>". $donnees["count"] ."</span>"); ?></div>
                                        </a>
                                        <?php
                                    }

                                    //filtreType("indifférent", "TOUT", $bdd);
                                    filtreType("annale", "Annales", $bdd);
                                    filtreType("cours", "Cours", $bdd);
                                    filtreType("TD", "TD", $bdd);
                                    filtreType("TP", "TP", $bdd);
                                    filtreType("fiche", "Fiches", $bdd);
                                    filtreType("tuto", "Tutos", $bdd);
                                    filtreType("exempleTravail", "Exemples de travail", $bdd);
                                    filtreType("autre", "Autres", $bdd);

                                    if($id_session == "hacker_du_93" || $id_session == "user"){
                                        $req = $bdd->prepare("SELECT count(id) as count FROM fichiers WHERE matiere = :matiere and valide = 0 and supprime = 0");
                                        $req->execute(array("matiere" => $_GET["matiere"]));
                                        $donnees = $req->fetch();
                                        if($donnees["count"] > 0) {
                                            ?>
                                            <a id="type" style="float:left; margin: 8px; margin-right: 0;" href="index.php?matiere=<?php print($_GET["matiere"]); ?>&valide=0<?php
                                                                                        if(isset($_GET["annee"])) print("&annee=". $_GET["annee"]); 
                                                                                        if(isset($_GET["corrige"])) print("&corrige=". $_GET["corrige"]); 
                                                                                        if(isset($_GET["niveau"])) print("&niveau=". $_GET["niveau"]); 
                                                                                        if(isset($_GET["onglet"])) print("&onglet=". $_GET["onglet"]); ?>">                                                
                                                <div class="filtreType" style="color: #ea7900;" ><?php print("En attente <span class='filtreTypeAmount'>". $donnees["count"]); ?></div>
                                            </a>
                                            <?php
                                        }
                                    }

                                    /*
                                    $req = $bdd->query('SELECT count(id) as count FROM fichiers WHERE matiere = "'. htmlentities($_GET["matiere"], ENT_QUOTES) .'" and valide = 1 and supprime = 0'); $donnees = $req->fetch();
                                    if($donnees["count"] > 0) filtreType("indifférent", "TOUT", $donnees["count"]);
                                    $req = $bdd->query('SELECT count(id) as count FROM fichiers WHERE type = "annale" and matiere = "'. htmlentities($_GET["matiere"], ENT_QUOTES) .'" and valide = 1 and supprime = 0'); $donnees = $req->fetch();
                                    if($donnees["count"] > 0) filtreType("annale", "Annales", $donnees["count"]);
                                    $req = $bdd->query('SELECT count(id) as count FROM fichiers WHERE type = "cours" and matiere = "'. htmlentities($_GET["matiere"], ENT_QUOTES) .'" and valide = 1 and supprime = 0'); $donnees = $req->fetch();
                                    if($donnees["count"] > 0) filtreType("cours", "Cours", $donnees["count"]);
                                    $req = $bdd->query('SELECT count(id) as count FROM fichiers WHERE type = "TD" and matiere = "'. htmlentities($_GET["matiere"], ENT_QUOTES) .'" and valide = 1 and supprime = 0'); $donnees = $req->fetch();
                                    if($donnees["count"] > 0) filtreType("TD", "TD", $donnees["count"]);
                                    $req = $bdd->query('SELECT count(id) as count FROM fichiers WHERE type = "TP" and matiere = "'. htmlentities($_GET["matiere"], ENT_QUOTES) .'" and valide = 1 and supprime = 0'); $donnees = $req->fetch();
                                    if($donnees["count"] > 0) filtreType("TP", "TP", $donnees["count"]);
                                    $req = $bdd->query('SELECT count(id) as count FROM fichiers WHERE type = "fiche" and matiere = "'. htmlentities($_GET["matiere"], ENT_QUOTES) .'" and valide = 1 and supprime = 0'); $donnees = $req->fetch();
                                    if($donnees["count"] > 0) filtreType("fiche", "Fiches", $donnees["count"]);
                                    $req = $bdd->query('SELECT count(id) as count FROM fichiers WHERE type = "tuto" and matiere = "'. htmlentities($_GET["matiere"], ENT_QUOTES) .'" and valide = 1 and supprime = 0'); $donnees = $req->fetch();
                                    if($donnees["count"] > 0) filtreType("tuto", "Tutos", $donnees["count"]);
                                    $req = $bdd->query('SELECT count(id) as count FROM fichiers WHERE type = "exempleTravail" and matiere = "'. htmlentities($_GET["matiere"], ENT_QUOTES) .'" and valide = 1 and supprime = 0'); $donnees = $req->fetch();
                                    if($donnees["count"] > 0) filtreType("exempleTravail", "Exemples de travail", $donnees["count"]);
                                    $req = $bdd->query('SELECT count(id) as count FROM fichiers WHERE type = "autre" and matiere = "'. htmlentities($_GET["matiere"], ENT_QUOTES) .'" and valide = 1 and supprime = 0'); $donnees = $req->fetch();
                                    if($donnees["count"] > 0) filtreType("autre", "Autres", $donnees["count"]);
                                    $req = $bdd->query('SELECT count(id) as count FROM fichiers WHERE valide = 0 and supprime = 0 and matiere = "'. htmlentities($_GET["matiere"], ENT_QUOTES) .'" and valide = 1 and supprime = 0'); $donnees = $req->fetch();
                                    if($donnees["count"] > 0) filtreType("en_attente", "En attente", $donnees["count"]);
                                    */
                                ?>
                            </div>



                            <div style="padding-bottom: 25px;width: 100%;"> <!--class="listeCases"-->




                                <?php



                                                    ////////////////////////////////////////////////////
                                                    //         CODE DE TRAITEMENT DES DONNÉES         //
                                                    ////////////////////////////////////////////////////



                                    /* // Fonction pour faire un appel personnalisé à la BDD

                                    function appelBDD($bdd, $niveau){ // Fonction pour faire la requete à la base de données
                                        $req = $bdd->prepare('SELECT nom, nomfichier FROM fichiers WHERE niveau = :niveau');
                                        $req->execute(array(
                                            'niveau' => $niveau,
                                        ));
                                        return $req;
                                    }
                                    */


                                    // Listage de toutes les demandes possibles pour éviter faille par injection SQL
                                    $typePossible = array("indifférent", "annale", "cours", "TD", "TP", "fiche", "tuto", "exempleTravail", "autre", "en_attente");
                                    //$anneePossible = array("indifférent", "2000", "2001", "2002", "2003", "2004", "2005", "2006", "2007", "2008", "2009", "2010", "2011", "2012", "2013", "2014", "2015", "2016", "2017", "2018", "2019", "2020");
                                    $corrigePossible = array("indifférent", "oui", "non");
                                    $niveauPossible = array("indifférent", "L1_math_info", "L2_math_info", "L3_math_info");
                                    //$matierePossible = array("indifférent", "");  Trop chaud car il faudrait lister toutes les matieres possibles
                                    // --> Donc peut etre à voir pour plus tard

                                    $page = 1;
                                    $valide = 1;

                                    $finrequete = "";
                                    if(isset($_GET)){   /////----- Si il y a un GET dans la requete, on constitue la fin de la requete SQL avec toutes les données du GET -----/////
                                        
                                        $finrequete = "";
                                        $limite = " LIMIT 0,".$ELEMENTSPARPAGE;

                                        // On constitue la fin de la requete (avec ce que demande l'user) en vérifiant que tout est correct
                                        if(array_key_exists("type", $_GET) and $_GET["type"] != "indifférent" and in_array($_GET["type"], $typePossible)) $finrequete = ($finrequete . " and type = '" . htmlentities($_GET["type"]) . "'");
                                        if(array_key_exists("annee", $_GET) and $_GET["annee"] != "indifférent" and is_numeric($_GET["annee"])) $finrequete = ($finrequete . " and annee = '" . htmlentities($_GET["annee"]) . "'");
                                        if(array_key_exists("corrige", $_GET) and $_GET["corrige"] != "indifférent" and in_array($_GET["corrige"], $corrigePossible)){
                                            if ($_GET["corrige"] == "oui") $finrequete = ($finrequete . " and corrige = 1");
                                            if ($_GET["corrige"] == "non") $finrequete = ($finrequete . " and corrige = 0");
                                        }
                                        if(array_key_exists("matiere", $_GET) and $_GET["matiere"] != "indifférent") $finrequete = ($finrequete . " and matiere = '" . htmlentities($_GET["matiere"], ENT_QUOTES) . "'");
                                        if(array_key_exists("niveau", $_GET) and $_GET["niveau"] != "indifférent" and in_array($_GET["niveau"], $niveauPossible)) $finrequete = ($finrequete . " and niveau = '" . htmlentities($_GET["niveau"]) . "'");
                                        if(array_key_exists("page", $_GET) and is_numeric($_GET["page"])) $limite = (" LIMIT " . ($_GET["page"]-1)*$ELEMENTSPARPAGE . ", " . $_GET["page"]*$ELEMENTSPARPAGE);
                                        if(array_key_exists("valide", $_GET) && $_GET["valide"] == 0 && ($id_session == "hacker_du_93" || $id_session == "user")) $valide = 0;
                                        //print($page, )
                                        //print(" LIMIT " . ($page-1)*$ELEMENTSPARPAGE . ", " . $page*$ELEMENTSPARPAGE);  // Pour le debuggage
                                    }
                                    //print('SELECT nom, nom_fichier FROM fichiers WHERE valide = 1 ' . $finrequete . $limite); // Pourle debuggage

                                    //// ---- incrémentation du nombre de vues pour la matière ---- ////
                                    $req = $bdd->prepare("UPDATE matiere SET vues_site = vues_appli+1 WHERE code = :matiere");
                                    $req->execute(array("matiere" => $_GET["matiere"]));

                                    //// ---- recherche des fichiers disponibles dans la matière ---- ////
                                    $req = $bdd->query('SELECT id, nom, nom_fichier, nb_visionnage, details_active, valide, externe FROM fichiers WHERE valide = '. $valide .' and supprime = 0 ' . $finrequete . " ORDER BY nom" . $limite); // Envoi de la requete à la base de données




                                    if($id_session == "hacker_du_93") print('<form action="" method="post" >'); // Si l'user est un admin, on ouvre le formulaire pour invalider des fichiers


                                    //print("<pre>"); print_r($req->fetch()); print("</pre>");
                                    while ($donnees = $req->fetch()){                                //// AFFICHAGE DE CHAQUE CASES ////
                                        //print("Entrée dans la boucle while");
                                        ?>
                                        <div class="caseFicCadre">
                                            <div class="caseFic" <?php  if($donnees["details_active"]) print("style='background-color: #d6feff;'"); ?>>
                                                <div class="hautBlanc">
                                                    <?php if($id_session == "hacker_du_93"){ // Si l'user est un admin, on place chaque case pour cocher les fichiers à invalider
                                                        //$id_fichier = $donnees["id"];
                                                        //$nom_du_fichier_xpl = explode(".", $nom_du_fichier_act);
                                                        //$nom_du_fichier_mod = current($nom_du_fichier_xpl) .'¤'. end($nom_du_fichier_xpl) .'¤'. $donnees["nom"];
                                                        print('<input type="checkbox" name="'. $donnees["id"] .'" style="position: absolute;margin: 8px;box-shadow: 0px 0px 5px rgb(0, 0, 0);"/>');
                                                        print('<div class="nb_vues">'. $donnees["nb_visionnage"] . ' vues</div>');
                                                        } ?>
                                                    <a class="doc" title="Clique !!!" target="_blank" style='background-image: url(<?php 
                                                        error_reporting(0);
                                                        $nom_image = $donnees["externe"]?($donnees["id"]):(current(explode('.', htmlspecialchars($donnees["nom_fichier"]))));
                                                        $fic_suppose = "uploads/". $nom_image . ".jpg"; 
                                                        $extension = end(explode(".", $donnees["nom_fichier"]));
                                                        error_reporting(E_ALL);
                                                        $miniature = "no_template.jpg";
                                                        if(file_exists($fic_suppose)){
                                                            $miniature = $fic_suppose;
                                                        } elseif (!strcmp($extension, "java")){
                                                            $miniature = "java-min.jpg";
                                                        } elseif (!strcmp($extension, "sql")){
                                                            $miniature = "sql-min.jpg";
                                                        } elseif (!strcmp($extension, "c")){
                                                            $miniature = "c-min.jpg";
                                                        } elseif (!strcmp($extension, "html")){
                                                            $miniature = "html-min.jpg";
                                                        } elseif (!strcmp($extension, "py")){
                                                            $miniature = "python-min.jpg";
                                                        } elseif (!strcmp($extension, "php")){
                                                            $miniature = "php-min.jpg";
                                                        } elseif (!strcmp($extension, "zip")){
                                                            $miniature = "zip-min.jpg";
                                                        } elseif (!strcmp($extension, "gz")){
                                                            $miniature = "targz-min.jpg";
                                                        } elseif (!strcmp($extension, "rar")){
                                                            $miniature = "rar-min.jpg";
                                                        } elseif (!strcmp($extension, "iso")){
                                                            $miniature = "iso-min.jpg";
                                                        } elseif (!strcmp($extension, "exe")){
                                                            $miniature = "exe-min.jpg";
                                                        } elseif (!strcmp($extension, "dmg")){
                                                            $miniature = "dmg-min.jpg";
                                                        } elseif (!strcmp($extension, "app")){
                                                            $miniature = "app-min.jpg";
                                                        } elseif (!strcmp($extension, "7z")){
                                                            $miniature = "7z-min.jpg";
                                                        } elseif (!strcmp($extension, "txt")){
                                                            $miniature = "txt-min.jpg";
                                                        } elseif (!strcmp($extension, "mp4")){
                                                            $miniature = "video.gif";
                                                        } elseif (!strcmp($extension, "mov")){
                                                            $miniature = "video.gif";
                                                        }
                                                        print($miniature);
                                                        ?>);' href='inter_ouverture.php?fichier=<?php print($donnees["externe"]?($donnees["id"] ."&externe=true"):($donnees["nom_fichier"])); ?>' >
                                                    </a>
                                                    
                                                </div> <?php /* Partie inférieure */ 
                                                $url_details = $donnees["externe"]?($donnees["id"] ."&externe=true"):($donnees["nom_fichier"]);
                                                ?>
                                                <div class="basRouge" <?php if(!$donnees["valide"]) print("style='color: gray;'"); ?> onClick="ouvrirDetails(<?php print($donnees["id"] .", '". $donnees["nom"] ."', '". htmlspecialchars(htmlspecialchars($nom_matiere, ENT_QUOTES), ENT_QUOTES) ."', '". $miniature ."', 'inter_ouverture.php?fichier=" . $url_details ."'"); ?>)">
                                                    <p><?php print(htmlspecialchars($donnees["valide"]?$donnees["nom"]:("[ ". $donnees["id"] ." ]"))); ?></p>
                                                </div>
                                            </div> <?php /* caseFic */ ?>
                                        </div> <?php /* Cadre caseFic */ ?>
                                    <?php  
                                    }
                                    // Si l'user est un admin, on place le bouton pour confirmer l'invalidation et on ferme le champ de formulaire
                                    if($id_session == "hacker_du_93") print('
                                    <input type="hidden" name="invaliderunfic" value="invalider" />
                                    <input class="invalider" type="submit" value="Invalider" />
                                    </form>
                                    ');
                                    $req->closeCursor();
                                ?>

                            </div> <?php /* Liste cases */ ?>

                            <div style="width: 100%; height: 1px;float: left;"></div>

                            <div style="float: left;"> <!-- Commentaires -->
                                <?php
                                    $tailleMargeCommentaire = 5;
                                    $decalageBoutpnValider = 448;
                                    $paddinglefttextecomm = 26;
                                    if($navigateur == "Firefox"){
                                        $tailleMargeCommentaire = 5;
                                        $decalageBoutpnValider = 468;
                                        $paddinglefttextecomm = 28;
                                    } elseif($navigateur == "Chrome") {
                                        $tailleMargeCommentaire = 5;
                                        $decalageBoutpnValider = 448;
                                        $paddinglefttextecomm = 26;
                                    } elseif($navigateur == "Safari") {
                                        $tailleMargeCommentaire = 3;
                                        $decalageBoutpnValider = 448;
                                        $paddinglefttextecomm = 28;
                                    }
                                    if($id_session == "hacker_du_93" || $id_session == "user"){
                                        ?>
                                            <div class="commentaire" style="box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.57);">
                                                <img class="avatar" src="uploads/<?php print($urlavatar); ?>" alt="ziva ça bug">
                                                <span class="pseudo" <?php if($id_session == "hacker_du_93") print("style='color: red;'") ?>> <?php print($_SESSION['pseudo']); ?></span>
                                                <p style="margin: 2px;"></p>
                                                    <form action="" method="post" enctype="multipart/form-data" style="display: inline;">
                                                        <textarea style="border: none;resize: none; font-family: arial, sans-serif; font-size: 13px; margin-top: 5px;margin-bottom: 5px;" name="commentaire" rows=3 cols=57 placeholder=""></textarea>
                                                        <input class="boutonEnvoyerCommentaire bouton" type="submit" value="Envoyer" style="left: <?php print($decalageBoutpnValider); ?>px;"/>
                                                    </form>
                                                
                                            </div>
                                        <?php
                                        /* CODE POUR AJOUTER UN COMMENTAIRE */
                                        if(isset($_POST["commentaire"])){
                                            $req = $bdd->prepare('INSERT INTO commentaire(matiere, 
                                                                                            auteur, 
                                                                                            heure, 
                                                                                            IP, 
                                                                                            navigateur, 
                                                                                            message_original,
                                                                                            message_modere) 
                                                                    VALUES(:matiere, 
                                                                            :auteur,
                                                                            NOW(),
                                                                            :IP,
                                                                            :navigateur,
                                                                            :message_original,
                                                                            :message_modere)');
                                            $req->execute(array(
                                                'matiere' => $_GET["matiere"],
                                                'auteur' => $_SESSION['pseudo'],
                                                'IP' => htmlentities($_SERVER["REMOTE_ADDR"], ENT_QUOTES),
                                                'navigateur' => $navigateur,
                                                'message_original' => $_POST["commentaire"],
                                                'message_modere' => $_POST["commentaire"]
                                            ));
                                        }
                                        /* CODE POUR VIRER UN COMMENTAIRE */
                                        if(isset($_POST["supprimerCommentaire"])){
                                            $req = $bdd->prepare('SELECT auteur FROM commentaire WHERE id = ? and supprime = 0'); // Envoi de la requete à la base de données
                                            $req->execute(array($_POST["supprimerCommentaire"]));
                                            $auteur = $req->fetch();
                                            if($id_session == "hacker_du_93" || $_SESSION['pseudo'] == $auteur["auteur"]){
                                                $req = $bdd->prepare('UPDATE commentaire SET supprime = 1 WHERE id = :id');
                                                $req->execute(array(
                                                    'id' => $_POST["supprimerCommentaire"]
                                                ));
                                                logs($_SESSION["pseudo"], "Suppression d'un commentaire. id: ". $_POST["supprimerCommentaire"]);
                                            } elseif(isset($_SESSION["pseudo"])) {
                                                logs($_SESSION["pseudo"], "Tentative non autorisée de suppression d'un commentaire. id: ". $_POST["supprimerCommentaire"]);
                                            } else {
                                                logs("inconnu", "Tentative non autorisée de suppression d'un commentaire. id: ". $_POST["supprimerCommentaire"]);
                                            }
                                        }
                                        /* CODE POUR MOFIFIER UN COMMENTAIRE */
                                        if(isset($_POST["modifierCommentaire"]) && isset($_POST["texte"])){
                                            $req = $bdd->prepare('SELECT auteur FROM commentaire WHERE id = ? and supprime = 0'); // Envoi de la requete à la base de données
                                            $req->execute(array($_POST["modifierCommentaire"]));
                                            $auteur = $req->fetch();
                                            if($id_session == "hacker_du_93" || $_SESSION['pseudo'] == $auteur["auteur"]){
                                                //print("<p>");
                                                //print(nl2br($_POST["texte"]));
                                                //print("-------");
                                                $texte = preg_replace("/^([\s])+/", "$1", ($_POST["texte"]));
                                                //$texte = ltrim($_POST["texte"], " \t\r\n ");
                                                //$texte = preg_replace("#[ ]*<br />[ ]*(.*)#iu", "$1", nl2br($_POST["texte"]));
                                                //$texte = preg_replace("#^[ \s\r\t\n]*(?:[ \s\r\t\n]*<br>|[ \s\r\t\n]*<br />|[ \s\r\t\n]*<br/>)(.+)#iusU", "$1", nl2br($_POST["texte"]));
                                                //$texte = preg_replace("#^[ \s]*<br />(.+)#iuU", "$1", $texte);
                                                //print($texte);
                                                //print("</p>");
                                                $texte = preg_replace("#<div>(.+)</div>#iuU", "<br>$1", ($texte));
                                                //print("<p>". $texte ."</p> 541651651561");
                                                $req = $bdd->prepare('UPDATE commentaire SET message_modere = :message_modere WHERE id = :id');
                                                $req->execute(array(
                                                    'id' => $_POST["modifierCommentaire"],
                                                    'message_modere' => $texte
                                                ));
                                                /*
                                                print("Version nl2br reçue<br> <div style='background-color: black'>");
                                                print(nl2br($_POST["texte"]));
                                                print("</div><br>Version avant d'etre envoyée: <br><div style='background-color: black'>");
                                                print((preg_replace("#^(?:<br>|<br />|<br >|<br/>)*#iu", "$1", ($_POST["texte"]))));
                                                print("</div>");
                                                */
                                                //$action = "Modification de commentaire. Nouvelle version: " . (preg_replace("#^(?:<br>|<br >|<br/>|\n|[\n]*|\r)*([.]*)#iu", "$1", ($_POST["texte"])));
                                                //$bdd->exec('INSERT INTO logs_admins(admin, date, IP, navigateur, action) VALUES("'. $user_session .'" , NOW(), "'. $_SERVER["REMOTE_ADDR"] .'", "'. $navigateur .'" , "'. $action .'")');
                                                logs($user_session, "Modification de commentaire. Nouvelle version: " . (preg_replace("#^(?:<br>|<br >|<br/>|\n|[\n]*|\r)*([.]*)#iu", "$1", ($_POST["texte"]))));

                                            }
                                        }
                                    } else {
                                        ?>
                                            <div class="inscrire_pour_repondre">
                                                <p class="inscrire_pour_repondre_p">Pour envoyer des commentaires vous devez vous connecter ou vous inscrire</p>
                                                <form action="connexion.php" method="get" style="margin: auto;">
                                                    <input class="bouton_barrecompte" type="submit" value="Connexion / Inscription" style="border-right: 0; margin: auto; display: block;margin-bottom: 5px;">
                                                </form>
                                            </div>
                                        <?php
                                    }
                                    
                                    $commentcount = 0;
                                    $req = $bdd->prepare('SELECT id, auteur, heure, message_modere, surbrillance FROM commentaire WHERE matiere = ? and supprime = 0 ORDER BY id DESC LIMIT 0, 999'); // Envoi de la requete à la base de données
                                    if($req->execute(array($_GET["matiere"]))){
                                        while($commentaire = $req->fetch()){
                                            $reqAVATAR = $bdd->query("SELECT id, atavar_001 FROM ventilateur WHERE old_u_u_s_e_r = '". $commentaire["auteur"] ."'");
                                            $avatar = $reqAVATAR->fetch();
                                            ?>
                                                <div class="commentaire" title="<?php print($commentaire["heure"]); ?>">
                                                    <img class="avatar" src="uploads/<?php print($avatar["atavar_001"]); ?>" alt="ziva ça bug">
                                                    <span class="pseudo" <?php if($avatar["id"] == "hacker_du_93") print("style='color: red;'") ?>><?php print($commentaire["auteur"]); ?></span>
                                                    <p id="textecommentaire<?php print($commentcount); ?>" style="margin: <?php print($tailleMargeCommentaire); ?>px; padding-left: <?php print($paddinglefttextecomm); ?>px;">
                                                        <?php 
                                                            $texte = nl2br($commentaire["message_modere"]);
                                                            //print("avant preg:<span>". $texte ."</span>fin");
                                                            //$texte = preg_replace("#^(?:<br>|<br />|<br/>)(.+)#iuU", "$1", $texte);
                                                            //print("après preg:<span>". $texte ."</span>fin");
                                                            $texte = preg_replace('#(?:https?|ftp)://(?:[\w~%?=,:;+\#@./-]|&amp;)+#', '<a target="_blank" class="lienactif" href="$0">$0</a>', $texte);                                                        
                                                            print($texte);/* CODE TEXTE --> avec nl2br() */ 
                                                        ?>
                                                    </p>
                                                    <?php
                                                        //if(0){
                                                        if($id_session == "hacker_du_93" || ((strcmp(isset($_SESSION['pseudo'])?$_SESSION['pseudo']:"654456456465frefre", isset($commentaire["auteur"])?$commentaire["auteur"]:"f456erf65fds685dfvg86cacaproute") == 0)?true:false)){
                                                            
                                                            ?>
                                                                <form action="" method="post" enctype="multipart/form-data" style="display: inline;">
                                                                    <input type="hidden" name="supprimerCommentaire" value="<?php print($commentaire["id"]) ?>" />
                                                                    <input class="supprimerCommentaire" type="submit" value="X" title="Supprimer"/>
                                                                </form>
                                                            <?php
                                                            if($id_session == "hacker_du_93"){
                                                                ?>
                                                                    <form action="" method="post" enctype="multipart/form-data" style="display: inline;" onMouseover="ptohidden(<?php print($commentcount); ?>);">
                                                                        <input type="hidden" name="modifierCommentaire" value="<?php print($commentaire["id"]) ?>" />
                                                                        <input type="hidden" name="texte" value="" id="nouveautextecommentaire<?php print($commentcount); ?>" />
                                                                        <input class="modifierCommentaire" type="button" onClick="modifiercommentaire(<?php print($commentcount); ?>)" id="modifCommtextecommentaire<?php print($commentcount); ?>" value="modifier" title="Supprimer"/>
                                                                    </form>
                                                                <?php
                                                            }
                                                        }
                                                    ?>
                                                </div>
                                                
                                            <?php
                                            $commentcount += 1;
                                        }
                                        /*
                                        if($commentcount >= 5){
                                            ?>
                                                <form action="#" method="get">
                                                    <p>
                                                        <input class="bouton" type="submit" value="Voir tous les commentaires" onClick="commentaires()">
                                                    </p>
                                                </form>
                                            <?php
                                        }
                                        */
                                    }
                                ?>

                            </div>
                            <script>
                                function modifiercommentaire(numCom) {
                                    var texte = document.getElementById("textecommentaire" + numCom);
                                    texte.setAttribute('contenteditable', true);
                                    texte.style.backgroundColor = "#feffa9";
                                    texte.style.border = "1px #b5b5b5 solid";
                                    texte.style.borderRadius = "3px";
                                    texte.style.paddingRight = "10px";
                                    texte.style.margin = "2px";
                                    var bouton = document.getElementById("modifCommtextecommentaire" + numCom);
                                    bouton.setAttribute("value", "Envoyer");
                                    setTimeout(function(){
                                        bouton.setAttribute("type", "submit");
                                    }, 100);
                                    //alert('time starts now');
                                
                                }
                                function ptohidden(numCom) {
                                    //alert("nouveautextecommentaire" + numCom);
                                    var content = document.getElementById("textecommentaire" + numCom);
                                    /*
                                    console.log(content.childNodes);
                                    var texte = "";
                                    var i;
                                    if(content.childNodes[0].textContent == ("\n                                                        ") ){
                                        for(i=2; i < content.childNodes.length; i++){
                                            texte += content.childNodes[i].textContent;
                                        }
                                        console.log("Il y a le saut de ligne intempestif. Voici le texte traité: " + texte);
                                    } else {
                                        for(i=0; i < content.childNodes.length; i++){
                                            texte += content.childNodes[i].textContent;
                                        }
                                        console.log("Tout allait bien, voici le texte récupéré: " + texte);
                                    }
                                    */
                                    console.log(content.innerHTML);
                                    var hidden = document.getElementById("nouveautextecommentaire" + numCom);
                                    //alert(content);
                                    hidden.setAttribute("value", content.innerHTML);
                                }
                            </script>

                            <!--
                            <div class="fenetre_commentaires" id="fenetre_commentaires" >
                                <div class="boutonFermer" onClick="revenir()">X</div> 
                                
                            </div>
                            -->

                            <script>
                                 $("#upload").on('submit', (function(e) {
                                    e.preventDefault();
                                    //e.stopPropagation();
                                    //stopPropagation();
                                    $.ajax({
                                        url: "commentaires.php",
                                        type: "POST",
                                        xhr: function() { // xhr qui traite la barre de progression
                                            myXhr = $.ajaxSettings.xhr();
                                            if (myXhr.upload) { // vérifie si l'upload existe
                                                myXhr.upload.addEventListener('progress', afficherAvancement, false); // Pour ajouter l'évènement progress sur l'upload de fichier
                                            }
                                            return myXhr;
                                        },
                                        data: new FormData(this),
                                        contentType: false,
                                        cache: false,
                                        processData: false,
                                        dataType : 'html',
                                        success: function(code_html, statut){
                                            $("#logs").html(code_html);
                                            var mail = document.getElementById("mail");
                                            mail.style.opacity = "0";
                                            var bouton = document.getElementById("sub");
                                            console.log(bouton);
                                            bouton.setAttribute("value", "Terminé");
                                            bouton.setAttribute("onClick", "recharger()");
                                            //bouton.setAttribute("type", "submit");
                                            bouton.setAttribute("id", "aaaaaaa");
                                        },
                                    });
                                    //return false; 
                                }));
                            </script>


                        <?php } /* Fin index version liste fichiers */ ?>


                        <?php
                        $page = 1;
                        $suivant = 1;
                        $nb_fichiers = 0;
                        if(isset($_GET) and array_key_exists("page", $_GET) and is_numeric($_GET["page"])) $page = $_GET["page"];
                        if(isset($finrequete)){
                            $nb_fichiers = $bdd->query('SELECT count(id) as nb FROM fichiers WHERE valide = 1 ' . $finrequete);
                            $nb_fichiers = $nb_fichiers->fetch();
                            $nb_fichiers = $nb_fichiers["nb"];
                        }
                        
                                                                                //// SYSTEME DE GESTION DES PAGES ////

                        //print("nb de fichiers: ". $nb_fichiers ."<br/>");
                        //print("Fin requete: ". $finrequete ."<br/>");
                        if($page*$ELEMENTSPARPAGE > $nb_fichiers) $suivant = 0 ;
                        ?> <div style=""> <?php
                        if($suivant){ /*Si il y a une page suivante*/?>
                            <form action="" method="get" enctype="multipart/form-data" style="float: right;" >
                                <input type="hidden" name="page" value="<?php print($page + 1) ?>" /><?php
                                if(isset($_GET) and array_key_exists("type", $_GET)) print('<input type="hidden" name="type" value="'. htmlspecialchars($_GET["type"]) .'" />');
                                if(isset($_GET) and array_key_exists("annee", $_GET)) print('<input type="hidden" name="annee" value="'. htmlspecialchars($_GET["annee"]) .'" />');
                                if(isset($_GET) and array_key_exists("corrige", $_GET)) print('<input type="hidden" name="corrige" value="'. htmlspecialchars($_GET["corrige"]) .'" />');
                                if(isset($_GET) and array_key_exists("matiere", $_GET)) print('<input type="hidden" name="matiere" value="'. htmlspecialchars($_GET["matiere"]) .'" />');
                                if(isset($_GET) and array_key_exists("niveau", $_GET)) print('<input type="hidden" name="niveau" value="'. htmlspecialchars($_GET["niveau"]) .'" />');
                            ?><input style="background-color: #fff3;border-style: solid;border-width: 1px;line-height: 20px;border-radius: 4px;margin-left: 5px;color: white;" type="submit" value="Suivant >" />
                            </form>
                        <?php }
                        if($page > 1){ /*Si il peut y avoir une page précédente*/?>
                            <form action="" method="get" enctype="multipart/form-data" style="float: right;" >
                                <input type="hidden" name="page" value="<?php print($page - 1) ?>" /><?php
                                if(isset($_GET) and array_key_exists("type", $_GET)) print('<input type="hidden" name="type" value="'. htmlspecialchars($_GET["type"]) .'" />');
                                if(isset($_GET) and array_key_exists("annee", $_GET)) print('<input type="hidden" name="annee" value="'. htmlspecialchars($_GET["annee"]) .'" />');
                                if(isset($_GET) and array_key_exists("corrige", $_GET)) print('<input type="hidden" name="corrige" value="'. htmlspecialchars($_GET["corrige"]) .'" />');
                                if(isset($_GET) and array_key_exists("matiere", $_GET)) print('<input type="hidden" name="matiere" value="'. htmlspecialchars($_GET["matiere"]) .'" />');
                                if(isset($_GET) and array_key_exists("niveau", $_GET)) print('<input type="hidden" name="niveau" value="'. htmlspecialchars($_GET["niveau"]) .'" />');
                                ?><input style="background-color: #fff3;border-style: solid;border-width: 1px;line-height: 20px;border-radius: 4px;color: white;" type="submit" value="< Précédent" />
                        </form>
                        <?php } ?>
                        </div> <?php /* Boutons de pages */ ?>
                    </td>
                </tr>
            </table>

            <div class="basDePage">
                Contact: <a href="mailto:desfichesdescartes@gmail.com">desfichesdescartes@gmail.com</a><br>
                <a href="apropos.php">A propos</a>
            </div>
        </div>

        
        <!--<script src="quidinedort.js"></script>-->
        <script>
            var prem_ouv_comm = true;

            <?php
                if($individuDemandeCookie == true){
                    ?>
                    popuphelphelp();
                    <?php
                }
            ?>
            function popuphelphelp() {
                var select = document.getElementById("popuphelphelp");
                select.style.zIndex = "9999";
                var select = document.getElementById("page");
                select.style = "filter: blur(10px) brightness(0.3);";
                var select = document.getElementById("background");
                select.style = "filter: blur(10px) brightness(0.3);";
            }
            function proposerfiches() {
                var select = document.getElementById("proposerfiches");
                select.style.zIndex = "9999";
                select.style.opacity = "1";
                select.style.display = "unset";
                var select = document.getElementById("page");
                select.style = "filter: blur(10px) brightness(0.3);";
                var select = document.getElementById("background");
                select.style = "filter: blur(10px) brightness(0.3);";
            }
            function feedbacks() {
                var select = document.getElementById("feedbacks");
                select.style.zIndex = "9999";
                select.style.opacity = "1";
                select.style.display = "unset";
                var select = document.getElementById("page");
                select.style = "filter: blur(10px) brightness(0.3);";
                var select = document.getElementById("background");
                select.style = "filter: blur(10px) brightness(0.3);";
            }
            
            function commentaires() {
                var select = document.getElementById("fenetre_commentaires");
                select.style.zIndex = "9999";
                select.style.opacity = "1";
                var select = document.getElementById("page");
                select.style = "filter: blur(10px) brightness(0.3);";
                var select = document.getElementById("background");
                select.style = "filter: blur(10px) brightness(0.3);";
                if(prem_ouv_comm == true){

                }
            }

            

            function revenir() {
                var proposerfiches = document.getElementById("proposerfiches");
                var feedbacks = document.getElementById("feedbacks");
                
                if(proposerfiches.style.zIndex == "9999" || feedbacks.style.zIndex == "9999" || popuphelp.style.zIndex == "9999"){
                    //var select = document.getElementById("proposerfiches");
                    proposerfiches.style.zIndex = "0";
                    proposerfiches.style.opacity = "0";
                    proposerfiches.style.display = "none";
                    //var select = document.getElementById("feedbacks");
                    feedbacks.style.zIndex = "0";
                    feedbacks.style.opacity = "0";
                    feedbacks.style.display = "none";
                    
                    /*
                    var select = document.getElementById("fenetre_commentaires");
                    select.style.zIndex = "0";
                    select.style.opacity = "0";
                    */
                    var select = document.getElementById("page");
                    select.style = "filter: blur(0px);";
                    var select = document.getElementById("background");
                    select.style = "filter: blur(0px);";
                }
            }

            function maximise() {
                //var selection = document.getElementsByClassName("NotesMatieresIntroMinimise");boutonmaximise
                document.getElementById("intromatiere").className = 'NotesMatieresIntroMaximise';
                document.getElementById("boutonmaximise").className = 'NotesMatieresIntroCadreMaximise';
                //document.getElementById("boutonmaximise").style.display = "none";
            }
        </script>

        
    </body>
</html>


