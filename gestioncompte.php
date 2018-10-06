<?php
session_cache_limiter('private_no_expire, must-revalidate');
session_start();
include_once("test_session.php");
include_once("navigateur.php");
include_once("compteur_vues.php");
include_once("logs.php");

if ($super_admin != 1){
    header("Location: index.php");
    exit; //ou die, c'est pareil
}
$navigateur = get_browsername();



?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>DFDC gestion compte</title>
        <meta name="description" content="Defichesdescartes c'est trop bieennnn !" />

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


        <script>
            function changeOnglet(id, idcase){
                var select = document.getElementsByClassName("caseNiv");
                for(var i = 0; i < select.length; i++){
                    select[i].style.display = "none";
                }
                var select = document.getElementsByClassName("td");
                for(var i = 0; i < select.length; i++){
                    select[i].style.backgroundColor = "#5c5c5c";
                }
                for(var i = 0; i < select.length; i++){
                    select[i].style.color = "";
                }
                var select = document.getElementById(id);
                select.style.display = "block";
                var select = document.getElementById(idcase);
                select.style.backgroundColor = "gray";
                select.style.color = "white";
            }
        </script>
                                                
        <div class="page" id="page">
            <div class="entete">
                <a title="logo du site" href="index.php"><img src="logo<?php print(rand(3, 7)); ?>.png" alt="DESFICHESDESCARTES" width="847"></a>
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


                <?php //// //// //// TRAITEMENT DES REQUETES //// //// ////
                    $confirmation = false;
                    if(isset($_POST["niveau"]) && isset($_POST["pseudo"]) && isset($_POST["mdp"]) && isset($_POST["mail"])) {
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
                        $discord = "";
                        if(isset($_POST["pseudo_discord"]) && isset($_POST["num_discord"])){
                            $discord = htmlspecialchars($_POST["pseudo_discord"] . "#" . $_POST["num_discord"]);
                        }
                        $super = 0;
                        if(isset($_POST["super"]) && $user_session == "blackorbit"){
                            $super = 1;
                        } elseif(isset($_POST["super"])){
                            $passation = $bdd->prepare('UPDATE ventilateur SET s_u_p_e_r = 0 WHERE id_number = ?');
                            $passation->execute(array($id_session_number));
                            $super = 1;
                        }

                        $req = $bdd->prepare('INSERT INTO ventilateur(id, old_u_u_s_e_r, old_m_m_d_p__, new_u_u_s_e_r, new_m_m_d_p__, lepremon_____, le_id_etud___, atavar_001, mivault, derco__oooeeeee, cadecount, maille, s_u_p_e_r, d_isc0rd_nomination) VALUES(:id, :old_u_u_s_e_r, :old_m_m_d_p__, :new_u_u_s_e_r, :new_m_m_d_p__, :lepremon_____, :le_id_etud___, :atavar_001, :mivault, NOW(), 0, :maille, :s_u_p_e_r, :d_isc0rd_nomination)');
                        $req->execute(array(
                            "id" => (isset($_POST["admin"]) || $super)?"hacker_du_93":"user",
                            "old_u_u_s_e_r" => $_POST['pseudo'],
                            "old_m_m_d_p__" => isset($_POST["md5"])?$_POST['mdp']:md5($_POST['mdp']),
                            "new_u_u_s_e_r" => $_POST['pseudo']."s",
                            "new_m_m_d_p__" => md5($_POST['mdp']),
                            "lepremon_____" => "Bernard",
                            "le_id_etud___" => "666",
                            "atavar_001" => $nomfichier_new,
                            "mivault" =>  isset($_POST['niveau'])?$_POST['niveau']:"inconnu",
                            "maille" => $_POST["mail"],
                            "s_u_p_e_r" => $super,
                            "d_isc0rd_nomination" => $discord
                        ));
                        $action = "Ajout manuel du compte: ". $_POST["pseudo"];
                        logs(isset($_SESSION["pseudo"])?$_SESSION["pseudo"]:"inconnu", $action);
                        //$bdd->exec('INSERT INTO logs_admins(admin, date, IP, navigateur, action) VALUES("'. htmlentities($_POST['pseudo']) .'" , NOW(), "'. $_SERVER["REMOTE_ADDR"] .'", "'. $navigateur .'" , "'. $action .'")');
                    
                        $confirmation = true;
                    } elseif(isset($_POST["supp_user"])) {
                        $req = $bdd->prepare("DELETE FROM ventilateur WHERE id_number = ? and s_u_p_e_r = 0");
                        $req->execute(array($_POST["supp_user"]));
                        $action = "Suppression d'un utilisateur. ID:' " . htmlspecialchars($_POST["supp_user"]);
                        logs($user_session, $action);
                    }
                    
                ?>




                <td valign="top">
                    <div class="droite arrondi padding20px" style="background-color: #fff9;width: -webkit-fill-available;">
                        <table style="border-spacing: 0;">
                            <tr>
                                <td valign="top" style="width: max-content; display: block;">

                                    <?php /* === === === AJOUTER UN MEMBRE === === === */ ?>

                                    <form action="" method="post" enctype="multipart/form-data" class="cadre_ajout_user">
                                        <?php if($confirmation){ ?>
                                            <div class='success'>Le compte a bien été ajouté</div>
                                            <br>
                                        <?php } ?>
                                        <table>
                                            <tr>
                                                <td>
                                                    <label for="pseudo">Pseudo : </label>
                                                </td>
                                                <td>
                                                    <input type="text" placeholder="Pseudo" name="pseudo" id="pseudo" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label for="mdp">Mot de passe : </label>
                                                </td>
                                                <td>
                                                    <input type="text" placeholder="Mot de passe" name="mdp" id="mdp" required><input type="checkbox" id="md5" name="md5" value="md5"><label for="md5">md5</label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label for="mail">Mail : </label>
                                                </td>
                                                <td>
                                                    <input type="email" name="mail" id="mail" placeholder="Mail" value="" required/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label for="niveau">Niveau : </label>
                                                </td>
                                                <td>
                                                    <select name="niveau" id="niveau">
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
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label for="avatar">Avatar : </label>
                                                </td>
                                                <td>
                                                    <input name="fichier" type="file" id="avatar"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label for="pseudo_discord">Pseudo discord : </label>
                                                </td>
                                                <td>
                                                    <input id="pseudo_discord" style="width: 150px;" type="text" name="pseudo_discord" />#<input style="width: 50px;" type="text" name="num_discord" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label for="admin" style="font-weight: bold; color: red;">Admin : </label>
                                                </td>
                                                <td>
                                                    <input type="checkbox" id="admin" name="admin" value="admin">
                                                </td>
                                            </tr>
                                            <tr style="background-color: #ff00002e;">
                                                <td>
                                                    <label for="super" style="font-weight: bold; color: red;">Super Admin : </label>
                                                </td>
                                                <td>
                                                    <input type="checkbox" id="super" name="super" value="super"> ⚠️ Vous perdrez votre titre de SuperAdmin ⚠️
                                                </td>
                                            </tr>
                                        </table>
                                        <br>
                                        <input type="submit" value="Creer" />
                                    </form>

                                    <?php /* === === === CHANGER GRADE MEMBRE === === === */ ?>

                                    <form action="" method="get" enctype="multipart/form-data" class="cadre_ajout_user">
                                        <?php if($confirmation){ ?>
                                            <div class='success'>Le compte a bien été mis à jour</div>
                                            <br>
                                        <?php } ?>
                                        <table>
                                            <tr>
                                                <td>
                                                    <label for="id">ID : </label>
                                                </td>
                                                <td>
                                                    <input type="text" placeholder="id" name="id" id="id" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Grade : 
                                                </td>
                                                <td>
                                                <input type="radio" name="grade" value="user" id="to_user"> <label for="to_user">Utilisateur</label><br>
                                                <input type="radio" name="grade" value="admin" id="to_admin"> <label for="to_admin" style="font-weight: bold; color: red;">Admin</label><br>
                                                <input type="radio" name="grade" value="superadmin" id="to_superadmin"> <label for="to_superadmin" style="background-color: #ff00002e;"><strong style="color: red;">SuperAdmin</strong> ⚠️ Vous perdrez votre titre de SuperAdmin ⚠️</label>
                                                </td>
                                            </tr>
                                            
                                        </table>
                                        <br>
                                        <input type="submit" value="Creer" />
                                    </form>
                                </td>
                                <td valign="top" style="width: 100%;">
                                    <div class="liste_users">
                                        <?php
                                            function liste_users($grade){
                                                include("bdd.php");
                                                $grade_bdd = "";
                                                if($grade == "super"){
                                                    $grade_bdd = "s_u_p_e_r = 1";
                                                } elseif($grade == "admin") {
                                                    $grade_bdd = "id = 'hacker_du_93' and s_u_p_e_r = 0";
                                                } else {
                                                    $grade_bdd = "id = 'user'";
                                                }
                                                $users = $bdd->query("SELECT old_u_u_s_e_r, derco__oooeeeee, id_number, id, maille, d_isc0rd_nomination, mivault FROM ventilateur WHERE ". $grade_bdd ." ORDER BY derco__oooeeeee DESC");
                                                while ($donnees = $users->fetch()){
                                                    ?>
                                                    <table style="width: 95%; border-collapse: separate;border-spacing: 0px 10px;" class="case_user">
                                                        <tr>
                                                            <td class="">
                                                                <strong>
                                                                    <?php
                                                                        print($donnees["old_u_u_s_e_r"]);
                                                                    ?>
                                                                </strong>
                                                                <br>ID: 
                                                                <?php
                                                                    print($donnees["id_number"]);
                                                                ?>
                                                            </td>
                                                            <td class="">
                                                                dernière connexion:<br>
                                                                <?php
                                                                    print($donnees["derco__oooeeeee"]);
                                                                ?>
                                                            </td>
                                                            <td></td>
                                                            <?php if($grade != "super"){ ?>
                                                                <td rowspan="2" class="">
                                                                    <form action="" method="post" enctype="multipart/form-data">
                                                                        <input type="hidden" placeholder="Pseudo" name="supp_user" value="<?php print($donnees["id_number"]); ?>">
                                                                        <input type="submit" value="Supprimer" class="supp_user" />
                                                                    </form>
                                                                </td>
                                                            <?php } ?>

                                                        </tr>
                                                        <tr>
                                                            <td class="pseudo_discord">
                                                                <?php
                                                                    print(($donnees["d_isc0rd_nomination"] == "")?"<i>pas de pseudo discord</i>":"<strong>".$donnees["d_isc0rd_nomination"]."</strong>");
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                    print($donnees["maille"]);
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                    print($donnees["mivault"]);
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                <?php
                                                }
                                            }
                                        ?>

                                        <h2>SuperAdmins</h2>
                                        <?php
                                            liste_users("super");
                                        ?>
                                        <h2>Admins</h2>
                                        <?php
                                            liste_users("admin");
                                        ?>
                                        <h2>Utilisateurs</h2>
                                        <?php
                                            liste_users("user");
                                        ?>
                                    </div>
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


