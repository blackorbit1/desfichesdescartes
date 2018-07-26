<!DOCTYPE html>
<html>
    <head>
        <title>Script DFDC</title>
    </head>

    <body>
        <h1>Script</h1>
        <?php/*
            try{
                $bdd = new PDO('mysql:host=db719518578.db.1and1.com;dbname=db719518578;charset=utf8', 'dbo719518578', '-1Petitbulle');
                //$bdd = new PDO('mysql:host=localhost;dbname=desfichesdescartes;charset=utf8', 'root', 'root');
            } catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }


            $bdd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
            $req = $bdd->query('SELECT notes_matieres.affiche, notes_matieres.nom_mat, notes_matieres.intro_mat, notes_matieres.texte, notes_matieres.id_mat
                                FROM notes_matieres 
                                
                                '); // Envoi de la requete à la base de données
            
            while ($donnees = $req->fetch()){
                
                $bdd->exec('UPDATE matiere 
                SET affiche_notes = '.$donnees["affiche"].', nom_complet = "'.htmlspecialchars($donnees["nom_mat"]).'", intro = "'.htmlspecialchars($donnees["intro_mat"]).'", texte = "'.htmlspecialchars($donnees["texte"]).'", derniere_maj = NOW() 
                WHERE code = "'. ($donnees["id_mat"]) .'"');

                print("<br>- ". $donnees["nom_mat"] ." // affiche: ". $donnees["affiche"]);
            }



            
        */?>
        <br>
        <p>Terminé</p>
    </body>
</html>