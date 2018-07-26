<?php
session_cache_limiter('private_no_expire, must-revalidate');
session_start();
include_once("test_session.php");
include_once("navigateur.php");
include_once("compteur_vues.php");
include_once("logs.php");

if ($id_session != "hacker_du_93"){
    header("Location: index.php");
    exit; //ou die, c'est pareil
}
$navigateur = get_browsername();

$action = "Utilisation de la page de feedbacks";
logs($user_session, $action);
//$bdd->exec('INSERT INTO logs_admins(admin, date, IP, navigateur, action) VALUES("'. $user_session .'" , NOW(), "'. $_SERVER["REMOTE_ADDR"] .'", "'. $navigateur .'" , "'. $action .'")');


?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>DFDC Feedbacks</title>
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

         




                <td valign="top">
                    <div class="droite arrondi padding20px" style="background-color: #fff9;">

                        <h2 class="t_admin">Feedbacks</h2>

                        <?php
                            $req = $bdd->query("SELECT id, texte, date_envoi, navigateur, ip_user, screen_dim, langue, systeme FROM feedbacks ORDER BY date_envoi DESC ");

                            while ($donnees = $req->fetch()){
                                ?>
                                <div class="casefeedbacks">
                                    <div class="topfeedbacks">
                                        <p><?php print("post n°" . $donnees["id"] . "&nbsp&nbsp&nbsp&nbsp&nbsp IP: " . $donnees["ip_user"] . "&nbsp&nbsp&nbsp&nbsp&nbsp " . htmlspecialchars($donnees["navigateur"]) . "&nbsp&nbsp&nbsp&nbsp&nbsp " . htmlspecialchars($donnees["langue"]));
                                                print("&nbsp&nbsp&nbsp&nbsp&nbsp Date: " . $donnees["date_envoi"]);
                                        ?></p>
                                    </div>
                                    <div class="basfeedbacks">
                                        <p><?php print(htmlspecialchars($donnees["texte"])) ?></p>
                                    </div>
                                </div>
                                <br/>
                            <?php
                            }
                            $req->closeCursor();
                        ?>





                        



                
                    </div>
                </td>
            </table>


            
        </div>

        
        <!--<script src="quidinedort.js"></script>-->
    </body>
</html>


