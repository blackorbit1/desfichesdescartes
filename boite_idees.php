<?php
session_cache_limiter('private_no_expire, must-revalidate');
session_start();
include_once("test_session.php");
include_once("navigateur.php");
include_once("compteur_vues.php");


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

                        <div class="droite arrondi padding20px" style="background-color: #fff9;" >
                            <?php include_once("top_bar.php"); ?>
                            <div style="padding: 200px;"> A venir !! </div>
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


