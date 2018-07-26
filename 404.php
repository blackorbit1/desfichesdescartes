<?php
session_cache_limiter('private_no_expire, must-revalidate');
session_start();
include_once("test_session.php");
include_once("navigateur.php");
include_once("compteur_vues.php");
include_once("logs.php");

$action = "ERREUR 404: Page: ". htmlentities(($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']), ENT_QUOTES) . " ////// Page précédente: ".  htmlentities($_SERVER['HTTP_REFERER'], ENT_QUOTES);
logs(isset($_SESSION["pseudo"])?$_SESSION["pseudo"]:"inconnu", $action);
//$bdd->exec('INSERT INTO logs_admins(admin, date, IP, navigateur, action) VALUES("utilisateur" , NOW(), "'. htmlentities($_SERVER["REMOTE_ADDR"], ENT_QUOTES) .'", "'. get_browsername() .'" , "'. $action .'")');                            


?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>DesFichesDescartes</title>
        <meta name="description" content="The point is pointless" />

        <link rel="stylesheet" href="index.css" >
        <link rel="icon" type="image/png" href="favicon2.png" />

        <link rel="shortcut icon" type="image/png" href="favicon2.png">
        <meta name="theme-color" content="#6cbbff">
        <meta name="keywords" content="desfichesdescartes, cours, annales, corrigés, td, tp, 404" />
        <meta name="msapplication-TileColor" content="#ff0000">
        <meta name="msapplication-TileImage" content="iconmetrowin10.png">
        <meta name="application-name" content="DesFichesDescartes">
        <meta property="og:title" content="DesFichesDescartes" />
        <meta property="og:description" content="Site qui contient des TD/TP/Cours/Annales/Fiches/Corrigés/.. pour toutes les matières de math=info de l'université Paris Descartes" />
        <meta property="og:image" content="iconmetrowin10.png" />
    </head>

    
    <body>
        <div style="color: white;">
            <p style="text-align:center;font-family:roboto;font-size:70px;font-weight:bold;margin:0;margin-top: 100px;">Erreur 404</p>
            <p style="text-align:center;font-family:roboto;">Cette page ou ce fichier n'existe pas !</p>
            <br><br>
            <p style="text-align:center;font-family:roboto;">
                Si vous voulez retourner sur le site cliquez ici:
            </p>
            <form action="/index.php" method="get" >
                <p>
                    <input class="bouton" type="submit" value="┬┴┬┴┤ ͜ʖ ͡°) ├┬┴┬┴" style="margin:auto;display:block;"/>
                </p>
            </form>
            <br>
            <br>
            <p style="text-align:center;font-family:roboto;">
                Si vous voulez voir une image de pied cliquez ici:
            </p>
            <form action="/inter_ouverture.php" method="get" >
                <p>
                    <input type="hidden" name="pied" valude="pied" />
                    <input class="bouton" type="submit" value="Voir une image de pied" style="margin:auto;display:block;" />
                </p>
            </form>
        </div>
        
        
    </body>
</html>


