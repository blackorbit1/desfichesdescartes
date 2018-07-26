<div class="feedbacks" id="feedbacks">

    <form action="" method="post" enctype="multipart/form-data">
        <div class="boutonFermer" onClick="revenir()">X</div>    
        <p>
            <?php  
                $navigateur = get_browsername();
                //$navigateur = get_browser(null, true); // Ne marche pas sur
                //print("<pre>"); print_r($navigateur); print("<pre>"); // Pour le debuggage
                //print("<pre>"); print_r($_SERVER); print("<pre>");
                if($navigateur == "Safari") {
                    print('<textarea class="feedbacksTextArea" name="message" rows=30 cols=134 placeholder="N\'hésitez pas à préciser au maximum ou pas si vous avez la flemme, tous les commentaires sont bons à prendre ^^"></textarea><br />');
                } elseif ($navigateur == "Chrome") {
                    print('<textarea class="feedbacksTextArea" name="message" rows=30 cols=117 placeholder="N\'hésitez pas à préciser au maximum ou pas si vous avez la flemme, tous les commentaires sont bons à prendre ^^"></textarea><br />');
                } elseif ($navigateur == "Firefox") {
                    print('<textarea class="feedbacksTextArea" name="message" rows=25 cols=130 placeholder="N\'hésitez pas à préciser au maximum ou pas si vous avez la flemme, tous les commentaires sont bons à prendre ^^"></textarea><br />');
                } else {
                    print('<textarea class="feedbacksTextArea" name="message" rows=30 cols=124 placeholder="N\'hésitez pas à préciser au maximum ou pas si vous avez la flemme, tous les commentaires sont bons à prendre ^^"></textarea><br />');
                }
            ?>
            <!--<textarea style="resize: none; font: 15px arial, sans-serif;" name="message" rows=30 cols=134 placeholder="N'hésitez pas à préciser au maximum ou pas si vous avez la flemme, tous les commentaires sont bons à prendre ^^"></textarea><br />-->
            <br/>
            <input class="bouton" type="submit" value="Envoyer" />
        </p>
        
    </form>
    <?php
    if(isset($_POST) and array_key_exists("message", $_POST)){
        //print("<pre>"); print_r($_POST); print("<pre>");
        //print($screen_dim);

        $bdd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
        $req = $bdd->prepare('INSERT INTO feedbacks(texte, date_envoi, navigateur, ip_user, screen_dim, langue, systeme) VALUES(:texte, NOW(), :navigateur, :ip_user, :screen_dim, :langue, :systeme)');
        $req->execute(array(
            "texte" => $_POST["message"],
            //"date_envoi" => $date_envoi,
            "navigateur" => $navigateur,
            "ip_user" => $_SERVER["REMOTE_ADDR"],
            "screen_dim" => "pour plus tard",
            "langue" => $_SERVER["HTTP_ACCEPT_LANGUAGE"],
            "systeme" => $_SERVER["HTTP_USER_AGENT"]
        ));
        $req->closeCursor();
        if(isset($_SESSION["pseudo"])){
            logs($_SESSION["pseudo"], "Envoie d'un feedback: ". $_POST["message"]);
        } else {
            logs("inconnu", "Envoie d'un feedback: ". $_POST["message"]);
        }
       
        
    }
    ?>

</div>