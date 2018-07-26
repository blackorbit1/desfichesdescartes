<?php
include_once("bdd.php");
include_once("navigateur.php");
include_once("logs.php");
$id_session = "hacker_du_92";



if(            isset($_POST["url"]) 
            && isset($_POST["nom"])
            && isset($_POST["annee"])
            && isset($_POST["type"])
            && isset($_POST["corrige"])
            && isset($_POST["matiere"])
            && isset($_POST["pseudo"])
            && isset($_POST["mdp"])){
    $req = $bdd->prepare('SELECT id FROM ventilateur WHERE old_u_u_s_e_r = ? and old_m_m_d_p__ = ?'); // Envoi de la requete à la base de données
    $req->execute(array($_POST["pseudo"], $_POST["mdp"]));
    $donnees = $req->fetch();
    $id_session = $donnees["id"];

    //print_r($_POST);
    //print((bool) $_POST["active"]);

    if($id_session == "hacker_du_93"){
        // === === === >> Get le navigateur du mec
        $navigateurrr = get_browsername();
        // === === === >> Get le poids du fichier
        if(isset(get_headers($_POST["url"])[4])){
            $poids = "";
            preg_match("#(\d+)#iu", get_headers($_POST["url"])[4], $poids);
            $poids = (int) $poids[1];
        } else {
            $poids = 0;
        }
        // === === === >> Get le nom du fichier
        $lenomdecefichier = "";
        preg_match("#([\w\d-_]+\.\w+)$#iu", $_POST["url"], $lenomdecefichier);
        $lenomdecefichier = $lenomdecefichier[1];


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
                                                        corrige,
                                                        externe,
                                                        valide) 
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
                                            :corrige,
                                            1,
                                            1)');
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
            //print($nom);
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


        //$action = ("Soumission du fichier: ". htmlentities($_POST["url"], ENT_QUOTES)) ;
        //$bdd->exec('INSERT INTO logs_admins(admin, date, IP, navigateur, action) VALUES("'. $_POST["pseudo"] .'" , NOW(), "'. htmlentities($_SERVER["REMOTE_ADDR"], ENT_QUOTES) .'", "'. $navigateurrr .'" , "'. $action .'")');
        $extention_fichier = end(explode('.', $_POST["url"]));
        if(in_array(end(explode('.', $_POST["url"])), $formats)){ // Si tout est bon
            //move_uploaded_file($_FILES['fichier']['tmp_name'][$i], 'uploads/' . basename($nomfichier_new));
            fichiers_BDD($bdd, $_POST["nom"], $_POST["url"], $lenomdecefichier, $poids, $extention_fichier, $navigateurrr, $niveau, $annee, $matiere, $type, $corrige);
            //print( $_POST["nom"]);
            ?><div class="deleted" style="text-align: center; border-radius: 5px; margin-top: 40px;background-color: rgba(9, 255, 0, 0.61);">Le fichier <strong><?php print(htmlspecialchars($lenomdecefichier, ENT_QUOTES)); ?></strong> a bien été ajouté !</div><br/><?php
            logs($_POST["pseudo"], "Soumission du fichier externe: ". htmlentities($_POST["url"], ENT_QUOTES));
            //print("Le fichier <strong>" . htmlspecialchars($lenomdecefichier, ENT_QUOTES) . "</strong> a bien été ajouté ! <br />");
            // Droits lecture ecriture pour admin et lecture pour user: 0604
            //chmod(("uploads/". basename($nomfichier_new)), 0604);
        } elseif (in_array($extention_fichier, $formatsDangereux)){ // Si fichier avec macros
            ?><div class="deleted" style="text-align: center; border-radius: 5px; margin-top: 40px;">Le fichier <strong><?php print(htmlspecialchars($lenomdecefichier, ENT_QUOTES)); ?></strong> a été <strong>refusé</strong>, il n'est pas assez sécurisé, veuillez changer son format et reessayer!</div><br/><?php
            logs($_POST["pseudo"], "Soumission refusée (fichier non sécurisé): ". htmlentities($_POST["url"], ENT_QUOTES));
            //print("Le fichier <strong>". htmlspecialchars($lenomdecefichier, ENT_QUOTES) ."</strong> a été <strong style='color: red;'>refusé</strong>, il n'est pas assez sécurisé, veuillez changer son format et reessayer<br/>");
        } elseif (in_array($extention_fichier, $formatsCompresses)) { // Si fichier compressé
            ?><div class="deleted" style="text-align: center; border-radius: 5px; margin-top: 40px;">Le fichier <strong><?php print(htmlspecialchars($lenomdecefichier, ENT_QUOTES)); ?></strong> a été <strong>refusé</strong>, pour les fichiers compressés, veuillez passer par la fonction d'upload</div><br/><?php
            logs($_POST["pseudo"], "Soumission refusée (fichier compressé): ". htmlentities($_POST["url"], ENT_QUOTES));
            //print("Le fichier <strong>". htmlspecialchars($lenomdecefichier, ENT_QUOTES) ."</strong> a été <strong style='color: red;'>refusé</strong>, pour les fichiers compressés, veuillez passer par la fonction d'upload<br/>");
        } else { // Si format inconnu
            ?><div class="deleted" style="text-align: center; border-radius: 5px; margin-top: 40px;">Le fichier <strong><?php print(htmlspecialchars($lenomdecefichier, ENT_QUOTES)); ?></strong> a été <strong>refusé</strong>, le site n'accepte pas des fichiers de type bizarres</div><br/><?php
            logs($_POST["pseudo"], "Soumission refusée (fichier type inconnu): ". htmlentities($_POST["url"], ENT_QUOTES));
            //print("Le fichier <strong>". htmlspecialchars($lenomdecefichier, ENT_QUOTES) ."</strong> a été <strong style='color: red;'>refusé</strong>, veuillez ne pas envoyer de fichiers de types bizarres<br/>");
        }


        if($extention_fichier == "pdf" or $extention_fichier == "png" or $extention_fichier == "JPG" or $extention_fichier == "jpeg"){
            $req = $bdd->query("SELECT id FROM fichiers  ORDER BY ID DESC LIMIT 1");
            $donnees = $req->fetch();

 
            $saveTo = "temp/". $lenomdecefichier;
            $fp = fopen($saveTo, 'w+');
            
            if($fp === false){
                throw new Exception('Erreur creation fic temporaire dans temp/');
            }
            
            $ch = curl_init($_POST["url"]);
            
            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_setopt($ch, CURLOPT_TIMEOUT, 20);
            curl_exec($ch);
            
            if(curl_errno($ch)){ // Si il y a une erreur lors de la requete
                throw new Exception(curl_error($ch));
            }
            
            //Get the HTTP status code.
            $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            if($statusCode == 200){
                //print('Downloaded!');
                $utilise = $saveTo;
                $rendu = 'uploads/'. $donnees['id'] .'.jpg';
                $requete = 'convert "'.$utilise.'[0]" "'.$rendu.'"';

                exec($requete, $output, $return);
                //print($requete);
                
                


                // Redimentionnement

                $source = imagecreatefromjpeg("uploads/". $donnees['id'] .".jpg");
                $destination = imagecreatetruecolor(150, 133);         

                $largeur_source = imagesx($source);
                $hauteur_source = imagesy($source);
                $largeur_destination = imagesx($destination);
                $hauteur_destination = imagesy($destination);

                imagecopyresampled($destination, $source, 0, 0, 0, 0, $largeur_destination, $hauteur_destination, $largeur_source, $hauteur_source);
                imagejpeg($destination, "uploads/". $donnees['id'] .".jpg");
            } else{
                print("Erreur lors du téléchargement du fichier: " . $statusCode);
                logs($_POST["pseudo"], "Erreur lors du téléchargement du fichier: ". htmlentities($_POST["url"], ENT_QUOTES));
            }

            
            fclose($fp);
            if(!rename($saveTo, ("temp/". bin2hex(random_bytes(22)) . "." . $extention_fichier))){
                print("==> Erreur lors de la suppression du fichier temporaire");
            }
        }

            
           

    } else {
        print("Erreur d'identification, contactez blackorbit");
        logs($_POST["pseudo"], "Erreur d'indentification lors de la soumission du fichier externe: ". htmlentities($_POST["url"], ENT_QUOTES) ." //// id_session = ". $id_session);
    }
} else {
    print("Erreur: Il manque des parametres");
    /*
    print("<pre>");
    print_r($_POST);
    print("</pre>");
    */
}

?>
