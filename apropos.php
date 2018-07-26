<?php
session_cache_limiter('private_no_expire, must-revalidate');
session_start();
include_once("test_session.php");
include_once("navigateur.php");
include_once("compteur_vues.php");

if ($id_session == "hacker_du_93" and isset($_POST["supprimer"]) and is_numeric($_POST["id"])){
    $bdd->exec("DELETE FROM avis_recherche WHERE id = " . $_POST["id"]);
}

// nb de pages max
$ELEMENTSPARPAGE = 100; //  <<<<< CHANGER LE SYSTEME
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
                            <dl>
                                <dt>A propos du site</dt>
                                <dd>Ce site est basé sur le partage et a pour but d’aider dans les révisions en mettant à disposition un maximum de documents sans limitation de vues, ou restriction en fonction des niveaux. Il permet aussi d’aider les étudiants dans le choix des matières lors des inscriptions pédagogiques en leur permettant d’avoir une idée concrète du contenu de la matière et donc d’éviter certains échecs. <br> Attention : ce site ne peut en rien être une substitution à un suivi assidu des cours et des TDs.</dd>
                                <br>
                                <dt>Informations légales :</dt>
                                <dd>Article L 122-5 du code de la propriété intellectuelle Lorsque l'œuvre a été divulguée, l'auteur ne peut interdire : 
                                    <br>[...]
                                    <br>3° […] e) La représentation ou la reproduction d'extraits d'œuvres, sous réserve des œuvres conçues à des fins pédagogiques, des partitions de musique et des œuvres réalisées pour une édition numérique de l'écrit, à des fins exclusives d'illustration dans le cadre de l'enseignement et de la recherche, à l'exclusion de toute activité ludique ou récréative, dès lors que le public auquel cette représentation ou cette reproduction est destinée est composé majoritairement d'élèves, d'étudiants, d'enseignants ou de chercheurs directement concernés, que l'utilisation de cette représentation ou cette reproduction ne donne lieu à aucune exploitation commerciale et qu'elle est compensée par une rémunération négociée sur une base forfaitaire sans préjudice de la cession du droit de reproduction par reprographie mentionnée à l'article L. 122-10 ;
                                    <br>[...]
                                    <br>8° La reproduction d'une œuvre et sa représentation effectuées à des fins de conservation ou destinées à préserver les conditions de sa consultation à des fins de recherche ou d'études privées par des particuliers, dans les locaux de l'établissement et sur des terminaux dédiés par des bibliothèques accessibles au public, par des musées ou par des services d'archives, sous réserve que ceux-ci ne recherchent aucun avantage économique ou commercial ;
                                </dd>
                                <br>
                                <dt>Comment demander le retrait d’un fichier ? </dt>
                                <dd>Si vous êtes un professeur et que vous souhaitez demander le retrait d’un document que vous avez vous même rédigé, veuillez nous envoyer un mail à desfichesdescartes@gmail.com contenant :
                                    <ul>
                                        <li>Un scan de votre demande écrite et signée de votre main </li>
                                        <li>Une photo de votre carte d’identité </li>
                                        <li>Une preuve que vous avez rédigé ce document si votre nom n’est pas précisé dans celui-ci </li>
                                    </ul>
                                    Votre demande sera traitée sous 1 mois et il pourra vous être demandé d’autres justificatifs si ceux fournis ne permettent pas de vous identifier complètement ou que la demande n’est pas claire.
                                <br>
                                <strong>A savoir:</strong>
                                Si le document retiré semble trop important d’un point de vue pédagogique, nous nous réservons le droit de rédiger un document nous-même reprenant l’intégralité des informations ou plus du document retiré.</dd>

                            </dl>
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


