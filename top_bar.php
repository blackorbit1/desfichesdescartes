<div class="barrecompte">
    <?php
        if($id_session == "hacker_du_93" || $id_session == "user"){ // Si l'utilisateur / admin est déjà connecté
            ?>
                <form action="boite_idees.php" method="post" style="float:left;" >
                    <input type="submit" value="Boite à idées" class="bouton_barrecompte" style="/*border-right: 0;*/"/>
                </form>
                <?php /*
                <form action="resultats.php" method="post" style="float:left;" class="barre_de_recherche" >
                    <input type="text" name="recherche" placeholder="Tappez des mots clés" class="champ_de_recherche" />
                    <input type="submit" value="Chercher" class="bouton_rechercher" style="border-right: 0;"/>
                </form>
                */ ?>
                <form action="" method="post" style="float:left;" >
                    <input type="hidden" name="Deconnexion" value="" />
                    <input type="submit" value="Deconnexion" class="bouton_barrecompte"/>
                </form>
                <form action="compte.php" method="post" style="float:left;" >
                    <input type="submit" value="Gestion compte" class="bouton_barrecompte"/>
                </form>
            <?php
        } else {
            ?>
                <form action="connexion.php" method="get" style="float:left;">
                    <input class="bouton_barrecompte" type="submit" value="Connexion / Inscription" />
                </form>
                <form action="boite_idees.php" method="post" style="float:left;" >
                    <input type="submit" value="Boite à idées" class="bouton_barrecompte" style="border-right: 0;"/>
                </form>
            <?php
        }
    ?>
</div>