<?php
include_once("../bdd.php");
include_once("../logs.php");

if(isset($_GET["matiere"]) && isset($_GET["type"])){
	$sortie = array();
	$finrequete = "";
	$typePossible = array("indifférent", "annale", "cours", "TD", "TP", "fiche", "tuto", "exempleTravail", "autre", "en_attente");
	// On constitue la fin de la requete (avec ce que demande l'user) en vérifiant que tout est correct
	if(array_key_exists("type", $_GET) and $_GET["type"] != "indifférent" and in_array($_GET["type"], $typePossible)) $finrequete = ($finrequete . " and type = '" . htmlentities($_GET["type"]) . "'");
	if(array_key_exists("matiere", $_GET) and $_GET["matiere"] != "indifférent") $finrequete = ($finrequete . " and matiere = '" . htmlentities($_GET["matiere"], ENT_QUOTES) . "'");
	//print($page, )
	//print(" LIMIT " . ($page-1)*$ELEMENTSPARPAGE . ", " . $page*$ELEMENTSPARPAGE);  // Pour le debuggage


	$req = $bdd->query('SELECT id, nom, nom_fichier, nb_visionnage, details_active, valide, externe FROM fichiers WHERE valide = 1 and supprime = 0 ' . $finrequete . " ORDER BY nom"); // Envoi de la requete à la base de données

	print('{"fichiers":  ['); 
	$i = 0;
	while ($donnees = $req->fetch()){                                //// AFFICHAGE DE CHAQUE CASES ////
	
		$nom_image = $donnees["externe"]?($donnees["id"]):(current(explode('.', htmlspecialchars($donnees["nom_fichier"]))));
		$fic_suppose = "uploads/". $nom_image . ".jpg"; 
		$tampon = explode(".", $donnees["nom_fichier"]);
		$extension = end($tampon);
		error_reporting(E_ALL);
		$miniature = "no_template.jpg";
		if(file_exists("../" . $fic_suppose)){
			$miniature = $fic_suppose;
		} elseif (!strcmp($extension, "java")){
			$miniature = "java-min.jpg";
		} elseif (!strcmp($extension, "sql")){
			$miniature = "sql-min.jpg";
		} elseif (!strcmp($extension, "c")){
			$miniature = "c-min.jpg";
		} elseif (!strcmp($extension, "html")){
			$miniature = "html-min.jpg";
		} elseif (!strcmp($extension, "py")){
			$miniature = "python-min.jpg";
		} elseif (!strcmp($extension, "php")){
			$miniature = "php-min.jpg";
		} elseif (!strcmp($extension, "zip")){
			$miniature = "zip-min.jpg";
		} elseif (!strcmp($extension, "gz")){
			$miniature = "targz-min.jpg";
		} elseif (!strcmp($extension, "rar")){
			$miniature = "rar-min.jpg";
		} elseif (!strcmp($extension, "iso")){
			$miniature = "iso-min.jpg";
		} elseif (!strcmp($extension, "exe")){
			$miniature = "exe-min.jpg";
		} elseif (!strcmp($extension, "dmg")){
			$miniature = "dmg-min.jpg";
		} elseif (!strcmp($extension, "app")){
			$miniature = "app-min.jpg";
		} elseif (!strcmp($extension, "7z")){
			$miniature = "7z-min.jpg";
		} elseif (!strcmp($extension, "txt")){
			$miniature = "txt-min.jpg";
		} elseif (!strcmp($extension, "mp4")){
			$miniature = "video.gif";
		} elseif (!strcmp($extension, "mov")){
			$miniature = "video.gif";
		}
														
		if($i != 0) print(",");
		$i ++;
		print('{'); 
		print('"nom": "' . $donnees["nom"] . '",'); 
		print('"image": "https://desfichesdescartes.fr/' . $miniature . '",'); 
		$fichier = $donnees["externe"]?($donnees["id"] ."&externe=true"):($donnees["nom_fichier"]);
		print('"url": "https://desfichesdescartes.fr/inter_ouverture.php?fichier=' . $fichier . '"'); 
		print('}');
	}
	print(']}'); 
	/*
	// Nom du fichier à créer
	$nom_du_fichier = 'fichier.json';

	// Ouverture du fichier
	$fichier = fopen($nom_du_fichier, 'w+');

	// Ecriture dans le fichier
	fwrite($fichier, $contenu_json);

	// Fermeture du fichier
	fclose($fichier);
*/
} elseif (isset($_GET["niveau"])) {
	if($_GET["niveau"] == "L1"){
		?>
		    <a href="#!/about" ng-click="matiere='MLJ1E21O'">CBI</a>
            <a href="#!/about" ng-click="matiere='MLJ1E22O'">Intro Prog</a>
            <!--<a href="#!/about" ng-click="matiere='MLJ1U2O'">Prog 1</a>-->
            <a href="#!/about" ng-click="matiere='MLJ1U1O'">Maths 1</a>
            <a href="#!/about" ng-click="matiere='MLJ1U4O'">Methodologie</a>
            <a href="#!/about" ng-click="matiere='MLJ1U6C'">Bio 1</a>
            <a href="#!/about" ng-click="matiere='MLJ1U7C'">Eco 1</a>
            <a href="#!/about" ng-click="matiere='MLJ1U8C'">Physique 1</a>
            <a href="#!/about" ng-click="matiere='MLJ1U9C'">Socio 1</a>
            <!--<a href="#!/about" ng-click="matiere='MLJ1UZF'">Projet de Prog 1</a> Apparemment y a pas-->
            <a href="#!/about" ng-click="matiere='MLJ1UYF'">Projet Arith Z/nZ</a>
            
            __________________
            
            <a href="#!/about" ng-click="matiere='MLJ2E21O'">Prog 2</a>
            <a href="#!/about" ng-click="matiere='MLJ2U1O'">Maths 2</a>
            <a href="#!/about" ng-click="matiere='MLJ1U4O'">Methodologie</a>
            <a href="#!/about" ng-click="matiere='MLJ2U6C'">Bio 2</a>
            <a href="#!/about" ng-click="matiere='MLJ2U7C'">Eco 2</a>
            <a href="#!/about" ng-click="matiere='MLJ2U8C'">Physique 2</a>
            <a href="#!/about" ng-click="matiere='MLJ2U9C'">Socio 2</a>
            <a href="#!/about" ng-click="matiere='MLJ2UZF'">Projet de Prog 2</a>
            <a href="#!/about" ng-click="matiere='MLJ2E22O'">Num. et log</a>
            <a href="#!/about" ng-click="matiere='MLJ2E41O'">Anglais 1</a>
            <a href="#!/about" ng-click="matiere='MLJ2E42O'">C2I</a>
            <!--<a href="#!/about" ng-click="matiere='MLJ2U4O'">Culture générale</a>-->
            <!--<a href="#!/about" ng-click="matiere='MLJ2UYF'">Approx. num. Inté.</a>-->
		<?php
	} elseif ($GET_["niveau"] == "L2_info"){
		?>
			<a href="#!/about" ng-click="matiere='MLJ3E52O'">PPE</a>
            <a href="#!/about" ng-click="matiere='MLJ3E51O'">Anglais 2</a>
            <a href="#!/about" ng-click="matiere='MLJ3U6C'">Bio 3</a>
            <a href="#!/about" ng-click="matiere='MLJ3U7C'">Eco 3</a>
            <a href="#!/about" ng-click="matiere='MLJ3U8C'">Physique 3</a>
            <!--<a href="#!/about" ng-click="matiere='MLK3U1O'">Algebre 3</a>-->
            <!--<a href="#!/about" ng-click="matiere='MLK3U3O'">Intro aux probas</a>-->
            <a href="#!/about" ng-click="matiere='MLL3U4O'">Probas pour l'info 1</a>
            <a href="#!/about" ng-click="matiere='MLL3U2O'">Prog impérative</a>
            <a href="#!/about" ng-click="matiere='MLL3U3O'">BDD</a>
            <a href="#!/about" ng-click="matiere='MLL3UAC'">Archi</a>
            <a href="#!/about" ng-click="matiere='MLL3U1O'">Algo</a>
            
            __________________
            
            <!--<a href="#!/about" ng-click="matiere='MLJ3U5O'">Culture générale 3</a>-->
            <a href="#!/about" ng-click="matiere='MLJ4U6C'">Bio 4</a>
            <!--<a href="#!/about" ng-click="matiere='MLJ4U6CI'">Bio 4 - géné. molécul.</a>-->
            <a href="#!/about" ng-click="matiere='MLJ4U7C'">Eco 4</a>
            <a href="#!/about" ng-click="matiere='MLJ4U8C'">Physique 4</a>
            <!--<a href="#!/about" ng-click="matiere='MLK4U1O'">Algebre 4</a>-->
            <!--<a href="#!/about" ng-click="matiere='MLK4U3O'">Env. calc. scienti.</a>-->
            <a href="#!/about" ng-click="matiere='MLL4U1O'">POO</a>
            <a href="#!/about" ng-click="matiere='MLL4U2O'">Projet</a>
            <a href="#!/about" ng-click="matiere='MLL4U3O'">Systeme</a>
            <a href="#!/about" ng-click="matiere='MLL4UAC'">Théorie orga.</a>
            <a href="#!/about" ng-click="matiere='MLL4UBC'">Théorie langages</a>
            <a href="#!/about" ng-click="matiere='MLL4UCC'">SICG</a>
            <a href="#!/about" ng-click="matiere='MLL4UDC'">Web</a>
            <!--<a href="#!/about" ng-click="matiere='MLL4UZF'">Entreprenariat 1</a>-->
		<?php
	} elseif ($GET_["niveau"] == "L2_math"){
		?>
			<a href="#!/about" ng-click="matiere='MLJ3E52O'">PPE</a>
            <a href="#!/about" ng-click="matiere='MLJ3E51O'">Anglais 2</a>
            <!--<a href="#!/about" ng-click="matiere='MLJ3U5O'">Culture générale 3</a>-->
            <a href="#!/about" ng-click="matiere='MLJ3U6C'">Bio 3</a>
            <!--<a href="#!/about" ng-click="matiere='MLJ3U6CI'">Bio 3 - neurophysi.</a>-->
            <a href="#!/about" ng-click="matiere='MLK3BF1'">Normes sur RD</a>
            <a href="#!/about" ng-click="matiere='MLL3U1O'">Algo</a>
            <a href="#!/about" ng-click="matiere='MLL3U2O'">Prog impérative</a>
            <a href="#!/about" ng-click="matiere='MLJ3U7C'">Eco 3</a>
            <a href="#!/about" ng-click="matiere='MLJ3U8C'">Physique 3</a>
            <a href="#!/about" ng-click="matiere='MLK3U1O'">Algebre 3</a>
            <a href="#!/about" ng-click="matiere='MLK3U2O'">Analyse 3</a>
            <a href="#!/about" ng-click="matiere='MLK3U3O'">Intro aux probas</a>
            <a href="#!/about" ng-click="matiere='MLK3UYF'">Normes sur RD +</a>
            
            __________________
            
            <a href="#!/about" ng-click="matiere='MLJ4U7C'">Eco 4</a>
            <a href="#!/about" ng-click="matiere='MLJ4U8C'">Physique 4</a>
            <a href="#!/about" ng-click="matiere='MLK4U1O'">Algebre 4</a>
            <a href="#!/about" ng-click="matiere='MLK4U2O'">Analyse 4</a>
            <a href="#!/about" ng-click="matiere='MLK4U5O'">Intro aux stats</a>
            <a href="#!/about" ng-click="matiere='MLJ4U6C'">Bio 4</a>
            <!--<a href="#!/about" ng-click="matiere='MLJ4U6CI'">Bio 4 - géné. molécul.</a>-->
            <a href="#!/about" ng-click="matiere='MLK4U3O'">Env. calc. scienti.</a>
            <a href="#!/about" ng-click="matiere='MLK4U4O'">Analyse ingé. 1</a>
            <a href="#!/about" ng-click="matiere='MLK4UCC'">Complé. Math oral</a>
            <a href="#!/about" ng-click="matiere='MLK4UYF'">Projet: esp. suites</a>
            <a href="#!/about" ng-click="matiere='MLL4U1O'">POO</a>
            <a href="#!/about" ng-click="matiere='MLL4U2O'">Projet</a>                            
            <a href="#!/about" ng-click="matiere='MLL4UAC'">Théorie orga.</a>
            <a href="#!/about" ng-click="matiere='MLL4UBC'">Théorie langages</a>
		<?php
	} elseif ($GET_["niveau"] == "L3_info"){
		?>
			<a href="#!/about" ng-click="matiere='MLK5U1O'">Calc. différentiels</a>
            <a href="#!/about" ng-click="matiere='MLJ5U6C'">Bio 5</a>
            <a href="#!/about" ng-click="matiere='MLK5U71O'">Eco 5</a>
            <a href="#!/about" ng-click="matiere='MLJ5U8C'">Physique 5</a>
            <!--<a href="#!/about" ng-click="matiere='MLK5U1O'">Algebre 5 - Topologie</a> Déjà mis en calc diff ??? -->
            <a href="#!/about" ng-click="matiere='MLK5U5O'">Esp. eucl. opti.</a>
            <a href="#!/about" ng-click="matiere='MLK5U3O'">Probas 5</a>
            <a href="#!/about" ng-click="matiere='MLL5U2O'">POO avancée</a>
            <a href="#!/about" ng-click="matiere='MLL5U1O'">Gélo</a>
            <a href="#!/about" ng-click="matiere='MLL5U4O'">Maths pour l'info</a>
            <a href="#!/about" ng-click="matiere='MLL5U5O'">Reseaux</a>
            <a href="#!/about" ng-click="matiere='MLL5UAC'">Prog Unix</a>
            <a href="#!/about" ng-click="matiere='MLL5UBC'">BDD avancée</a>
            <a href="#!/about" ng-click="matiere='MLL5U3O'">Algo avancée</a>
            <a href="#!/about" ng-click="matiere='MLL5UCO'">ASCI</a>
            <a href="#!/about" ng-click="matiere='MLL5UDO'">Gestion entreprise</a>
            
            __________________
            
            <a href="#!/about" ng-click="matiere='MLJ6U6CI'">Bio 6</a>
            <a href="#!/about" ng-click="matiere='MLJ6UHC'">Bio-Informatique</a>
            <a href="#!/about" ng-click="matiere='MLK6U71C'">Eco 6 - internatio.</a>
            <a href="#!/about" ng-click="matiere='MLK6U72C'">Eco 6 - publique</a>
            <!--<a href="#!/about" ng-click="matiere='MLK6U1O'">Esp. de Hilbert</a> Matiere de maths-->
            <!--<a href="#!/about" ng-click="matiere='MLK6U3O'">Trans. Fourier</a> Matiere de maths -->
            <!--<a href="#!/about" ng-click="matiere='MLL3U4O'">Probas pour l'info 2</a> Déjà mis pour proba 1 ??????? -->
            <a href="#!/about" ng-click="matiere='MLL6UCC'">Reseaux avancés</a>
            
            <a href="#!/about" ng-click="matiere='MLL6E11O'">Communication</a>
            <a href="#!/about" ng-click="matiere='MLL6E12O'">Anglais 3</a>
            <!--<a href="#!/about" ng-click="matiere='MLL6E13O'">Projet tutoré</a>-->
            <a href="#!/about" ng-click="matiere='MLL4U2O'">Projet</a>
            <a href="#!/about" ng-click="matiere='MLL6U1O'">Préprofessionnalisation</a>
            <a href="#!/about" ng-click="matiere='MLL6U2O'">Stage</a>
            <a href="#!/about" ng-click="matiere='MLL6U3C'">IA</a>
            <a href="#!/about" ng-click="matiere='MLL6U4C'">Trait. num. données</a>
            <a href="#!/about" ng-click="matiere='MLL6U5C'">Ana. eco. strat. entrep.</a>
            <a href="#!/about" ng-click="matiere='MLL6UBC'">Image</a>
            <a href="#!/about" ng-click="matiere='MLL6UDC'">Sys. num. com.</a>
            <a href="#!/about" ng-click="matiere='MLL6UEC'">Gest fin + cont gest</a>
		<?php
	} elseif ($GET_["niveau"] == "L3_math"){
		?>
			<a href="#!/about" ng-click="matiere='MLK5U1T1'">Topo. et Calc. diff.</a>
            <a href="#!/about" ng-click="matiere='MLK5U2O'">Mesure et intégration</a>
            <a href="#!/about" ng-click="matiere='MLJ5U6C'">Bio 5</a>
            <a href="#!/about" ng-click="matiere='MLK5U71O'">Eco 5 - incertain</a>
            <a href="#!/about" ng-click="matiere='MLK5U72O'">Eco 5 - dyna et croiss</a>
            <!--<a href="#!/about" ng-click="matiere='MLK5U1O'">Algebre 5 - Topologie</a>
            <a href="#!/about" ng-click="matiere='MLK5U1O'">Algebre 5 - Mes. & inté.</a>-->
            <a href="#!/about" ng-click="matiere='MLJ5U8C'">Physique 5</a>
            <a href="#!/about" ng-click="matiere='MLK5UAO'">Analyse de données</a>
            <a href="#!/about" ng-click="matiere='MLK5UEC'">Struc algébriques</a>
            <a href="#!/about" ng-click="matiere='MLK5U3O'">Probabilités</a>
            <a href="#!/about" ng-click="matiere='MLK5U4O'">Analyse ingé. 2</a>
            <a href="#!/about" ng-click="matiere='MLK5U5O'">Esp. eucl. opti.</a>
            <a href="#!/about" ng-click="matiere='MLL3U3O'">BDD</a>
            <a href="#!/about" ng-click="matiere='MLK5UCO'">Maths appliqués</a>
            <a href="#!/about" ng-click="matiere='MLK5UFC'">Maths et modéli.</a>
            <a href="#!/about" ng-click="matiere='MLK5UYF'">Esp. de Banache</a>
            <a href="#!/about" ng-click="matiere='MLL5U1O'">Gélo</a>
            <a href="#!/about" ng-click="matiere='MLL5U2O'">POO avancée</a>
            <a href="#!/about" ng-click="matiere='MLL5U3O'">Algo avancée</a>
            <a href="#!/about" ng-click="matiere='MLL5U5O'">Réseaux</a>
            
            __________________
            
            <a href="#!/about" ng-click="matiere='MLJ6U6CI'">Bio 6</a>
            <a href="#!/about" ng-click="matiere='MLJ6UHC'">Bio-Informatique</a>
            <!--<a href="#!/about" ng-click="matiere='MLK6UHC'">Bio-Informatique B</a> a l'air de ne pas exister-->
            <a href="#!/about" ng-click="matiere='MLK6U71C'">Eco internatio.</a>
            <a href="#!/about" ng-click="matiere='MLK6U72C'">Eco publique</a>
            <a href="#!/about" ng-click="matiere='MLK6UDC'">Projet economie</a>
            <a href="#!/about" ng-click="matiere='MLJ6U8C'">Physique 6</a>
            <a href="#!/about" ng-click="matiere='MLK6UGC'">Algebre 6</a>
            <a href="#!/about" ng-click="matiere='MLK6UEC'">Analyse 6</a>
            <a href="#!/about" ng-click="matiere='MLK6U1O'">Esp. de Hilbert</a>
            <a href="#!/about" ng-click="matiere='MLK6U3O'">Trans. Fourier</a>
            <a href="#!/about" ng-click="matiere='MLK6U2O'">Méthodes num.</a>
            <a href="#!/about" ng-click="matiere='MLK6U4O'">Stats inféren.</a>
            <a href="#!/about" ng-click="matiere='MLK6U5O'">Logiciels stats</a>
            <a href="#!/about" ng-click="matiere='MLK6UFC'">Sys dynamiques</a>
            <!--<a href="#!/about" ng-click="matiere='MLK6UWO'">Anglais 3 - A</a> Inutile vu la qtté de fic-->
            <a href="#!/about" ng-click="matiere='MLL6E12O'">Anglais 3</a>
            <a href="#!/about" ng-click="matiere='MLK6UYF'">Proj. esp. fonc.</a>
            <a href="#!/about" ng-click="matiere='MLL6UCC'">Réseaux avancés</a>
            <a href="#!/about" ng-click="matiere='MLL6E11O'">Communication</a>
            <!--<a href="#!/about" ng-click="matiere='MLL6E13O'">Projet tutoré</a>-->
            <a href="#!/about" ng-click="matiere='MLL4U2O'">Projet</a>
            <a href="#!/about" ng-click="matiere='MLL6U1O'">Préprofessionnalisation</a>
            <a href="#!/about" ng-click="matiere='MLL6U3C'">IA</a>
            <a href="#!/about" ng-click="matiere='MLL6U4C'">Trait. num. données</a>
            <a href="#!/about" ng-click="matiere='MLL6UBC'">Image</a>
            <a href="#!/about" ng-click="matiere='MLL6UDC'">Sys. num. com.</a>
            <a href="#!/about" ng-click="matiere='MLL6UEC'">Gest fin + cont gest</a>
		<?php
	}
} else {
	print("la demande ne correspond à rien");
}

/*
STRUCTURE JSON
{
"fichiers":  [
	{
		"nom": "Exemple",
		"image": "https://desfichesdescartes.fr/exemple.jpg"
		"url": "https://desfichesdescartes.fr/exemple.pdf"
	},
	{
		"nom": "Autre",
		"image": "https://desfichesdescartes.fr/autre.jpg"
		"url": "https://desfichesdescartes.fr/autre.pdf"
	}
]

}

*/

?>