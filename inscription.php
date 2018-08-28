<?php
session_start();
include_once("test_session.php");
include_once("navigateur.php");
include_once("logs.php");

$action = "Est en 2e étape d'inscription";
logs(isset($_SESSION["pseudo"])?$_SESSION["pseudo"]:"inconnu", $action);
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
                <a title="logo du site" href="index.php"><img src="logo<?php print(rand(3, 7)); ?>.png" alt="DESFICHESDESCARTES" width="847"></a>
                <!--<a class="nomSite" href="index.php"><img src="logo.png"></a>-->
            </div>
            

            <div class="page <?php if(get_browsername() == "Safari"){ print('connexionmac'); } else print('connexion')  ?> ">
                <p style="text-align: center;font-size: 20px;">Page d'inscription</p>
                <?php
                    if(!isset($_POST["finalisation"]) && (!isset($_POST["pseudo"]) || !isset($_POST["mdp1"]) || !isset($_POST["mdp2"]) || !isset($_POST["mail"])) || $_POST["mdp1"] != $_POST["mdp2"]){
                        ?>
                            <div class="deleted" style="text-align: center; border-radius: 0px;">Il manque des informations ou les 2 mots de passe sont différents</div>
                            <form action="" method="post" >
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
                        <?php
                    } elseif($_POST["pseudo"] == "blackorbit") {
                        ?>
                            <div class="deleted" style="text-align: center; border-radius: 0px;">Vous n'avez pas le droit de prendre le pseudo du supreme admin créateur <strong>blackorbit</strong></div>
                            <form action="" method="post" >
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
                        <?php
                    } elseif(!isset($_POST["finalisation"])) { //<input type="hidden" name="Deconnexion" value="" />
                        ?>
                            <form action="inscription.php" method="post" enctype="multipart/form-data">
                                <p style="color: gray;">
                                    (étape non obligatoire)
                                </p>
                                <p>
                                    Niveau: 
                                    <select name="niveau">
                                        <option value="L1_math_info">L1</option>
                                        <option value="L2_math">L2 (maths)</option>
                                        <option value="L2_info">L2 (info)</option>
                                        <option value="L2_math_info">L2 (double licence)</option>
                                        <option value="L3_math">L3 (maths)</option>
                                        <option value="L3_info">L3 (info)</option>
                                        <option value="L3_math_info">L3 (double licence)</option>
                                        <option value="M1_info">M1 (info)</option>
                                        <option value="M1_math">M1 (maths)</option>
                                        <option value="M2_info">M2 (info)</option>
                                        <option value="M2_math">M2 (maths)</option>
                                    </select>
                                    <br><br>
                                    Avatar: <input name="fichier" type="file"/><br>
                                    <br>
                                    <input type="hidden" name="pseudo" value="<?php print($_POST["pseudo"]); ?>" />
                                    <input type="hidden" name="mdp" value="<?php print(md5($_POST["mdp1"])); ?>" />
                                    <input type="hidden" name="mail" value="<?php print($_POST["mail"]); ?>" />
                                    <input type="hidden" name="finalisation" value="finalisation" />

                                    <input type="submit" value="Terminer" />
                                </p>
                            </form>
                        <?php
                    } elseif(isset($_POST["finalisation"]) && isset($_POST["pseudo"]) && isset($_POST["mdp"]) && isset($_POST["mail"])) {
                        $nomfichier_new = "inconnu";
                        $formats = array("png", "jpg", "jpeg", "gif", "PNG", "JPG", "JPEG", "GIF");
                        //end(explode('.', $nomfichier_current))
                        //print_r($_FILES);
                        if(in_array(end(explode('.', $_FILES['fichier']['name'])), $formats)){
                            $bytes = random_bytes(22);
                            $nomfichier_new = (bin2hex($bytes) . "." . end(explode('.', $_FILES['fichier']['name']))); // $nomfichier_new <-- nouveau nom pour enregistrement
                            move_uploaded_file($_FILES['fichier']['tmp_name'], 'uploads/' . basename($nomfichier_new));
                            //print("çaaaaaaaaaaaaaaaa sent le roussi");
                        }

                        $req = $bdd->prepare('INSERT INTO ventilateur(id, old_u_u_s_e_r, old_m_m_d_p__, new_u_u_s_e_r, new_m_m_d_p__, lepremon_____, le_id_etud___, atavar_001, mivault, derco__oooeeeee, cadecount, maille) VALUES(:id, :old_u_u_s_e_r, :old_m_m_d_p__, :new_u_u_s_e_r, :new_m_m_d_p__, :lepremon_____, :le_id_etud___, :atavar_001, :mivault, NOW(), 0, :maille)');
                        $req->execute(array(
                            "id" => "user",
                            "old_u_u_s_e_r" => $_POST['pseudo'],
                            "old_m_m_d_p__" => $_POST['mdp'],
                            "new_u_u_s_e_r" => $_POST['pseudo']."s",
                            "new_m_m_d_p__" => md5($_POST['mdp']),
                            "lepremon_____" => "Bernard",
                            "le_id_etud___" => "666",
                            "atavar_001" => $nomfichier_new,
                            "mivault" =>  isset($_POST['niveau'])?$_POST['niveau']:"inconnu",
                            "maille" => $_POST["mail"],
                        ));
                        $_SESSION['pseudo'] = htmlentities($_POST['pseudo']); // On initialise la session
                        $_SESSION['mdp'] = $_POST["mdp"];
                        $action = "S'est inscrit sur le site";
                        logs(isset($_SESSION["pseudo"])?$_SESSION["pseudo"]:"inconnu", $action);
                        //$bdd->exec('INSERT INTO logs_admins(admin, date, IP, navigateur, action) VALUES("'. htmlentities($_POST['pseudo']) .'" , NOW(), "'. $_SERVER["REMOTE_ADDR"] .'", "'. $navigateur .'" , "'. $action .'")');

                        ?>
                            <div class="deleted" style="text-align: center; border-radius: 0px;background-color: rgba(9, 255, 0, 0.61);">Vous etes inscrit(e) et connecté !</div>
                            <br>
                            <br>
                            <form action="index.php" method="get" >
                                <input class="connexioninscription bouton" type="submit" value="Se barrer de cette page" />
                            </form>
                            <br>
                        <?php
                    } else {
                        ?>
                        Euh attendez, y a un pb là, vous etes pas en train de jouer avec les requetes ?<br>
                        Tenez, je vous met un bouton pour repartir sur de bonnes bases:<br>
                        <br>
                        <form action="inscription.php" method="get" >
                            <input class="connexioninscription bouton" type="submit" value="Repartir sur de bonnes bases" />
                        </form>
                        <br>
                        <?php
                        $action = "Est peut etre en train de jouer avec les requetes. GET = " . serialize($_GET) . " /// POST = " . serialize($_POST);
                        logs(isset($_SESSION["pseudo"])?$_SESSION["pseudo"]:"inconnu", $action);
                    }
                ?>
                
            </div>
            
        </div>

    </body>
</html>