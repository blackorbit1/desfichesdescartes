<?php
session_start();
include_once("test_session.php");
include_once("navigateur.php");
include_once("logs.php");
include_once("analyseur.php");

    if(isset($_FILES)) { // Si le formulaire est envoyé
        // Creer une variable qui donne le navigateur de l'utilisateur
        $navigateurrr = get_browsername();

        $i = 0;

        // Tableau des formats autorisés ou non
        $formats = array("png", "jpg", "jpeg", "pdf", "doc", "docx", "dot", "dotx", 
                        "txt", "rtf", "pptx", "ppt", "potx", "pot", "ppsx", "pps", 
                        "xlsx", "xls", "xltx", "xlt", "xlsb", "odt", "ott", "uot",
                        "ods", "ots", "uos", "odp", "otp", "odg", "uop", "wps", "sxw",
                        "gif", "PNG", "JPG", "JPEG", "PDF", "DOC", "DOCX", "DOT",
                        "DOTX", "TXT", "XLS", "XLSX", "ODT", "PPT", "PPTX", "ODS",
                        "OTS", "ODP", "GIF", "sql", "c", "java", "o", "html", "csv", "CSV",
                        "R", "r", "RData", "rdata", "RDATA", "mp3", "mp4", "mov", "flv",
                        "h", "c", "ml");
        $formatsDangereux = array("docm", "dotm", "pptm", "potm", "ppsm", "xlsm", "xltm", "");
        $formatsCompresses = array("zip", "rar", "7z", "7Z", "tar", "gz", "bz2", "ace", "jar");

        
        // Fonction d'enregistrement de chaque fichiers dans la base de données
        function fichiers_BDD($bdd, 
                                $nom,
                                $nom_fichier, 
                                $nom_fichier_old,
                                $taille_fichier, 
                                $extension_fichier, 
                                $navigateur,
                                $niveau,
                                $annee,
                                $matiere,
                                $type,
                                $corrige){
            $req = $bdd->prepare('INSERT INTO fichiers(nom, 
                                                        nom_fichier, 
                                                        nom_fichier_old,
                                                        taille_fichier, 
                                                        extension_fichier, 
                                                        date_envoi, 
                                                        ip_user, 
                                                        navigateur, 
                                                        langue,
                                                        niveau,
                                                        annee,
                                                        matiere,
                                                        type,
                                                        corrige) 
                                    VALUES(:nom,
                                            :nom_fichier, 
                                            :nom_fichier_old,
                                            :taille_fichier, 
                                            :extension_fichier, 
                                            NOW(), 
                                            :ip_user, 
                                            :navigateur, 
                                            :langue,
                                            :niveau,
                                            :annee,
                                            :matiere,
                                            :type,
                                            :corrige)');
            $req->execute(array(
                "nom" => $nom,
                "nom_fichier" => $nom_fichier,
                "nom_fichier_old" => $nom_fichier_old,
                "taille_fichier" => $taille_fichier,
                "extension_fichier" => $extension_fichier,
                "ip_user" => $_SERVER["REMOTE_ADDR"],
                "navigateur" => $navigateur,
                "langue" => $_SERVER["HTTP_ACCEPT_LANGUAGE"],
                "niveau" => $niveau,
                "annee" => $annee,
                "matiere" => $matiere,
                "type" => $type,
                "corrige" => $corrige
            ));
            $req->closeCursor();
        }

        $niveau = "inconnu";
        $annee = "0";
        $matiere = "inconnu";
        $type = "inconnu";
        $corrige = 0;

        //if(array_key_exists("niveau", $_POST)) $niveau = htmlentities($_POST["niveau"]);
        if(array_key_exists("annee", $_POST) and is_numeric($_POST["annee"])) $annee = htmlentities($_POST["annee"]);
        if(array_key_exists("matiere", $_POST)) {
            $matiere = htmlentities($_POST["matiere"]);
            $req = $bdd->query("SELECT niveau FROM matiere WHERE code = '". $matiere ."'");
            $donnees = $req->fetch();
            $niveau = $donnees["niveau"];
        }
        if(array_key_exists("type", $_POST)) $type = htmlentities($_POST["type"]);
        if(array_key_exists("corrige", $_POST)) $corrige = 1;

        //print("le navigateur est : " . $navigateurrr); // Pour le debuggage

        // Acceptation ou non des fichiers et upload
        while(isset($_FILES) and array_key_exists("fichier", $_FILES) and $_FILES['fichier']['name'][$i] != NULL){ // Tant qu'il reste des fichies dans le tableau
            // On donne un nom en hash à chaques fichiers pour éviter les doublons au fil du temps
            $nomfichier_current = $_FILES['fichier']['name'][$i]; // $nomfichier_current <-- nom du fichier envoyé
            $bytes = random_bytes(22);
            $nomfichier_new = (bin2hex($bytes) . "." . htmlentities(end(explode('.', $nomfichier_current)))); // $nomfichier_new <-- nouveau nom pour enregistrement
            
            $action = ("Soumission du fichier: ". htmlentities($nomfichier_current, ENT_QUOTES)) ;
            logs(isset($_SESSION["pseudo"])?$_SESSION["pseudo"]:"inconnu", $action);
            //$bdd->exec('INSERT INTO logs_admins(admin, date, IP, navigateur, action) VALUES("testeur" , NOW(), "'. htmlentities($_SERVER["REMOTE_ADDR"], ENT_QUOTES) .'", "'. $navigateurrr .'" , "'. $action .'")');
            if(1 == 2){
                print("Le fichier <strong>". htmlspecialchars($_FILES['fichier']['name'][$i]) ."</strong> a été <strong style='color: red;'>refusé</strong>, quelqu'un ayant essayé de pirater le site à travers cette fonction, je préfere la désactiver le temps d'etre sur que tout soit bien sécurisé<br/>");
            } elseif(in_array(end(explode('.', $nomfichier_new)), $formats)){ // Si tout est bon
                $erreur_enregistrement = move_uploaded_file($_FILES['fichier']['tmp_name'][$i], 'uploads/' . basename($nomfichier_new));
                if(!$erreur_enregistrement){
                    print("<strong style='color: red;'>Erreur</strong> lors de l'enregistrement du fichier <strong>". htmlspecialchars($_FILES['fichier']['name'][$i]) ."</strong>, faites un screen et envoyez le à un admin<br/>");
                    logs(isset($_SESSION["pseudo"])?$_SESSION["pseudo"]:"inconnu", "Erreur lors de l'execution de la fonction move_uploaded_file() pour le fichier n°". $i . " : ". serialize($_FILES) . "////////// POST : " . serialize($_POST));
                } else {
                    $proposition_analyseur = convertisseur($_FILES['fichier']['name'][$i], $annee, $type);
                    print("Voici la proposition de l'analyseur : ". $proposition_analyseur . "<br>");
                    print("Nom fichier : ". $_FILES['fichier']['name'][$i] . "<br>");
                    print("Année : ". $annee . "<br>");
                    print("Type : ". $type . "<br>");
                    fichiers_BDD($bdd, $proposition_analyseur, $nomfichier_new, htmlspecialchars($_FILES['fichier']['name'][$i]), $_FILES['fichier']['size'][$i], end(explode('.', $nomfichier_new)), $navigateurrr, $niveau, $annee, $matiere, $type, $corrige);
                    print("L'envoi du fichier <strong>" . htmlspecialchars($_FILES['fichier']['name'][$i]) . "</strong> a bien été effectué ! <br />");
                    // Droits lecture ecriture pour admin et lecture pour user: 0604
                    chmod(("uploads/". basename($nomfichier_new)), 0604);
                }
            } elseif (in_array(end(explode('.', $nomfichier_new)), $formatsDangereux)){ // Si fichier avec macros
                print("Le fichier <strong>". htmlspecialchars($_FILES['fichier']['name'][$i]) ."</strong> a été <strong style='color: red;'>refusé</strong>, il n'est pas assez sécurisé, veuillez changer son format et reessayer<br/>");
            } elseif (in_array(end(explode('.', $nomfichier_new)), $formatsCompresses)) { // Si fichier compressé
                $erreur_enregistrement = move_uploaded_file($_FILES['fichier']['tmp_name'][$i], 'uploads/' . basename($nomfichier_new));
                if(!$erreur_enregistrement){
                    print("<strong style='color: red;'>Erreur</strong> lors de l'enregistrement du fichier <strong>". htmlspecialchars($_FILES['fichier']['name'][$i]) ."</strong>, faites un screen et envoyez le à un admin<br/>");
                    logs(isset($_SESSION["pseudo"])?$_SESSION["pseudo"]:"inconnu", "Erreur lors de l'execution de la fonction move_uploaded_file() pour le fichier n°". $i . " : ". serialize($_FILES) . "////////// POST : " . serialize($_POST));
                } else {
                    $proposition_analyseur = convertisseur($_FILES['fichier']['name'][$i], $annee, $type);
                    fichiers_BDD($bdd, $proposition_analyseur, $nomfichier_new, htmlspecialchars($_FILES['fichier']['name'][$i]), $_FILES['fichier']['size'][$i], end(explode('.', $nomfichier_new)), $navigateurrr, $niveau, $annee, $matiere, $type, $corrige);
                    print("L'envoi du fichier <strong>" . htmlspecialchars($_FILES['fichier']['name'][$i]) . "</strong> a bien été effectué, cependant, <br/>");
                    print("si vous voulez envoyer des fichiers par lot évitez de les compresser (beaucoup plus difficile à traiter pour nous)<br/>");
                    chmod(("uploads/". basename($nomfichier_new)), 0604);
                }
            } else { // Si format inconnu
                print("Le fichier <strong>". htmlspecialchars($_FILES['fichier']['name'][$i]) ."</strong> a été <strong style='color: red;'>refusé</strong>, veuillez ne pas envoyer de fichiers de types bizarres<br/>");
            }
            
            $i += 1;
        }
    } else {
        print("<strong>La table est plate</strong>");
        /*
        $action = "Ajout d un fichier: ";
        $bdd->exec('INSERT INTO logs_admins(admin, date, IP, navigateur, action) VALUES("testeur" , NOW(), "'. $_SERVER["REMOTE_ADDR"] .'", "'. $navigateur .'" , "'. $action .'")');
        */
    }  /*?>
    
    
    
    <?php*/
     // A SUPPRIMER AVANT LA SORTIE
    //print("<pre>"); print_r($_FILES); print("</pre>"); // IDEM Juste pour le debug
    //print("<pre>"); print_r($navigateurrr); print("</pre>");
?>