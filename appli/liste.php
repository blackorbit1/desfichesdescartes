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
			<p class="semestre" data-ytta-id="-">1e Semestre</p>
			
			<a href="#!/about" ng-click="searchFichiers('MLJ1E21O', 'indifférent')" data-ytta-id="-">CBI</a>
		    <a href="#!/about" ng-click="searchFichiers('MLJ1E21O', 'indifférent')" data-ytta-id="-">CBI</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ1E22O', 'indifférent')" data-ytta-id="-">Intro Prog</a>
            <!--<a href="#!/about" ng-click="searchFichiers('MLJ1U2O', 'indifférent')" data-ytta-id="-">Prog 1</a>-->
            <a href="#!/about" ng-click="searchFichiers('MLJ1U1O', 'indifférent')" data-ytta-id="-">Maths 1</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ1U4O', 'indifférent')" data-ytta-id="-">Methodologie</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ1U6C', 'indifférent')" data-ytta-id="-">Bio 1</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ1U7C', 'indifférent')" data-ytta-id="-">Eco 1</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ1U8C', 'indifférent')" data-ytta-id="-">Physique 1</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ1U9C', 'indifférent')" data-ytta-id="-">Socio 1</a>
            <!--<a href="#!/about" ng-click="searchFichiers('MLJ1UZF', 'indifférent')" data-ytta-id="-">Projet de Prog 1</a> Apparemment y a pas-->
            <a href="#!/about" ng-click="searchFichiers('MLJ1UYF', 'indifférent')" data-ytta-id="-">Projet Arith Z/nZ</a>
            
            <p class="semestre" data-ytta-id="-">2e Semestre</p>
            
            <a href="#!/about" ng-click="searchFichiers('MLJ2E21O', 'indifférent')" data-ytta-id="-">Prog 2</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ2U1O', 'indifférent')" data-ytta-id="-">Maths 2</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ1U4O', 'indifférent')" data-ytta-id="-">Methodologie</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ2U6C', 'indifférent')" data-ytta-id="-">Bio 2</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ2U7C', 'indifférent')" data-ytta-id="-">Eco 2</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ2U8C', 'indifférent')" data-ytta-id="-">Physique 2</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ2U9C', 'indifférent')" data-ytta-id="-">Socio 2</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ2UZF', 'indifférent')" data-ytta-id="-">Projet de Prog 2</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ2E22O', 'indifférent')" data-ytta-id="-">Num. et log</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ2E41O', 'indifférent')" data-ytta-id="-">Anglais 1</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ2E42O', 'indifférent')" data-ytta-id="-">C2I</a>
            <!--<a href="#!/about" ng-click="searchFichiers('MLJ2U4O', 'indifférent')" data-ytta-id="-">Culture générale</a>-->
            <!--<a href="#!/about" ng-click="searchFichiers('MLJ2UYF', 'indifférent')" data-ytta-id="-">Approx. num. Inté.</a>-->
		<?php
	} elseif ($_GET["niveau"] == "L2_info"){
		?>
			<p class="semestre" data-ytta-id="-">1e Semestre</p>
			
			<a href="#!/about" ng-click="searchFichiers('MLJ3E52O', 'indifférent')" data-ytta-id="-">PPE</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ3E51O', 'indifférent')" data-ytta-id="-">Anglais 2</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ3U6C', 'indifférent')" data-ytta-id="-">Bio 3</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ3U7C', 'indifférent')" data-ytta-id="-">Eco 3</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ3U8C', 'indifférent')" data-ytta-id="-">Physique 3</a>
            <!--<a href="#!/about" ng-click="searchFichiers('MLK3U1O', 'indifférent')" data-ytta-id="-">Algebre 3</a>-->
            <!--<a href="#!/about" ng-click="searchFichiers('MLK3U3O', 'indifférent')" data-ytta-id="-">Intro aux probas</a>-->
            <a href="#!/about" ng-click="searchFichiers('MLL3U4O', 'indifférent')" data-ytta-id="-">Probas pour l'info 1</a>
            <a href="#!/about" ng-click="searchFichiers('MLL3U2O', 'indifférent')" data-ytta-id="-">Prog impérative</a>
            <a href="#!/about" ng-click="searchFichiers('MLL3U3O', 'indifférent')" data-ytta-id="-">BDD</a>
            <a href="#!/about" ng-click="searchFichiers('MLL3UAC', 'indifférent')" data-ytta-id="-">Archi</a>
            <a href="#!/about" ng-click="searchFichiers('MLL3U1O', 'indifférent')" data-ytta-id="-">Algo</a>
            
            <p class="semestre" data-ytta-id="-">2e Semestre</p>
			
            <!--<a href="#!/about" ng-click="searchFichiers('MLJ3U5O', 'indifférent')" data-ytta-id="-">Culture générale 3</a>-->
            <a href="#!/about" ng-click="searchFichiers('MLJ4U6C', 'indifférent')" data-ytta-id="-">Bio 4</a>
            <!--<a href="#!/about" ng-click="searchFichiers('MLJ4U6CI', 'indifférent')" data-ytta-id="-">Bio 4 - géné. molécul.</a>-->
            <a href="#!/about" ng-click="searchFichiers('MLJ4U7C', 'indifférent')" data-ytta-id="-">Eco 4</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ4U8C', 'indifférent')" data-ytta-id="-">Physique 4</a>
            <!--<a href="#!/about" ng-click="searchFichiers('MLK4U1O', 'indifférent')" data-ytta-id="-">Algebre 4</a>-->
            <!--<a href="#!/about" ng-click="searchFichiers('MLK4U3O', 'indifférent')" data-ytta-id="-">Env. calc. scienti.</a>-->
            <a href="#!/about" ng-click="searchFichiers('MLL4U1O', 'indifférent')" data-ytta-id="-">POO</a>
            <a href="#!/about" ng-click="searchFichiers('MLL4U2O', 'indifférent')" data-ytta-id="-">Projet</a>
            <a href="#!/about" ng-click="searchFichiers('MLL4U3O', 'indifférent')" data-ytta-id="-">Systeme</a>
            <a href="#!/about" ng-click="searchFichiers('MLL4UAC', 'indifférent')" data-ytta-id="-">Théorie orga.</a>
            <a href="#!/about" ng-click="searchFichiers('MLL4UBC', 'indifférent')" data-ytta-id="-">Théorie langages</a>
            <a href="#!/about" ng-click="searchFichiers('MLL4UCC', 'indifférent')" data-ytta-id="-">SICG</a>
            <a href="#!/about" ng-click="searchFichiers('MLL4UDC', 'indifférent')" data-ytta-id="-">Web</a>
            <!--<a href="#!/about" ng-click="searchFichiers('MLL4UZF', 'indifférent')" data-ytta-id="-">Entreprenariat 1</a>-->
		<?php
	} elseif ($_GET["niveau"] == "L2_math"){
		?>
			<p class="semestre" data-ytta-id="-">1e Semestre</p>
			
			<a href="#!/about" ng-click="searchFichiers('MLJ3E52O', 'indifférent')" data-ytta-id="-">PPE</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ3E51O', 'indifférent')" data-ytta-id="-">Anglais 2</a>
            <!--<a href="#!/about" ng-click="searchFichiers('MLJ3U5O', 'indifférent')" data-ytta-id="-">Culture générale 3</a>-->
            <a href="#!/about" ng-click="searchFichiers('MLJ3U6C', 'indifférent')" data-ytta-id="-">Bio 3</a>
            <!--<a href="#!/about" ng-click="searchFichiers('MLJ3U6CI', 'indifférent')" data-ytta-id="-">Bio 3 - neurophysi.</a>-->
            <a href="#!/about" ng-click="searchFichiers('MLK3BF1', 'indifférent')" data-ytta-id="-">Normes sur RD</a>
            <a href="#!/about" ng-click="searchFichiers('MLL3U1O', 'indifférent')" data-ytta-id="-">Algo</a>
            <a href="#!/about" ng-click="searchFichiers('MLL3U2O', 'indifférent')" data-ytta-id="-">Prog impérative</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ3U7C', 'indifférent')" data-ytta-id="-">Eco 3</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ3U8C', 'indifférent')" data-ytta-id="-">Physique 3</a>
            <a href="#!/about" ng-click="searchFichiers('MLK3U1O', 'indifférent')" data-ytta-id="-">Algebre 3</a>
            <a href="#!/about" ng-click="searchFichiers('MLK3U2O', 'indifférent')" data-ytta-id="-">Analyse 3</a>
            <a href="#!/about" ng-click="searchFichiers('MLK3U3O', 'indifférent')" data-ytta-id="-">Intro aux probas</a>
            <a href="#!/about" ng-click="searchFichiers('MLK3UYF', 'indifférent')" data-ytta-id="-">Normes sur RD +</a>
            
            <p class="semestre" data-ytta-id="-">2e Semestre</p>
            
            <a href="#!/about" ng-click="searchFichiers('MLJ4U7C', 'indifférent')" data-ytta-id="-">Eco 4</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ4U8C', 'indifférent')" data-ytta-id="-">Physique 4</a>
            <a href="#!/about" ng-click="searchFichiers('MLK4U1O', 'indifférent')" data-ytta-id="-">Algebre 4</a>
            <a href="#!/about" ng-click="searchFichiers('MLK4U2O', 'indifférent')" data-ytta-id="-">Analyse 4</a>
            <a href="#!/about" ng-click="searchFichiers('MLK4U5O', 'indifférent')" data-ytta-id="-">Intro aux stats</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ4U6C', 'indifférent')" data-ytta-id="-">Bio 4</a>
            <!--<a href="#!/about" ng-click="searchFichiers('MLJ4U6CI', 'indifférent')" data-ytta-id="-">Bio 4 - géné. molécul.</a>-->
            <a href="#!/about" ng-click="searchFichiers('MLK4U3O', 'indifférent')" data-ytta-id="-">Env. calc. scienti.</a>
            <a href="#!/about" ng-click="searchFichiers('MLK4U4O', 'indifférent')" data-ytta-id="-">Analyse ingé. 1</a>
            <a href="#!/about" ng-click="searchFichiers('MLK4UCC', 'indifférent')" data-ytta-id="-">Complé. Math oral</a>
            <a href="#!/about" ng-click="searchFichiers('MLK4UYF', 'indifférent')" data-ytta-id="-">Projet: esp. suites</a>
            <a href="#!/about" ng-click="searchFichiers('MLL4U1O', 'indifférent')" data-ytta-id="-">POO</a>
            <a href="#!/about" ng-click="searchFichiers('MLL4U2O', 'indifférent')" data-ytta-id="-">Projet</a>                            
            <a href="#!/about" ng-click="searchFichiers('MLL4UAC', 'indifférent')" data-ytta-id="-">Théorie orga.</a>
            <a href="#!/about" ng-click="searchFichiers('MLL4UBC', 'indifférent')" data-ytta-id="-">Théorie langages</a>
		<?php
	} elseif ($_GET["niveau"] == "L3_info"){
		?>
			<p class="semestre" data-ytta-id="-">1e Semestre</p>
			
			<a href="#!/about" ng-click="searchFichiers('MLK5U1O', 'indifférent')" data-ytta-id="-">Calc. différentiels</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ5U6C', 'indifférent')" data-ytta-id="-">Bio 5</a>
            <a href="#!/about" ng-click="searchFichiers('MLK5U71O', 'indifférent')" data-ytta-id="-">Eco 5</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ5U8C', 'indifférent')" data-ytta-id="-">Physique 5</a>
            <!--<a href="#!/about" ng-click="searchFichiers('MLK5U1O', 'indifférent')" data-ytta-id="-">Algebre 5 - Topologie</a> Déjà mis en calc diff ??? -->
            <a href="#!/about" ng-click="searchFichiers('MLK5U5O', 'indifférent')" data-ytta-id="-">Esp. eucl. opti.</a>
            <a href="#!/about" ng-click="searchFichiers('MLK5U3O', 'indifférent')" data-ytta-id="-">Probas 5</a>
            <a href="#!/about" ng-click="searchFichiers('MLL5U2O', 'indifférent')" data-ytta-id="-">POO avancée</a>
            <a href="#!/about" ng-click="searchFichiers('MLL5U1O', 'indifférent')" data-ytta-id="-">Gélo</a>
            <a href="#!/about" ng-click="searchFichiers('MLL5U4O', 'indifférent')" data-ytta-id="-">Maths pour l'info</a>
            <a href="#!/about" ng-click="searchFichiers('MLL5U5O', 'indifférent')" data-ytta-id="-">Reseaux</a>
            <a href="#!/about" ng-click="searchFichiers('MLL5UAC', 'indifférent')" data-ytta-id="-">Prog Unix</a>
            <a href="#!/about" ng-click="searchFichiers('MLL5UBC', 'indifférent')" data-ytta-id="-">BDD avancée</a>
            <a href="#!/about" ng-click="searchFichiers('MLL5U3O', 'indifférent')" data-ytta-id="-">Algo avancée</a>
            <a href="#!/about" ng-click="searchFichiers('MLL5UCO', 'indifférent')" data-ytta-id="-">ASCI</a>
            <a href="#!/about" ng-click="searchFichiers('MLL5UDO', 'indifférent')" data-ytta-id="-">Gestion entreprise</a>
            
            <p class="semestre" data-ytta-id="-">2e Semestre</p>
            
            <a href="#!/about" ng-click="searchFichiers('MLJ6U6CI', 'indifférent')" data-ytta-id="-">Bio 6</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ6UHC', 'indifférent')" data-ytta-id="-">Bio-Informatique</a>
            <a href="#!/about" ng-click="searchFichiers('MLK6U71C', 'indifférent')" data-ytta-id="-">Eco 6 - internatio.</a>
            <a href="#!/about" ng-click="searchFichiers('MLK6U72C', 'indifférent')" data-ytta-id="-">Eco 6 - publique</a>
            <!--<a href="#!/about" ng-click="searchFichiers('MLK6U1O', 'indifférent')" data-ytta-id="-">Esp. de Hilbert</a> Matiere de maths-->
            <!--<a href="#!/about" ng-click="searchFichiers('MLK6U3O', 'indifférent')" data-ytta-id="-">Trans. Fourier</a> Matiere de maths -->
            <!--<a href="#!/about" ng-click="searchFichiers('MLL3U4O', 'indifférent')" data-ytta-id="-">Probas pour l'info 2</a> Déjà mis pour proba 1 ??????? -->
            <a href="#!/about" ng-click="searchFichiers('MLL6UCC', 'indifférent')" data-ytta-id="-">Reseaux avancés</a>
            
            <a href="#!/about" ng-click="searchFichiers('MLL6E11O', 'indifférent')" data-ytta-id="-">Communication</a>
            <a href="#!/about" ng-click="searchFichiers('MLL6E12O', 'indifférent')" data-ytta-id="-">Anglais 3</a>
            <!--<a href="#!/about" ng-click="searchFichiers('MLL6E13O', 'indifférent')" data-ytta-id="-">Projet tutoré</a>-->
            <a href="#!/about" ng-click="searchFichiers('MLL4U2O', 'indifférent')" data-ytta-id="-">Projet</a>
            <a href="#!/about" ng-click="searchFichiers('MLL6U1O', 'indifférent')" data-ytta-id="-">Préprofessionnalisation</a>
            <a href="#!/about" ng-click="searchFichiers('MLL6U2O', 'indifférent')" data-ytta-id="-">Stage</a>
            <a href="#!/about" ng-click="searchFichiers('MLL6U3C', 'indifférent')" data-ytta-id="-">IA</a>
            <a href="#!/about" ng-click="searchFichiers('MLL6U4C', 'indifférent')" data-ytta-id="-">Trait. num. données</a>
            <a href="#!/about" ng-click="searchFichiers('MLL6U5C', 'indifférent')" data-ytta-id="-">Ana. eco. strat. entrep.</a>
            <a href="#!/about" ng-click="searchFichiers('MLL6UBC', 'indifférent')" data-ytta-id="-">Image</a>
            <a href="#!/about" ng-click="searchFichiers('MLL6UDC', 'indifférent')" data-ytta-id="-">Sys. num. com.</a>
            <a href="#!/about" ng-click="searchFichiers('MLL6UEC', 'indifférent')" data-ytta-id="-">Gest fin + cont gest</a>
		<?php
	} elseif ($_GET["niveau"] == "L3_math"){
		?>
			<p class="semestre" data-ytta-id="-">1e Semestre</p>
			
			<a href="#!/about" ng-click="searchFichiers('MLK5U1T1', 'indifférent')" data-ytta-id="-">Topo. et Calc. diff.</a>
            <a href="#!/about" ng-click="searchFichiers('MLK5U2O', 'indifférent')" data-ytta-id="-">Mesure et intégration</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ5U6C', 'indifférent')" data-ytta-id="-">Bio 5</a>
            <a href="#!/about" ng-click="searchFichiers('MLK5U71O', 'indifférent')" data-ytta-id="-">Eco 5 - incertain</a>
            <a href="#!/about" ng-click="searchFichiers('MLK5U72O', 'indifférent')" data-ytta-id="-">Eco 5 - dyna et croiss</a>
            <!--<a href="#!/about" ng-click="searchFichiers('MLK5U1O', 'indifférent')" data-ytta-id="-">Algebre 5 - Topologie</a>
            <a href="#!/about" ng-click="searchFichiers('MLK5U1O', 'indifférent')" data-ytta-id="-">Algebre 5 - Mes. & inté.</a>-->
            <a href="#!/about" ng-click="searchFichiers('MLJ5U8C', 'indifférent')" data-ytta-id="-">Physique 5</a>
            <a href="#!/about" ng-click="searchFichiers('MLK5UAO', 'indifférent')" data-ytta-id="-">Analyse de données</a>
            <a href="#!/about" ng-click="searchFichiers('MLK5UEC', 'indifférent')" data-ytta-id="-">Struc algébriques</a>
            <a href="#!/about" ng-click="searchFichiers('MLK5U3O', 'indifférent')" data-ytta-id="-">Probabilités</a>
            <a href="#!/about" ng-click="searchFichiers('MLK5U4O', 'indifférent')" data-ytta-id="-">Analyse ingé. 2</a>
            <a href="#!/about" ng-click="searchFichiers('MLK5U5O', 'indifférent')" data-ytta-id="-">Esp. eucl. opti.</a>
            <a href="#!/about" ng-click="searchFichiers('MLL3U3O', 'indifférent')" data-ytta-id="-">BDD</a>
            <a href="#!/about" ng-click="searchFichiers('MLK5UCO', 'indifférent')" data-ytta-id="-">Maths appliqués</a>
            <a href="#!/about" ng-click="searchFichiers('MLK5UFC', 'indifférent')" data-ytta-id="-">Maths et modéli.</a>
            <a href="#!/about" ng-click="searchFichiers('MLK5UYF', 'indifférent')" data-ytta-id="-">Esp. de Banache</a>
            <a href="#!/about" ng-click="searchFichiers('MLL5U1O', 'indifférent')" data-ytta-id="-">Gélo</a>
            <a href="#!/about" ng-click="searchFichiers('MLL5U2O', 'indifférent')" data-ytta-id="-">POO avancée</a>
            <a href="#!/about" ng-click="searchFichiers('MLL5U3O', 'indifférent')" data-ytta-id="-">Algo avancée</a>
            <a href="#!/about" ng-click="searchFichiers('MLL5U5O', 'indifférent')" data-ytta-id="-">Réseaux</a>
            
            <p class="semestre" data-ytta-id="-">2e Semestre</p>
            
            <a href="#!/about" ng-click="searchFichiers('MLJ6U6CI', 'indifférent')" data-ytta-id="-">Bio 6</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ6UHC', 'indifférent')" data-ytta-id="-">Bio-Informatique</a>
            <!--<a href="#!/about" ng-click="searchFichiers('MLK6UHC', 'indifférent')" data-ytta-id="-">Bio-Informatique B</a> a l'air de ne pas exister-->
            <a href="#!/about" ng-click="searchFichiers('MLK6U71C', 'indifférent')" data-ytta-id="-">Eco internatio.</a>
            <a href="#!/about" ng-click="searchFichiers('MLK6U72C', 'indifférent')" data-ytta-id="-">Eco publique</a>
            <a href="#!/about" ng-click="searchFichiers('MLK6UDC', 'indifférent')" data-ytta-id="-">Projet economie</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ6U8C', 'indifférent')" data-ytta-id="-">Physique 6</a>
            <a href="#!/about" ng-click="searchFichiers('MLK6UGC', 'indifférent')" data-ytta-id="-">Algebre 6</a>
            <a href="#!/about" ng-click="searchFichiers('MLK6UEC', 'indifférent')" data-ytta-id="-">Analyse 6</a>
            <a href="#!/about" ng-click="searchFichiers('MLK6U1O', 'indifférent')" data-ytta-id="-">Esp. de Hilbert</a>
            <a href="#!/about" ng-click="searchFichiers('MLK6U3O', 'indifférent')" data-ytta-id="-">Trans. Fourier</a>
            <a href="#!/about" ng-click="searchFichiers('MLK6U2O', 'indifférent')" data-ytta-id="-">Méthodes num.</a>
            <a href="#!/about" ng-click="searchFichiers('MLK6U4O', 'indifférent')" data-ytta-id="-">Stats inféren.</a>
            <a href="#!/about" ng-click="searchFichiers('MLK6U5O', 'indifférent')" data-ytta-id="-">Logiciels stats</a>
            <a href="#!/about" ng-click="searchFichiers('MLK6UFC', 'indifférent')" data-ytta-id="-">Sys dynamiques</a>
            <!--<a href="#!/about" ng-click="searchFichiers('MLK6UWO', 'indifférent')" data-ytta-id="-">Anglais 3 - A</a> Inutile vu la qtté de fic-->
            <a href="#!/about" ng-click="searchFichiers('MLL6E12O', 'indifférent')" data-ytta-id="-">Anglais 3</a>
            <a href="#!/about" ng-click="searchFichiers('MLK6UYF', 'indifférent')" data-ytta-id="-">Proj. esp. fonc.</a>
            <a href="#!/about" ng-click="searchFichiers('MLL6UCC', 'indifférent')" data-ytta-id="-">Réseaux avancés</a>
            <a href="#!/about" ng-click="searchFichiers('MLL6E11O', 'indifférent')" data-ytta-id="-">Communication</a>
            <!--<a href="#!/about" ng-click="searchFichiers('MLL6E13O', 'indifférent')" data-ytta-id="-">Projet tutoré</a>-->
            <a href="#!/about" ng-click="searchFichiers('MLL4U2O', 'indifférent')" data-ytta-id="-">Projet</a>
            <a href="#!/about" ng-click="searchFichiers('MLL6U1O', 'indifférent')" data-ytta-id="-">Préprofessionnalisation</a>
            <a href="#!/about" ng-click="searchFichiers('MLL6U3C', 'indifférent')" data-ytta-id="-">IA</a>
            <a href="#!/about" ng-click="searchFichiers('MLL6U4C', 'indifférent')" data-ytta-id="-">Trait. num. données</a>
            <a href="#!/about" ng-click="searchFichiers('MLL6UBC', 'indifférent')" data-ytta-id="-">Image</a>
            <a href="#!/about" ng-click="searchFichiers('MLL6UDC', 'indifférent')" data-ytta-id="-">Sys. num. com.</a>
            <a href="#!/about" ng-click="searchFichiers('MLL6UEC', 'indifférent')" data-ytta-id="-">Gest fin + cont gest</a>
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