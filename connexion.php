<?php
session_start();
include_once("test_session.php");
include_once("navigateur.php");
include_once("logs.php");
//include_once("compteur_vues.php");

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="index.css" >
        <link rel="icon" type="image/png" href="favicon2.png" />
        <meta name="theme-color" content="#6cbbff">
        <meta name="msapplication-TileColor" content="#6cbbff">
        <meta name="msapplication-TileImage" content="iconmetrowin10.png">
        <meta name="application-name" content="BRO CO LI">
        <title>Connexion</title>
        <meta name="description" content="Ceci est une page de connexion, euh, qui peut aussi servir de page d'inscription, et c'est bien (ici d'ailleur on ne mange pas de brocolis !)" />
    </head>

    <body>
        <background></background>
        <div class="page">
            <?php include_once("bande_session.php"); if($id_session == "hacker_du_93") print("<br style='line-height: 24px;'/>") ?>
            <div class="entete">
                <a title="logo du site" href="index.php"><img src="logos/logo<?php print(rand(1, 23)); ?>.png" alt="DESFICHESDESCARTES" width="847"></a>
                <!--<a class="nomSite" href="index.php"><img src="logo.png"></a>-->
            </div>
            <div class="page <?php if(get_browsername() == "Safari"){ print('connexionmac'); } else print('connexion')  ?> " style="    padding-bottom: 0px;">

                <?php
                    if(isset($_POST["pseudo"]) && isset($_POST["mdp"])){
                        $tab = array(htmlentities($_POST['pseudo'], ENT_QUOTES), md5($_POST["mdp"]));
                        $req = $bdd->prepare('SELECT id FROM ventilateur WHERE old_u_u_s_e_r = ? and old_m_m_d_p__ = ?');
                        if(!($req->execute($tab))){
                            ?> <div class="deleted" style="text-align: center; border-radius: 0px;">Erreur 500.653.07bis alpha 3</div><br/> <?php
                        } else {
                            $donnee = $req->fetch();
                            $req->closeCursor();
                        }

                        if($donnee["id"] == "user"){ // Si il est bien dans la base de données
                            $_SESSION['pseudo'] = htmlentities($_POST['pseudo']); // On initialise la session
                            $_SESSION['mdp'] = md5($_POST["mdp"]);
                            $req = $bdd->prepare('UPDATE ventilateur SET derco__oooeeeee = NOW() WHERE old_u_u_s_e_r = ?');
                            if(!($req->execute(array(htmlentities($_POST['pseudo'], ENT_QUOTES))))){
                                ?> <div class="deleted" style="text-align: center; border-radius: 0px;">Erreur: la date de connexion n'a pas pu etre enregistrée dans la BDD</div><br/> <?php
                            } else {
                                $id_session = "user";
                            }
                            $action = "Connexion au site";
                            logs($_POST['pseudo'], $action);
                            //$bdd->exec('INSERT INTO logs_admins(admin, date, IP, navigateur, action) VALUES("'. htmlentities($_POST['pseudo']) .'" , NOW(), "'. $_SERVER["REMOTE_ADDR"] .'", "'. $navigateur .'" , "'. $action .'")');

                        } else {
                            ?><div class="deleted" style="text-align: center; border-radius: 0px;">Mauvais mot de passe ou pseudo</div><br/>
                            <?php
                            $action = "S'est trompé de mot de passe ou n'a pas de compte";
                            logs($_POST['pseudo'], $action);
                            //$bdd->exec('INSERT INTO logs_admins(admin, date, IP, navigateur, action) VALUES("'. htmlentities($_POST['pseudo']) .'" , NOW(), "'. $_SERVER["REMOTE_ADDR"] .'", "'. $navigateur .'" , "'. $action .'")');
                            
                        }

                    }
                ?>

                 
                <p style="text-align: center;font-size: 20px;">Page de connexion</p>
                <?php 
                if($id_session == "user"){ // Si il est connecté
                    
                    ?>
                        <div class="deleted" style="text-align: center; border-radius: 0px;background-color: rgba(9, 255, 0, 0.61);">Connecté ✔</div><br/>
                        <br>
                        <form action="index.php" method="get" >
                            <input class="connexioninscription bouton" type="submit" value="Se barrer de cette page" />
                        </form>
                        <br>
                    <?php

                } else {
                    ?>
                    
                    <form action="" method="post" >
                        <p>
                            <input type="text" name="pseudo" placeholder="Login" value="" required/><br/>
                            <input type="password" name="mdp" placeholder="Mot de passe" value="" required/><br/>
                            <br/>
                            <input type="submit" value="Connexion" />
                        </p>
                    </form>
                    <div class="pasofficiel">
                        <p style="font-size: smaller;"><strong>Attention:</strong> ce site n'est pas un site officiel de l'université, vous n'y etes donc pas inscrits par défaut</p>
                    </div>

                <?php } ?>
                
            </div>

            

            <div class="page <?php if(get_browsername() == "Safari"){ print('connexionmac'); } else print('connexion')  ?> ">
                    <table>
                        <tr>
                            <td style="border-right: 1px solid #ececec;">
                                <p style="text-align: center;font-size: 20px;">Page d'inscription</p>
                                <form action="inscription.php" method="post" >
                                    <p>
                                        <input type="text" name="pseudo" placeholder="Login" value="" required/><br/>
                                        <br>
                                        <input type="password" name="mdp1" placeholder="Mot de passe" value="" required/><br/>
                                        <input type="password" name="mdp2" placeholder="Mot de passe (vérification)" value="" required/><br/>
                                        <br/>
                                        <input type="email" name="mail" placeholder="Mail" value="" required/><br/>
                                        <br>
                                        <input type="submit" value="Inscription" />
                                    </p>
                                </form>
                            </td>
                            <td style="text-align: left;width: 50%;padding: 20px;">
                            <p style="text-align: center;font-size: 18px;">A quoi ça sert ?</p>
                            <p>
                                Avec un compte, vous pouvez:
                                <ul>
                                    <li>Poster des commentaires dans chaque matières</li>
                                    <li>Voir des fichiers pas encore validés par les modérateurs</li>
                                    <li>Discuter dans la boite à idées</li>
                                </ul>
                            </p>
                            </td>
                        </tr>
                    </table>
                
            </div>

            
            
        </div>

    </body>
</html>