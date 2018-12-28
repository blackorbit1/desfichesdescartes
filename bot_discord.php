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
        <title>DFDC bot discord</title>
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
                    if(isset($_POST["regex"]) && isset($_POST["reponse"])){
                        $req = $bdd->prepare('INSERT INTO reponses_bot(regex, reponse) VALUES(:regex, :reponse)');
                        $req->execute(array(
                            'regex' => $_POST["regex"],
                            'reponse' => $_POST["reponse"]
                        ));
                    } elseif(isset($_POST["id_a_supp"])){
                        $req = $bdd->prepare('UPDATE reponses_bot SET supprime = 1 WHERE id = :id');
                        $req->execute(array(
                            'id' => $_POST["id_a_supp"]
                        ));
                    }
                    
                ?>




                <td valign="top">
                    <div class="droite arrondi" style="background-color: #fff9;width: -webkit-fill-available;">
                        <form action="" method="post" enctype="multipart/form-data">
                            <table style="width: 100%;">
                                <tr style="width: 100%;">
                                    <td style="width: -webkit-fill-available">
                                        <input type="text" name="regex" placeholder="regex" style="width: 100%">
                                    </td>
                                    <td style="width: -webkit-fill-available;">
                                        <input type="text" name="reponse" placeholder="réponse bot" style="width: 100%">
                                    </td>
                                    <td>
                                        <input type="submit" value="Valider">
                                    </td>
                                </tr>
                            </table>
                        </form>

                        <?php
                            $req = $bdd->query("SELECT id, regex, reponse FROM reponses_bot WHERE supprime = 0 ORDER BY id DESC");
                        ?>

                        <table style="width: 100%;">
                            <?php
                                while ($donnees = $req->fetch()){ ?>
                                    <tr style="width: 100%;">
                                        <form action="" method="post" enctype="multipart/form-data">
                                            <td style="width: -webkit-fill-available">
                                                <?php print($donnees["regex"]); ?>
                                            </td>
                                            <td style="width: -webkit-fill-available;">
                                                <?php print($donnees["reponse"]); ?>
                                            </td>
                                            <td>
                                                <input type="hidden" name="id_a_supp" value="<?php print($donnees["id"]); ?>">
                                                <input type="submit" value="Supprimer">
                                            </td>
                                        </form>
                                    </tr>
                                <?php }
                            ?>
                        </table>

                    </div>
                </td>
            </table>


            
        </div>

        
        <!--<script src="quidinedort.js"></script>-->
    </body>
</html>


