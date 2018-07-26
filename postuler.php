<?php
session_cache_limiter('private_no_expire, must-revalidate');
session_start();
include_once("test_session.php");
include_once("navigateur.php");
include_once("compteur_vues.php");
include_once("logs.php");

if(isset($_SESSION["pseudo"])){
    logs($_SESSION["pseudo"], "Est allé sur la page pour postuler");
} else {
    logs("inconnu", "Est allé sur la page pour postuler");
}

// nb de pages max
$ELEMENTSPARPAGE = 100; //  <<<<< CHANGER LE SYSTEME
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>DesFichesDescartes</title>
        <meta name="description" content="Là c'est la page pour postuler, comme son nom l'indique" />

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
        <?php 
            if(!isset($_GET["matiere"])){
                include_once("proposerfiches.php"); 
                include_once("feedbacks.php"); 
            }
        ?>

        <background id="background"></background>
        <?php include_once("bande_session.php"); if($id_session == "hacker_du_93") print("<br style='line-height: 24px;'/>") // Si l'user est un admin ?>


        
                                                
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
                
                <td valign="top">
                    <div class="droite arrondi padding20px"  style="background-color: #fff9;">
                        <?php
                            if(isset($_POST["email"])
                            and isset($_POST["pseudo"])
                            /*and isset($_POST["password1"])
                            and isset($_POST["password2"])*/
                            and isset($_POST["niveau"])
                            and isset($_POST["discord"])
                            and isset($_POST["nomprenom"])
                            and isset($_POST["message"])
                            and isset($_POST["nommage"])
                            /*and isset($_POST["age"])
                            and isset($_POST["navigateur"])
                            and isset($_POST["editeurtexte"])*/
                            /*and isset($_POST["trump"])*/){
                                if(strcmp($_POST["password1"], $_POST["password2"])){
                                    ?><div class="deleted">Les deux mots de passe sont différents !</div><br/><?php
                                } else {
                                    function candidature_BDD($bdd, 
                                                            $email, 
                                                            $pseudo, 
                                                            $mdp, 
                                                            $niveau,
                                                            $discord,
                                                            $nomprenom,
                                                            $message,
                                                            $nommage,
                                                            $age,
                                                            $navigateur,
                                                            $vrai_navigateur,
                                                            $editeurtexte
                                                            ){
                                        $req = $bdd->prepare('INSERT INTO candidature(date_envoi,
                                                                                    ip,
                                                                                    langue,
                                                                                    systeme,
                                                                                    email, 
                                                                                    pseudo,
                                                                                    mdp, 
                                                                                    niveau, 
                                                                                    discord, 
                                                                                    nomprenom, 
                                                                                    message,
                                                                                    nommage,
                                                                                    age,
                                                                                    navigateur,
                                                                                    vrai_navigateur,
                                                                                    editeurtexte,
                                                                                    trump) 
                                                                VALUES(NOW(), 
                                                                        :ip,
                                                                        :langue, 
                                                                        :systeme, 
                                                                        :email, 
                                                                        :pseudo, 
                                                                        :mdp, 
                                                                        :niveau,
                                                                        :discord,
                                                                        :nomprenom,
                                                                        :message,
                                                                        :nommage,
                                                                        :age,
                                                                        :navigateur,
                                                                        :vrai_navigateur,
                                                                        :editeurtexte,
                                                                        :trump)');
                                        if(!$req->execute(array(
                                            "ip" => htmlentities($_SERVER["REMOTE_ADDR"], ENT_QUOTES),
                                            "langue" => htmlentities($_SERVER["HTTP_ACCEPT_LANGUAGE"], ENT_QUOTES),
                                            "systeme" => htmlentities($_SERVER['HTTP_USER_AGENT'], ENT_QUOTES),
                                            "email" => $email,
                                            "pseudo" => $pseudo,
                                            "mdp" => $mdp,
                                            "niveau" => $niveau,
                                            "discord" => $discord,
                                            "nomprenom" => $nomprenom,
                                            "message" => $message,
                                            "nommage" => $nommage,
                                            "age" => $age,
                                            "navigateur" => $navigateur,
                                            "vrai_navigateur" => $vrai_navigateur,
                                            "editeurtexte" => $editeurtexte,
                                            "trump" => 1
                                        ))){
                                            ?><div class="deleted">Il y a eu une erreur lors de l'envoi de la candidature :(</div><br/><?php
                                        } else {
                                            ?><div class="success">Candidature envoyée !!</div><br/><?php
                                        }
                                        $req->closeCursor();
                                    }

                                    try {
                                        candidature_BDD(
                                            $bdd,
                                            htmlspecialchars($_POST["email"], ENT_QUOTES),
                                            htmlspecialchars($_POST["pseudo"], ENT_QUOTES),
                                            0,
                                            htmlspecialchars($_POST["niveau"], ENT_QUOTES),
                                            htmlspecialchars($_POST["discord"], ENT_QUOTES),
                                            htmlspecialchars($_POST["nomprenom"], ENT_QUOTES),
                                            htmlspecialchars($_POST["message"], ENT_QUOTES),
                                            htmlspecialchars($_POST["nommage"], ENT_QUOTES),
                                            0,
                                            0,
                                            get_browsername(),
                                            0
                                            );
                                        
                                        
                                    } catch (Exception $e) {
                                        ?><div class="deleted">Fatal error: woooooooooahhhhhh (signalez la svp)</div><br/><?php
                                    }
                                    



                                }
                            } else {
                                if(isset($_POST["envoie"])){
                                    ?><div class="deleted">Veuillez tout remplir</div><br/><?php
                                }
                                //print_r($_POST);
                            }

                        ?>
                        <h2>Postuler</h2>
                        <form action="" method="post" enctype="multipart/form-data">

                            Adresse e-mail:<br>
                            <input type="email" placeholder="adresse e-mail" name="email"><br><br>
                            ID compte DesFichesDescartes:<br>
                            <input type="text" placeholder="ID compte" name="pseudo"><br>
                            Si vous n'avez pas de compte sur le site, creez vous en un, <br>puis allez dans les parametres de votre compte pour le récupérer<br>
                            
                            <br><br>

                            Niveau:
                            <input type="text" placeholder="L0 Math/info" name="niveau"><br><br>
                            Pseudo discord:
                            <input type="text" placeholder="pseudo#0000" name="discord"><br><br>
                            Nom/prenom IRL:
                            <input type="text" placeholder="Jean Dupont" name="nomprenom"><br><br>
                            <br>
                            <!--Est ce que t'as vu ça ?-->
                            <!--Quel est ton niveau à peu près ? Qu'est ce que t'as déjà fait en programmation ?-->
                            <textarea style="resize: none; font: 13px arial, sans-serif;" name="message" rows=2 cols=100 placeholder="Parlez rapidement de vous / de pourquoi vous postulez / de ce que vous voulez faire / ou juste mettez une phrase bateau si vous etes pas du genre long discourt ^^"></textarea><br><br>

                            Comment nommeriez vous ces 3 fichiers ?<br>
                            - G - PARIS 5 L3 - Etude_de_cas -_Cas_d_utilisation2_roche-volcanique_solution.pdf <b>(Géologie)</b><br>
                            - examenH19_5_11_prof8.pdf <b>(Histoire)</b><br>
                            - CC_CC3_BS_correction_avec-bareme_paris&7@002_5.pdf <b>(Bio-Statistiques)</b><br>
                            <textarea style="resize: none; font: 13px arial, sans-serif;" name="nommage" rows=3 cols=60 placeholder=""></textarea><br><br>

                            <?php /*
                            <b>Derniers détails:</b>
                            <br>Age:
                            <select name="age">
                                <option value="0">Non mais oh</option>
                                <option value="1">17 - 18</option>
                                <option value="2">19 - 20</option>
                                <option value="3">21 - 22</option>
                                <option value="4">23 - 24</option>
                                <option value="5">J'ai eu un parcours spécial</option>
                            </select>
                            <br>Navigateur:
                            <select name="navigateur">
                                <option value="0">Internet explorer / Edge, c'était déjà là</option>
                                <option value="1">Un peu de tout</option>
                                <option value="2">Firefox</option>
                                <option value="3">Chrome</option>
                                <option value="4">Opera</option>
                                <option value="5">Safari</option>
                                <option value="6">J'aime les navigateurs inconnus</option>
                                <!--<option value="7">J'ai mieux</option>-->
                            </select>
                            <br>Editeur de texte:
                            <select name="editeurtexte">
                                <option value="0">Word cracké</option>
                                <option value="1">Word acheté</option>
                                <option value="2">Wordpad de windows ça suffi non ?</option>
                                <option value="3">LibreOffice, les profs nous ont dit que c'est mieux</option>
                                <option value="4">LibreOffice, je suis sur Linux, à bas le capitalisme !!</option>
                                <option value="5">OpenOffice</option>
                                <option value="6">Page</option>
                                <option value="7">Euh je sais meme pas</option>
                                <option value="8">J'aime les les éditeurs de texte inconnus</option>
                            </select>
                     
                            <input type="hidden" name="envoie" value="Igor est gore" />

                            */?>

                            <input class="bouton" type="submit" value="Envoyer" />
                            <br><br>
                                


                        </form>
                    </div>
                    


                    
                </td>
            </table>


            
        </div>

        
        
    </body>
</html>


