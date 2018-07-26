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
        <meta name="description" content="L'olive est verte .... oh !" />
    </head>

    <body>
        <background></background>
        <div class="page">
            <?php include_once("bande_session.php"); if($id_session == "hacker_du_93") print("<br style='line-height: 24px;'/>") ?>
            <div class="entete">
                <a title="logo du site" href="index.php"><img src="logo<?php print(rand(3, 7)); ?>.png" alt="DESFICHESDESCARTES" width="847"></a>
                <!--<a class="nomSite" href="index.php"><img src="logo.png"></a>-->
            </div>
            <div class="page <?php if(get_browsername() == "Safari"){ print('connexionmac'); } else print('connexion')  ?> ">
                <p style="text-align: center;font-size: 20px;">Page de connexion</p>
                <?php 
                if($id_session == "hacker_du_93"){ // Si il est déjà connecté
                    
                    ?>
                        <div class="deleted" style="text-align: center; border-radius: 0px;background-color: rgba(9, 255, 0, 0.61);">Connecté ✔</div><br/>
                    <?php

                } elseif(isset($_POST) and array_key_exists("bad_pw", $_POST)){ // Si il a déjà entré le mdp une fois
                    ?>
                    <div class="deleted" style="text-align: center; border-radius: 0px;">Mauvais mot de passe / login</div><br/>
                    <form action="" method="post" >
                        <p>
                            <input type="text" name="carrotte" placeholder="Login" value=""/><br/>
                            <input type="password" name="poire" placeholder="Mot de passe" value="" /><br/>
                            <br/>
                            <input type="hidden" name="bad_login" value=<?php print("'". htmlspecialchars($_POST["carrotte"]) ."'") ?> />
                            <input type="hidden" name="bad_password" value=<?php print("'". htmlspecialchars($_POST["poire"]) ."'") ?> />
                            <input type="submit" value="Connexion" />
                        </p>
                    </form>
                    <?php
                    $_SESSION['essai'] = 1;

                    } elseif (isset($_POST) and array_key_exists("bad_password", $_POST) and $_POST["carrotte"] == "" and $_POST["poire"] == "" and $_SESSION['essai'] == 1) {  // Si il a validé une 2e fois et qu'il a rien remis
                        $id = "hacker_du_92";

                        $tab = array(htmlentities($_POST['bad_login'], ENT_QUOTES), md5($_POST["bad_password"]));
                        $req = $bdd->prepare('SELECT id FROM ventilateur WHERE old_u_u_s_e_r = ? and old_m_m_d_p__ = ?');
                        if(!($req->execute($tab))){
                            ?> <div class="deleted" style="text-align: center; border-radius: 0px;">Erreur 500.653.07bis alpha 3</div><br/> <?php
                        } else {
                            $donnee = $req->fetch();
                            $req->closeCursor();
                        }

                        if($donnee["id"] == "hacker_du_93"){ // Si il est bien dans la base de données
                            $_SESSION['pseudo'] = htmlentities($_POST['bad_login']); // On initialise la session
                            $_SESSION['mdp'] = md5($_POST["bad_password"]);
                            $req = $bdd->prepare('UPDATE ventilateur SET derco__oooeeeee = NOW() WHERE old_u_u_s_e_r = ?');
                            if(!($req->execute(array(htmlentities($_POST['bad_login'], ENT_QUOTES))))){
                                ?> <div class="deleted" style="text-align: center; border-radius: 0px;">Erreur de ponts intra-parallelo-structurels discontinus</div><br/> <?php
                            } else {
                                ?><div class="deleted" style="text-align: center; border-radius: 0px;background-color: rgba(9, 255, 0, 0.61);">Connecté ✔</div><br/><?php
                            }
                        } else { ?>
                            <div class="deleted" style="text-align: center; border-radius: 0px;">Mauvais mot de passe / login</div><br/>
                            <form action="" method="post" >
                                <p>
                                    <input type="text" name="carrotte" placeholder="Login" value=""/><br/>
                                    <input type="password" name="poire" placeholder="Mot de passe" value="" /><br/>
                                    <br/>
                                    <input type="hidden" name="bad_login" value=<?php print("'". htmlspecialchars($_POST["carrotte"]) ."'") ?> />
                                    <input type="hidden" name="bad_password" value=<?php print("'". htmlspecialchars($_POST["poire"]) ."'") ?> />
                                    <input type="submit" value="Connexion" />
                                </p>
                            </form>
                            <?php
                            $action = "Une personne a tenté de se connecter sur brocoli avec des mauvais logins";
                            logs(isset($_SESSION["pseudo"])?$_SESSION["pseudo"]:"inconnu", $action);
                            //$bdd->exec('INSERT INTO logs_admins(admin, date, IP, navigateur, action) VALUES("utilisateur" , NOW(), "'. htmlentities($_SERVER["REMOTE_ADDR"], ENT_QUOTES) .'", "'. $navigateur .'" , "'. $action .'")');                            
                            $_SESSION['essai'] = 0;
                        }
                    } elseif (isset($_POST) and array_key_exists("bad_password", $_POST) and $_POST["carrotte"] != "" and $_POST["poire"] != "") {?>
                        <div class="deleted" style="text-align: center; border-radius: 0px;">Mauvais mot de passe / login</div><br/>
                        <form action="" method="post" >
                            <p>
                                <input type="text" name="carrotte" placeholder="Login" value=""/><br/>
                                <input type="password" name="poire" placeholder="Mot de passe" value="" /><br/>
                                <br/>
                                <input type="hidden" name="bad_login" value="N/A" />
                                <input type="hidden" name="bad_pw" value="N/A" />
                                <input type="submit" value="Connexion" />
                            </p>
                        </form>
                        <?php
                    } else {
                        ?>
                    
                    <form action="" method="post" >
                        <p>
                            <input type="text" name="carrotte" placeholder="Login" value=""/><br/>
                            <input type="password" name="poire" placeholder="Mot de passe" value="" /><br/>
                            <br/>
                            <input type="hidden" name="bad_login" value="N/A" />
                            <input type="hidden" name="bad_pw" value="N/A" />
                            <input type="submit" value="Connexion" />
                        </p>
                    </form>

                    <?php } ?>
                
            </div>
            
        </div>

    </body>
</html>