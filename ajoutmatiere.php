<?php
session_start();
include_once("test_session.php");
include_once("navigateur.php");
include_once("compteur_vues.php");
include_once("logs.php");


if (1){
    $action = "A tenté d'acceder à la page d'ajout de matieres";
    logs(isset($_SESSION["pseudo"])?$_SESSION["pseudo"]:"inconnu", $action);
    header("Location: index.php");
    exit; //ou die, c'est pareil
}
 ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="index.css" >
        <title>Proposer des fiches</title>
    </head>

    <body onload="init()">
        <background></background>
        <div class="sousPage">
            <?php include_once("bande_session.php"); if($id_session == "hacker_du_93") print("<br style='line-height: 24px;'/>") ?>
            <a class="logo" title="logo du site" href="index.php"></a>
            <a class="nomSite" href="index.php">DesFiches Descartes </a>
            <div class="page">

                <div class="surPageBlanche haut" style="padding-bottom: 10px;">
                    <p class="proposerFiche">
                        Ajout matière
                    </p>
                </div>

                <div class="surPageTransparente bas" style="background-color: rgba(255, 255, 255, 0.71);">
                    <form action="" method="post" enctype="multipart/form-data">
                        
                        <br/>
                        
                        <p style="font-size: 12px;">

                        <input type="text" name="code_matiere" placeholder="Code matiere"/>

                        <select name="niveau">
                            <option value="L3_math_info">L3 maths ou info</option>
                            <option value="L2_math_info">L2 maths ou info</option>
                            <option value="L3_math_info">L3 maths ou info</option>
                        </select>

                        <input type="text" name="nom_matiere" placeholder="Nom matiere"/>


                    
                        <input type="submit" value="Envoyer" />

                    </form>
                    <?php
                        if(isset($_POST) and array_key_exists("code_matiere", $_POST) and array_key_exists("niveau", $_POST) and array_key_exists("nom_matiere", $_POST)) { // Si le formulaire est envoyé
                            //print("<pre>"); print_r($_POST); print("</pre>");
                            

                            // Creer une variable qui donne le navigateur de l'utilisateur

                            // Fonction d'enregistrement de chaque fichiers dans la base de données
                            function fichiers_BDD($bdd,
                                                    $code, 
                                                    $niveau, 
                                                    $nom){
                                $req = $bdd->prepare('INSERT INTO matiere(code, 
                                                                            niveau,
                                                                            nom) 
                                                        VALUES(:code, 
                                                                :niveau,
                                                                :nom)');
                                $req->execute(array(
                                    "code" => $code,
                                    "niveau" => $niveau,
                                    "nom" => $nom));
                                $req->closeCursor();
                            }

                            if(array_key_exists("code_matiere", $_POST)) $code_matiere = ($_POST["code_matiere"]);
                            if(array_key_exists("niveau", $_POST)) $niveau = ($_POST["niveau"]);
                            if(array_key_exists("nom_matiere", $_POST)) $nom_matiere = ($_POST["nom_matiere"]);

                            //$bdd->exec("INSERT INTO matiere(code, niveau, nom) VALUES id = " . $_POST["id"]);
                            fichiers_BDD($bdd, $code_matiere, $niveau, $nom_matiere);

                            print("La matiere <strong>" . htmlspecialchars($nom_matiere) . "</strong> a bien été ajoutée ! <br />");
                        } 

                    ?>


                </div>
            </div>
        </div>

    </body>
</html>