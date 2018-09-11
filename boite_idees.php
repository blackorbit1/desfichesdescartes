<?php
session_cache_limiter('private_no_expire, must-revalidate');
session_start();
include_once("test_session.php");
include_once("navigateur.php");
include_once("compteur_vues.php");
include_once("logs.php");

if(isset($_SESSION["pseudo"])){
    logs($_SESSION["pseudo"], "Est allé sur la boite à idées");
} else {
    logs("inconnu", "Est allé sur la boite à idées");
}

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>DesFichesDescartes</title>
        <meta name="description" content="Bienvenu sur le site DesFichesDescartes, un site totallement indépendant de l’université et de tout organisme. Vous trouvez ici toutes les fiches que nous avons en notre possession. La partie la plus complète est actuellement celle de la L2 d’informatique (car c’est la classe dans laquel nous sommes) mais les autres parties vont s’étoffer petit à petit. " />

        <link rel="stylesheet" href="index.css" >
        <link rel="icon" type="image/png" href="favicon2.png" />

        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

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
    </head>

    
    <body>
        <background id="background"></background>
        <?php include_once("bande_session.php"); if($id_session == "hacker_du_93") print("<br style='line-height: 24px;'/>") // Si l'user est un admin ?>

                                  
        <div class="page" id="page">
            <div class="entete">
            <a title="logo du site" href="index.php"><img src="logos/logo<?php print(rand(1, 22)); ?>.png" alt="DESFICHESDESCARTES" width="847"></a>
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

                        <div class="droite arrondi padding20px" style="background-color: #ffffffd1;" >
                            <?php include_once("top_bar.php"); ?>
                            <div class="changelog">
                                <h2 style="text-align: center;">Boite</h2>
                                <?php
                                    if($id_session == "hacker_du_93"){                                       ///// SI L'USER EST UN ADMIN /////

                                        /// --- --- --- Traitement du texte envoyé --- --- --- ///

                                        if(isset($_POST["texte"])){ // Si il y a eu une requete de modification
                                            //print("<pre>"); print_r($_POST); print("<pre>");
                                            //print($screen_dim);
                    
                                            $bdd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);

                                            //print("<pre>"); print_r($req->fetch()); print("<pre>");

                                            //$req = $bdd->prepare('INSERT INTO notes_matieres(affiche, nom_mat, intro_mat, texte, derniere_maj) VALUES(1, :nom_mat, :intro_mat, :texte, NOW())');
                                            $req = $bdd->prepare('INSERT INTO boite_a_idees(texte,
                                                                                            derniere_maj,
                                                                                            auteur,
                                                                                            ip) 
                                                                    VALUES( :texte,
                                                                            NOW(),
                                                                            :auteur,
                                                                            :ip)');
                                            $req->execute(array(
                                                "texte" => $_POST["texte"],
                                                "auteur" => $_SESSION["pseudo"],
                                                "ip" => $_SERVER["REMOTE_ADDR"]
                                            ));
                                            ?><div class='success'>Boite de la boite à idées modifiée !</div><br/><?php
                                        }


                                        
                                        /// --- --- --- Affichage du contenu de la boite --- --- --- ///

                                        $bdd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
                                        
                                        $req = $bdd->query('SELECT *
                                                            FROM boite_a_idees 
                                                            ORDER BY id DESC LIMIT 1
                                                            '); // Envoi de la requete à la base de données
                                        $donnees = $req->fetch();
                                        ?>


                                        <form action="" method="post" enctype="multipart/form-data">
                                            <textarea class="champtexteAdminNotesMatieres" placeholder="Introduction de la matiere" name="texte" rows=20 cols=40 placeholder=""><?php print($donnees["texte"]); ?></textarea><br>
                                            <br><input class="bouton" type="submit" value="Valider" style="border-radius: 3px;line-height: 15px;"/> 
                                            <i>Derniere maj: <?php print($donnees["derniere_maj"]); ?></i>
                                        </form>


                                            
                                        <?php
                                    } else {                              ///// SI L'USER N'EST PAS UN ADMIN /////
                                    
                                        try {
                                            $bdd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
                                            $req = $bdd->query('SELECT * 
                                                                FROM boite_a_idees 
                                                                ORDER BY id DESC LIMIT 1
                                                                '); // Envoi de la requete à la base de données
                                            $donnees = $req->fetch();

                                            $texte = $donnees["texte"];
                                            $texte = preg_replace('#(?:https?|ftp)://(?:[\w~%?=,:;+\#@./-]|&amp;)+#', '<a target="_blank" class="lienactif" href="$0">$0</a>', $texte);
                                            //$texte = preg_replace('#www.(?:[\w%?=,:;+\#@./-]|&amp;)+#', '<a target="_blank" class="lienactif" href="http://$0">$0</a>', $texte);
                                            $texte=preg_replace('/(\S+@\S+\.\S+)/','<a class="mail" href="mailto:$0">$0</a>',$texte)
                                            
                                            ?>
                                            <p><?php print(nl2br($texte)); ?></p>
                                            <p class="NotesMatieresDateModification">Dernière maj: <b><?php print($donnees["derniere_maj"]); ?></b></p>
                                            

                                            <?php
                                        } catch (Exception $e) {
                                            print("");
                                            $action = ("Problème lors de l'acces à la dernière version de la boite de la boite à idées ou lors de son affichage. Exception:" . $e->getMessage());
                                            logs(isset($_SESSION["pseudo"])?$_SESSION["pseudo"]:"inconnu", $action);
                                        }
                                    } 
                                ?>
                            </div>
                            <h1 style="text-align: center;">Boite à idées</h1>
                            Bienvenue dans la section boite à idées !
                            <br>
                            <br>Le tchat de cette section est directement connecté à la room discord de la FAC #boite_a_idees_dfdc, de sorte que les messages envoyés depuis le site y sont directement retransmit et inversement pour les messages envoyés depuis les utilisateurs discord.
                            <br>
                            <br>Nous vous invitons tout de même à utiliser discord pour les discussions car il y est bien mieux adapté que le site et que tous les admins du site y sont présents.
                            <br>
                            <br>Si vous souhaitez devenir modérateur pour aider à la validation des nouveaux fichiers et la modération des commentaires, n’hésitez pas à contacter le superadmin [pseudo du superadmin actuel] sur discord.
                            <br>
                            <br>Nous sommes ouverts à toute aide pour le codage des nouvelles fonctions ou meme des propositions de nouveaux elements graphiques !
                            <br><strong>Voici les différents repos liés à DesFichesDescartes:</strong>
                            <br>
                            <br>Repos GitHub du site: <a href="https://github.com/blackorbit1/desfichesdescartes">https://github.com/blackorbit1/desfichesdescartes</a>
                            <br>Repos GitHub de l'appli: <a href="https://github.com/blackorbit1/miniDFDC">https://github.com/blackorbit1/miniDFDC</a>
                            <br>Repos GitHub du bot discord (privé réservé aux admins): <a href="https://github.com/blackorbit1/DiscordBotDFDC">https://github.com/blackorbit1/DiscordBotDFDC</a>

                        </div> <!-- page droite -->
                         
                    </td>
                </tr>
            </table>

            <div class="basDePage">
                Contact: <a href="mailto:desfichesdescartes@gmail.com">desfichesdescartes@gmail.com</a><br>
                <a href="apropos.php">A propos</a>
            </div>
        </div>



        
    </body>
</html>


