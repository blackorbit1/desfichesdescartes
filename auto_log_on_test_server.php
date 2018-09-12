<?php

//print("<p>Le dossier actuel: ".  getcwd() ."</p>");

if(strstr(getcwd(), "/htdocs/test/desfichesdescartes") || strstr(getcwd(), "\www\desfichesdescartes")){
    ?>
        <form action="" method="post" style="z-index: 9999;position: absolute;" >
            <input type="hidden" name="auto_pseudo" value="blackorbit" />
            <input type="hidden" name="auto_mdp" value="202cb962ac59075b964b07152d234b70" />
            <input type="submit" value="Passer en mode admin" class="bouton" style="background-color: orange;" />
        </form>
    <?php
    if(isset($_POST["auto_pseudo"]) || isset($_POST["auto_mdp"])) {
        $_SESSION['pseudo'] = htmlentities($_POST['auto_pseudo'], ENT_QUOTES);
        $_SESSION['mdp'] = htmlentities($_POST['auto_mdp'], ENT_QUOTES);
        $id_session = "hacker_du_93";
        $user_session = "blackorbit";
    }
} 

/*
print("<p>Le dossier actuel: ".  $_SESSION['pseudo'] ."</p>");
print("<p>Le dossier actuel: ".  $_SESSION['mdp'] ."</p>");
*/
?>