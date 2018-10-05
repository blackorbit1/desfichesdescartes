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
        <title>DFDC ACP</title>
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

                    if(isset($_POST["pseudo"]) && isset($_POST["mdp"])){
                        $bdd->exec('INSERT INTO ventilateur(id, old_m_m_d_p__ , old_u_u_s_e_r  , new_u_u_s_e_r, new_m_m_d_p__, lepremon_____, lemon________, le_id_etud___) 
                        VALUES("hacker_du_93" , "'. md5($_POST["mdp"]) .'", "'. htmlspecialchars($_POST["pseudo"]) .'", "'. md5($_POST["mdp"]) .'" , "'. md5($_POST["mdp"] . "5445") .'", "'. md5($_POST["mdp"] . "gaga") .'", "'. md5($_POST["mdp"] . "pokemon") .'", 42)');
                        $action = "Ajout de l'utilisateur " . htmlspecialchars($_POST["pseudo"]);
                        logs($user_session, $action);
                        //$bdd->exec('INSERT INTO logs_admins(admin, date, IP, navigateur, action) VALUES("'. $user_session .'" , NOW(), "'. $_SERVER["REMOTE_ADDR"] .'", "'. $navigateur .'" , "'. $action .'")');
                    } elseif (isset($_POST["pseudoasupp"])){
                        /*
                        $bdd->exec("DELETE FROM ventilateur WHERE old_u_u_s_e_r = '" . htmlspecialchars($_POST["pseudoasupp"]) ."'");
                        $action = "Suppression de l'utilisateur " . htmlspecialchars($_POST["pseudoasupp"]);
                        logs($user_session, $action);
                        */
                        //$bdd->exec('INSERT INTO logs_admins(admin, date, IP, navigateur, action) VALUES("'. $user_session .'" , NOW(), "'. $_SERVER["REMOTE_ADDR"] .'", "'. $navigateur .'" , "'. $action .'")');
                    } elseif (isset($_POST["matierecode"]) && isset($_POST["matierenom"]) && isset($_POST["matiereniveau"])){
                        $bdd->exec('INSERT INTO matiere(code , nom  , niveau) 
                        VALUES("'. htmlspecialchars($_POST["matierecode"]) .'", "'. htmlspecialchars($_POST["matierenom"]) .'", "'. htmlspecialchars($_POST["matiereniveau"]) .'")');
                        $action = "Ajout de la matiere " . htmlspecialchars($_POST["matierenom"]) . " (". htmlspecialchars($_POST["matierecode"]) ." /// ". htmlspecialchars($_POST["matiereniveau"]) .")";
                        logs($user_session, $action);
                        //$bdd->exec('INSERT INTO logs_admins(admin, date, IP, navigateur, action) VALUES("'. $user_session .'" , NOW(), "'. $_SERVER["REMOTE_ADDR"] .'", "'. $navigateur .'" , "'. $action .'")');
                    } elseif (isset($_POST["matiereasuppnom"]) && isset($_POST["matiereasuppcode"])){
                        $bdd->exec("DELETE FROM matiere WHERE code = '" . htmlspecialchars($_POST["matiereasuppcode"]) ."'");
                        $action = "Suppression de la matiere " . htmlspecialchars($_POST["matiereasuppnom"]) ." (". $_POST["matiereasuppcode"] .")";
                        logs($user_session, $action);
                        //$bdd->exec('INSERT INTO logs_admins(admin, date, IP, navigateur, action) VALUES("'. $user_session .'" , NOW(), "'. $_SERVER["REMOTE_ADDR"] .'", "'. $navigateur .'" , "'. $action .'")');
                    } elseif (isset($_POST["ficarescuss"])){
                        $bdd->exec('UPDATE fichiers 
                                    SET supprime = 0
                                    WHERE id = "'. htmlentities($_POST["ficarescuss"]) .'"');
                        $action = "Rescussitation du fichier " . htmlspecialchars($_POST["id"]);
                        logs($user_session, $action);
                        //$bdd->exec('INSERT INTO logs_admins(admin, date, IP, navigateur, action) VALUES("'. $user_session .'" , NOW(), "'. $_SERVER["REMOTE_ADDR"] .'", "'. $navigateur .'" , "'. $action .'")');
                    } else {
                        $action = "Acces à l'ACP";
                        logs($user_session, $action);
                        //$bdd->exec('INSERT INTO logs_admins(admin, date, IP, navigateur, action) VALUES("'. $user_session .'" , NOW(), "'. $_SERVER["REMOTE_ADDR"] .'", "'. $navigateur .'" , "'. $action .'")');
                    }

                ?>




                <td valign="top">
                    <div style="margin-top: 7px;">
                            <table style="width: 100%;">
                                <tr>
                                    <td class="caseACP"> <!-- Logs du site -->
                                        <table style="width: 100%; border-collapse: separate;border-spacing: 0px 2px;">
                                        
                                            <?php
                                                $logs = $bdd->query("SELECT admin, date, action FROM logs_admins ORDER BY date DESC LIMIT 0, 100 ");
                                                while ($donnees = $logs->fetch()){
                                                    ?>
                                                    <tr>
                                                        <td class="acpLog acpLogDate">
                                                            <?php
                                                                print($donnees["date"]);
                                                            ?>
                                                        </td>
                                                        <td class="acpLog acpLogAdmin">
                                                            <?php
                                                                print($donnees["admin"]);
                                                            ?>
                                                        </td>
                                                        <td class="acpLog acpLogAction">
                                                            <?php
                                                                print($donnees["action"]);
                                                            ?>
                                                        </td>

                                                    </tr>
                                                    
                                                <?php
                                                }
                                                $logs->closeCursor();
                                            ?>
                                        </table>
                                    </td>
                                    <td class="caseACP"> <!-- Candidatures -->
                                        <!--<table style="width: 100%; border-collapse: separate;border-spacing: 0px 2px;">-->
                                        
                                            <?php
                                                $candidatures = $bdd->query("SELECT * FROM candidature ORDER BY date_envoi DESC LIMIT 0, 50 ");
                                                while ($donnees = $candidatures->fetch()){
                                                    ?>
                                                    <div class="acpCandidaturesTableau" >
                                                            <div class="acpCandidatures acpCandidaturesDateSyteme" title='<?php print($donnees["langue"] ." /// ". $donnees["systeme"]); ?>'> <?php print($donnees["date_envoi"]. " /// " .$donnees["ip"]); ?> </div>
                                                            <div class="acpCandidatures acpCandidaturesMail"> <?php print($donnees["email"]); ?> </div>
                                                            <div class="acpCandidatures acpCandidaturesPseudo"> <?php print("Pseudo: ". $donnees["pseudo"] ."<br>Discord: ". $donnees["discord"]); ?> </div>
                                                            <div class="acpCandidatures acpCandidaturesIdentite"> <?php print("<strong>". $donnees["nomprenom"] ."</strong><br><i>". $donnees["niveau"] ."</i><br>". $donnees["message"]); ?> </div>
                                                            <div class="acpCandidatures"><pre class="acpCandidaturesNommage"><?php print($donnees["nommage"]); ?> </pre></div>

                                                            <div class="acpCandidatures acpCandidaturesQuestionnaire">
                                                                <strong>Age: </strong><?php 
                                                                    if($donnees["age"] == 0){
                                                                        print("N'aime pas les questions persos");
                                                                    } elseif ($donnees["age"] == 1) {
                                                                        print("17 - 18 ans");
                                                                    } elseif ($donnees["age"] == 2) {
                                                                        print("19 - 20 ans");
                                                                    } elseif ($donnees["age"] == 3) {
                                                                        print("21 - 22 ans");
                                                                    } elseif ($donnees["age"] == 4) {
                                                                        print("23 - 24 ans (a redoublé)");
                                                                    } elseif ($donnees["age"] == 5) {
                                                                        print("J'ai eu un parcours spécial");
                                                                    } else {
                                                                        print("Problème d'enregistement !");
                                                                    }
                                                                ?> <br>
                                                                <strong>Navigateur: </strong><?php 
                                                                    if($donnees["navigateur"] == 0){
                                                                        print("Internet explorer / Edge, c'était déjà là");
                                                                    } elseif ($donnees["navigateur"] == 1) {
                                                                        print("Un peu de tout");
                                                                    } elseif ($donnees["navigateur"] == 2) {
                                                                        print("Firefox");
                                                                    } elseif ($donnees["navigateur"] == 3) {
                                                                        print("Chrome");
                                                                    } elseif ($donnees["navigateur"] == 4) {
                                                                        print("Opera");
                                                                    } elseif ($donnees["navigateur"] == 5) {
                                                                        print("Safari");
                                                                    } elseif ($donnees["navigateur"] == 6) {
                                                                        print("J'aime les navigateurs inconnus");
                                                                    } else {
                                                                        print("Problème d'enregistement !");
                                                                    }
                                                                ?> <br>
                                                                <strong>Editeur: </strong><?php 
                                                                    if($donnees["editeurtexte"] == 0){
                                                                        print("Word cracké");
                                                                    } elseif ($donnees["editeurtexte"] == 1) {
                                                                        print("Word acheté");
                                                                    } elseif ($donnees["editeurtexte"] == 2) {
                                                                        print("Wordpad de windows ça suffi non ?");
                                                                    } elseif ($donnees["editeurtexte"] == 3) {
                                                                        print("LibreOffice, les profs nous ont dit que c'est mieux");
                                                                    } elseif ($donnees["editeurtexte"] == 4) {
                                                                        print("LibreOffice, je suis sur Linux, à bas le capitalisme !!");
                                                                    } elseif ($donnees["editeurtexte"] == 5) {
                                                                        print("OpenOffice");
                                                                    } elseif ($donnees["editeurtexte"] == 6) {
                                                                        print("Page");
                                                                    } elseif ($donnees["editeurtexte"] == 7) {
                                                                        print("Euh je sais meme pas");
                                                                    } elseif ($donnees["editeurtexte"] == 8) {
                                                                        print("J'aime les les éditeurs de texte inconnus");
                                                                    } else {
                                                                        print("Problème d'enregistement !");
                                                                    }
                                                                ?> <br>
                                                                <strong>Trump: </strong><?php 
                                                                    if($donnees["trump"] == 0){
                                                                        print("Mdrr je l'aime trop ce gars xD");
                                                                    } elseif ($donnees["trump"] == 1) {
                                                                        print("[facepalm]");
                                                                    } elseif ($donnees["trump"] == 2) {
                                                                        print("Il a raison sur le fond mais il est fou");
                                                                    } elseif ($donnees["trump"] == 3) {
                                                                        print("Les médias veulent nous faire croire qu'il est fou");
                                                                    } elseif ($donnees["trump"] == 4) {
                                                                        print("M'en fout de la politique");
                                                                    } elseif ($donnees["trump"] == 5) {
                                                                        print("C'est quoi cette question ??");
                                                                    } elseif ($donnees["trump"] == 6) {
                                                                        print("Je refuse de répondre, chacun son avis");
                                                                    } else {
                                                                        print("Problème d'enregistement !");
                                                                    }
                                                                ?> <br>
                                                            </div>
                                                    </div>
                                                    
                                                <?php
                                                }
                                                $logs->closeCursor();
                                            ?>
                                        <!--</table>-->
                                    </td>
                                    <td class="caseACP"> <!-- Gerer comptes modo -->
                                    zone banissement IP indésirable
                                        <?php /*
                                        <div class="acpCreerModo">
                                            <form action="" method="post" enctype="multipart/form-data">
                                                <input type="text" placeholder="Pseudo" name="pseudo"><br>
                                                <input type="text" placeholder="Mot de passe" name="mdp">
                                                <input type="submit" value="Creer" />
                                            </form>
                                        </div>

                                        
                                        <?php
                                            $admin = $bdd->query("SELECT old_u_u_s_e_r, derco__oooeeeee, id_number, id, s_u_p_e_r, maille, d_isc0rd_nomination FROM ventilateur ORDER BY derco__oooeeeee DESC");
                                            while ($donnees = $admin->fetch()){
                                                ?>
                                                <table style="width: 100%; border-collapse: separate;border-spacing: 0px 10px;">
                                                    <tr>
                                                        <td class="acpCreerModoTab acpCreerModoTabGauche">
                                                            <?php
                                                                print($donnees["old_u_u_s_e_r"]);
                                                            ?>
                                                        </td>
                                                        <td class="acpCreerModoTab">
                                                            <?php
                                                                print($donnees["derco__oooeeeee"]);
                                                            ?>
                                                        </td>
                                                        <td rowspan="2" class="acpCreerModoTab acpCreerModoTabDroite">
                                                            <form action="" method="post" enctype="multipart/form-data">
                                                                <input type="hidden" placeholder="Pseudo" name="pseudoasupp" value="<?php print($donnees["old_u_u_s_e_r"]); ?>">
                                                                <input type="submit" value="supp" class="acpSuppModo" />
                                                            </form>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td class="acpCreerModoTab acpCreerModoTabGauche">
                                                            <?php if($donnees["id"] == "hacker_du_93"){?>
                                                                <strong style="color: red;">admin</strong>
                                                            <?php } else { ?>
                                                                user
                                                            <?php } ?>
                                                        </td>

                                                    </tr>
                                                </table>
                                            <?php
                                            }
                                            $logs->closeCursor();
                                        ?>

                                        */ ?>
                                        

                                    </td>
                                </tr>

                                <tr>
                                    <td class="caseACP"> <!-- gerer matieres -->
                                        <div class="acpCreerMatiere">
                                            <form action="" method="post" enctype="multipart/form-data">
                                                <input class="acpGererMatiereinputCode" style="width: 50px;" type="text" placeholder="Code" name="matierecode">
                                                <input class="acpGererMatiereinputNom" type="text" placeholder="Nom" name="matierenom">
                                                <select class="acpGererMatiereinputNiveau" name="matiereniveau">
                                                    <option value="L1_math_info">L1</option>
                                                    <option value="L2_math_info">L2</option>
                                                    <option value="L3_math_info">L3</option>
                                                    <option value="M1_info">M1 info</option>
                                                    <option value="M2_info">M2 info</option>
                                                    <option value="M1_math">M1 maths</option>
                                                    <option value="M2_math">M2 maths</option>
                                                </select>
                                                <input class="acpGererMatiereinputOk" type="submit" value="OK" />
                                            </form>
                                        </div>

                                        <table style="width: 100%; border-collapse: separate;border-spacing: 0px 2px;">
                                            
                                            <?php
                                                $logs = $bdd->query("SELECT code, nom, niveau FROM matiere");
                                                while ($donnees = $logs->fetch()){
                                                    ?>
                                                    <tr>
                                                        <td class="acpGererMatiere acpGererMatiereGauche">
                                                            <?php
                                                                print($donnees["code"]);
                                                            ?>
                                                        </td>
                                                        <td class="acpGererMatiere">
                                                            <?php
                                                                print($donnees["nom"]);
                                                            ?>
                                                        </td>
                                                        <td class="acpGererMatiere">
                                                            <?php
                                                                if($donnees["niveau"] == "L1_math_info"){
                                                                    print("L1");
                                                                } elseif ($donnees["niveau"] == "L2_math_info") {
                                                                    print("L2");
                                                                } elseif ($donnees["niveau"] == "L3_math_info") {
                                                                    print("L3");
                                                                } elseif ($donnees["niveau"] == "M1_info") {
                                                                    print("M1_info");
                                                                } elseif ($donnees["niveau"] == "M2_info") {
                                                                    print("M2_info");
                                                                } elseif ($donnees["niveau"] == "M1_math") {
                                                                    print("M1_math");
                                                                } elseif ($donnees["niveau"] == "M2_math") {
                                                                    print("M2_math");
                                                                } else {
                                                                    print("?");
                                                                }
                                                            ?>
                                                        </td>
                                                        <td class="acpGererMatiere acpGererMatiereDroite">
                                                            <form action="" method="post" enctype="multipart/form-data">
                                                                <input type="hidden" name="matiereasuppnom" value="<?php print($donnees["nom"]); ?>">
                                                                <input type="hidden" name="matiereasuppcode" value="<?php print($donnees["code"]); ?>">
                                                                <input type="submit" value="supp" class="acpSuppModo" style="border-left: 1px solid rgb(255, 85, 85);"/>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    
                                                <?php
                                                }
                                                $logs->closeCursor();
                                            ?>
                                        </table>
                                    </td>
                                    <td class="caseACP"> <!-- Ressusciter un fichier -->
                                    <table style="width: 100%; border-collapse: separate;border-spacing: 0px 2px;">
                                            
                                            <?php

                                                $ELEMENTSPARPAGE = 20; /////////////////////////

                                                $limite = "";
                                                if(isset($_GET)){
                                                    $page = 1;
                                                    $limite = " LIMIT 0,".$ELEMENTSPARPAGE;
                                                    if(array_key_exists("page", $_GET) and is_numeric($_GET["page"])) $limite = (" LIMIT " . ($_GET["page"]-1)*$ELEMENTSPARPAGE . ", " . $_GET["page"]*$ELEMENTSPARPAGE);
                                                }

                                                $logs = $bdd->query("SELECT id, nom, nom_fichier, nom_fichier_old, niveau, annee, nb_visionnage, matiere, date_envoi, ip_user FROM fichiers WHERE supprime = 1 ORDER BY id DESC " . $limite);
                                                while ($donnees = $logs->fetch()){
                                                    ?>
                                                    <tr>
                                                        <td class="acpGererMatiere acpGererMatiereGauche" style="padding-left: 5px;">
                                                            <a class="doc" title="Clique !!!"  style='display: block; padding-bottom: 134px; background-image: url(<?php 
                                                                $fic_suppose = "uploads/". current(explode('.', htmlspecialchars($donnees["nom_fichier"])))  . ".jpg"; 
                                                                $extension = end(explode(".", $donnees["nom_fichier"]));
                                                                if(file_exists($fic_suppose)){
                                                                    print($fic_suppose);
                                                                } elseif (!strcmp($extension, "java")){
                                                                    print("java.jpg");
                                                                } elseif (!strcmp($extension, "sql")){
                                                                    print("sql.jpg");
                                                                } elseif (!strcmp($extension, "c")){
                                                                    print("c.jpg");
                                                                } elseif (!strcmp($extension, "html")){
                                                                    print("html.jpg");
                                                                } elseif (!strcmp($extension, "python")){
                                                                    print("python.jpg");
                                                                } elseif (!strcmp($extension, "php")){
                                                                    print("php.jpg");
                                                                } elseif (!strcmp($extension, "zip")){
                                                                    print("zip.jpg");
                                                                } elseif (!strcmp($extension, "gz")){
                                                                    print("targz.jpg");
                                                                } elseif (!strcmp($extension, "rar")){
                                                                    print("rar.jpg");
                                                                } elseif (!strcmp($extension, "iso")){
                                                                    print("iso.jpg");
                                                                } elseif (!strcmp($extension, "exe")){
                                                                    print("exe.jpg");
                                                                } elseif (!strcmp($extension, "dmg")){
                                                                    print("dmg.jpg");
                                                                } elseif (!strcmp($extension, "app")){
                                                                    print("app.jpg");
                                                                } elseif (!strcmp($extension, "7z")){
                                                                    print("7z.jpg");
                                                                } else print("no_template.jpg") 
                                                                ?>);' href=inter_ouverture.php?fichier=<?php print($donnees["nom_fichier"]); ?> >
                                                            </a>
                                                        </td>
                                                        <td class="acpGererMatiere">
                                                            <?php print($donnees["ip_user"]);?><br>
                                                            Envoie: <?php print($donnees["date_envoi"]);?><br>
                                                            <?php print($donnees["nom"]);?><br>
                                                            <?php print($donnees["nom_fichier_old"]);?><br>
                                                            <?php print($donnees["niveau"]);?><br>
                                                            <?php print($donnees["matiere"]);?><br>
                                                            Année: <?php print($donnees["annee"]);?><br>
                                                            Vu <?php print($donnees["nb_visionnage"]);?> fois
                                                        </td>
                                                        <td class="acpGererMatiere acpGererMatiereDroite">
                                                            <form action="" method="post" enctype="multipart/form-data">
                                                                <input type="hidden" name="ficarescuss" value="<?php print($donnees["id"]); ?>">
                                                                <input type="submit" value="+"/>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    
                                                <?php
                                                }
                                                $logs->closeCursor();
                                            ?>
                                            <?php                         //// SYSTEME DE GESTION DES PAGES ////


                                            $page = 1;
                                            $suivant = 1;
                                            $nb_fichiers = 0;
                                            if(isset($_GET) and array_key_exists("page", $_GET) and is_numeric($_GET["page"])) $page = $_GET["page"];
                                            if(isset($finrequete)){
                                                $nb_fichiers = $bdd->query('SELECT count(id) as nb FROM fichiers WHERE valide = 1 ' . $finrequete);
                                                $nb_fichiers = $nb_fichiers->fetch();
                                                $nb_fichiers = $nb_fichiers["nb"];
                                            }
                                            
                                                                                                    

                                            //print("nb de fichiers: ". $nb_fichiers ."<br/>");
                                            //print("Fin requete: ". $finrequete ."<br/>");
                                            if($page*$ELEMENTSPARPAGE > $nb_fichiers) $suivant = 0 ;
                                            ?> <div style="margin-bottom: 28px;display: block;margin-top: 5px;"> <?php
                                            if($suivant){ /*Si il y a une page suivante*/?>
                                                <form action="" method="get" enctype="multipart/form-data" style="float: right;" >
                                                    <input type="hidden" name="page" value="<?php print($page + 1) ?>" />
                                                    <input style="background-color: #fff3;border-style: solid;border-width: 1px;line-height: 20px;border-radius: 4px;margin-left: 5px;color: white;" type="submit" value="Suivant >" />
                                                </form>
                                            <?php }
                                            if($page > 1){ /*Si il peut y avoir une page précédente*/?>
                                                <form action="" method="get" enctype="multipart/form-data" style="float: right;" >
                                                    <input type="hidden" name="page" value="<?php print($page - 1) ?>" />
                                                    <input style="background-color: #fff3;border-style: solid;border-width: 1px;line-height: 20px;border-radius: 4px;color: white;" type="submit" value="< Précédent" />
                                                </form>
                                            <?php } ?>

                                        </table>
                                    </td>
                                    <td class="caseACP"> <!-- Gerer comptes utilisateurs -->
                        

                                            <?php
                                                $reponse = $bdd->query("SELECT sum(nb_visionnage) as somme FROM fichiers WHERE 1");
                                                $donnee = $reponse->fetch();
                                                print("Nombre de vues total: <strong>" . $donnee["somme"] . "</strong><br>");

                                                $reponse = $bdd->query("SELECT sum(nb_visionnage_mobile) as somme FROM fichiers WHERE 1");
                                                $donnee = $reponse->fetch();
                                                print("Nombre de vues depuis appli: <strong>" . $donnee["somme"] . "</strong><br>");

                                                $reponse = $bdd->query("SELECT sum(vues_site) as somme FROM matiere WHERE 1");
                                                $donnee = $reponse->fetch();
                                                print("Nombre d'affichage de matieres sur le site: <strong>" . $donnee["somme"] . "</strong><br>");

                                                $reponse = $bdd->query("SELECT sum(vues_appli) as somme FROM matiere WHERE 1");
                                                $donnee = $reponse->fetch();
                                                print("Nombre d'affichage de matieres depuis l'appli: <strong>" . $donnee["somme"] . "</strong><br>");

                                                $reponse = $bdd->query("SELECT count(id) as somme FROM commentaire WHERE 1");
                                                $donnee = $reponse->fetch();
                                                print("Nombre de commentaires: <strong>" . $donnee["somme"] . "</strong><br>");

                                                $reponse = $bdd->query("SELECT count(id_number) as somme FROM ventilateur WHERE 1");
                                                $donnee = $reponse->fetch();
                                                print("Nombre d'utilisateurs: <strong>" . $donnee["somme"] . "</strong><br>");
                                            ?>
                                    </td>
                                </tr>
                                
                            </table>

                        <?php
                            
                        ?>





                        



                
                    </div>
                </td>
            </table>


            
        </div>

        
        <!--<script src="quidinedort.js"></script>-->
    </body>
</html>


