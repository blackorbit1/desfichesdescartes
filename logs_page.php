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
        <title>DFDC logs</title>
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
                    
                    
                ?>




                <td valign="top">
                    <div class="droite arrondi" style="background-color: #fff9;width: -webkit-fill-available;">
                        <?php
                            $types = array("404", "internal", "bad_behavior", "action", "bot");
                        ?>
                        <table style="border-spacing: 0;">
                            <tr>
                                <?php
                                    for($type in $types){
                                        $req = $bdd->query("SELECT id, admin, date, IP, navigateur, action, type FROM logs_admins WHERE ". $grade_bdd ." ORDER BY derco__oooeeeee DESC");
                                        $donnees = $req->fetch();
                                    }
                                <td>

                                    
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


