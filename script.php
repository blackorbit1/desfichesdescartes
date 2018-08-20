<!DOCTYPE html>
<?php
session_start();
include_once("bdd.php");
include_once("test_session.php");
include_once("navigateur.php");
include_once("compteur_vues.php");
include_once("logs.php");
?>

<html>
    <head>
        <title>Script DFDC</title>
    </head>

    <body>
        <h1>Script</h1>
        <?php
            $fichier = fopen('compteur.txt', 'r');
            $fin = false;
            while($fin == false){
                $ligne = fgets($fichier);
                if(preg_match("#matiere=([a-zA-Z0-9]{3,10})&onglet=([a-zA-Z0-9]{3,10})\">(.*)</a>#", $ligne, $matches)){
                    $matiere = $matches[1];
                    $niveau = $matches[2];
                    $nom = $matches[3];
                }

                if(preg_match("#===FIN_FICHIER===#", $ligne)){
                    $fin = true;
                }
            }
            


            fclose($fichiers);
        
        ?>
        <br>
        <p>Terminé</p>
    </body>
</html>