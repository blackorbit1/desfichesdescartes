<?php
session_start();
include_once("test_session.php");
include_once("navigateur.php");

    if(isset($_POST["more_comments"]) && isset($_POST["matiere"]) && is_numeric($_POST["more_comments"])) { // Si plus de commentaires sont demandés
        $commentcount = 0;
        $req = $bdd->prepare('SELECT id, auteur, heure, message_modere, surbrillance FROM commentaire WHERE matiere = ? and supprime = 0 ORDER BY id DESC LIMIT '. (int) $_POST["more_comments"] .', '. ((int) $_POST["more_comments"]) + 2); // Envoi de la requete à la base de données
        if($req->execute(array($_POST["matiere"]))){
            while($commentaire = $req->fetch()){
                $reqAVATAR = $bdd->query("SELECT id, atavar_001 FROM ventilateur WHERE old_u_u_s_e_r = '". $commentaire["auteur"] ."'");
                $avatar = $reqAVATAR->fetch();
                ?>
                    <div class="commentaire" title="<?php print($commentaire["heure"]); ?>">
                        <img class="avatar" src="uploads/<?php print($avatar["atavar_001"]); ?>" alt="ziva ça bug">
                        <span class="pseudo" <?php if($avatar["id"] == "hacker_du_93") print("style='color: red;'") ?>><?php print($commentaire["auteur"]); ?></span>
                        <p style="margin: <?php print($tailleMargeCommentaire); ?>px; padding-left: 26px;">
                            <?php print(nl2br($commentaire["message_modere"]));/* CODE TEXTE --> avec nl2br() */ ?>
                        </p>
                        <?php
                            if($id_session == "hacker_du_93" || $_SESSION['pseudo'] == $commentaire["auteur"]){
                                ?>
                                    <form action="" method="post" enctype="multipart/form-data" style="display: inline;">
                                        <input type="hidden" name="supprimerCommentaire" value="<?php print($commentaire["id"]) ?>" />
                                        <input class="supprimerCommentaire" type="submit" value="X" title="Supprimer"/>
                                    </form>
                                <?php
                            }
                        ?>
                    </div>
                <?php
                $commentcount += 1;
            }
            if($commentcount >= 5){
                ?>
                    <form action="commentaires.php" method="post">
                        <input type="hidden" name="more_comments" value="<?php  ?>" />
                        <intut type="hidden" name="matiere" value="<?php print($_POST["matiere"]); ?>"
                        <p>
                            <input class="bouton" type="submit" value="Voir plus de commentaires">
                        </p>
                    </form>
                <?php
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