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
			<p class="semestre">1e Semestre</p>
			
		    <a href="#!/about" ng-click="searchFichiers('MLJ1E21O', 'indifférent')">CBI</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ1E22O', 'indifférent')">Intro Prog</a>
            <!--<a href="#!/about" ng-click="searchFichiers('MLJ1U2O', 'indifférent')">Prog 1</a>-->
            <a href="#!/about" ng-click="searchFichiers('MLJ1U1O', 'indifférent')">Maths 1</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ1U4O', 'indifférent')">Methodologie</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ1U6C', 'indifférent')">Bio 1</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ1U7C', 'indifférent')">Eco 1</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ1U8C', 'indifférent')">Physique 1</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ1U9C', 'indifférent')">Socio 1</a>
            <!--<a href="#!/about" ng-click="searchFichiers('MLJ1UZF', 'indifférent')">Projet de Prog 1</a> Apparemment y a pas-->
            <a href="#!/about" ng-click="searchFichiers('MLJ1UYF', 'indifférent')">Projet Arith Z/nZ</a>
            
            <p class="semestre">2e Semestre</p>
            
            <a href="#!/about" ng-click="searchFichiers('MLJ2E21O', 'indifférent')">Prog 2</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ2U1O', 'indifférent')">Maths 2</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ1U4O', 'indifférent')">Methodologie</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ2U6C', 'indifférent')">Bio 2</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ2U7C', 'indifférent')">Eco 2</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ2U8C', 'indifférent')">Physique 2</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ2U9C', 'indifférent')">Socio 2</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ2UZF', 'indifférent')">Projet de Prog 2</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ2E22O', 'indifférent')">Num. et log</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ2E41O', 'indifférent')">Anglais 1</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ2E42O', 'indifférent')">C2I</a>
            <!--<a href="#!/about" ng-click="searchFichiers('MLJ2U4O', 'indifférent')">Culture générale</a>-->
            <!--<a href="#!/about" ng-click="searchFichiers('MLJ2UYF', 'indifférent')">Approx. num. Inté.</a>-->
		<?php
	} elseif ($_GET["niveau"] == "L2_info"){
		?>
			<p class="semestre">1e Semestre</p>
			
			<a href="#!/about" ng-click="searchFichiers('MLJ3E52O', 'indifférent')">PPE</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ3E51O', 'indifférent')">Anglais 2</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ3U6C', 'indifférent')">Bio 3</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ3U7C', 'indifférent')">Eco 3</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ3U8C', 'indifférent')">Physique 3</a>
            <!--<a href="#!/about" ng-click="searchFichiers('MLK3U1O', 'indifférent')">Algebre 3</a>-->
            <!--<a href="#!/about" ng-click="searchFichiers('MLK3U3O', 'indifférent')">Intro aux probas</a>-->
            <a href="#!/about" ng-click="searchFichiers('MLL3U4O', 'indifférent')">Probas pour l'info 1</a>
            <a href="#!/about" ng-click="searchFichiers('MLL3U2O', 'indifférent')">Prog impérative</a>
            <a href="#!/about" ng-click="searchFichiers('MLL3U3O', 'indifférent')">BDD</a>
            <a href="#!/about" ng-click="searchFichiers('MLL3UAC', 'indifférent')">Archi</a>
            <a href="#!/about" ng-click="searchFichiers('MLL3U1O', 'indifférent')">Algo</a>
            
            <p class="semestre">2e Semestre</p>
			
            <!--<a href="#!/about" ng-click="searchFichiers('MLJ3U5O', 'indifférent')">Culture générale 3</a>-->
            <a href="#!/about" ng-click="searchFichiers('MLJ4U6C', 'indifférent')">Bio 4</a>
            <!--<a href="#!/about" ng-click="searchFichiers('MLJ4U6CI', 'indifférent')">Bio 4 - géné. molécul.</a>-->
            <a href="#!/about" ng-click="searchFichiers('MLJ4U7C', 'indifférent')">Eco 4</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ4U8C', 'indifférent')">Physique 4</a>
            <!--<a href="#!/about" ng-click="searchFichiers('MLK4U1O', 'indifférent')">Algebre 4</a>-->
            <!--<a href="#!/about" ng-click="searchFichiers('MLK4U3O', 'indifférent')">Env. calc. scienti.</a>-->
            <a href="#!/about" ng-click="searchFichiers('MLL4U1O', 'indifférent')">POO</a>
            <a href="#!/about" ng-click="searchFichiers('MLL4U2O', 'indifférent')">Projet</a>
            <a href="#!/about" ng-click="searchFichiers('MLL4U3O', 'indifférent')">Systeme</a>
            <a href="#!/about" ng-click="searchFichiers('MLL4UAC', 'indifférent')">Théorie orga.</a>
            <a href="#!/about" ng-click="searchFichiers('MLL4UBC', 'indifférent')">Théorie langages</a>
            <a href="#!/about" ng-click="searchFichiers('MLL4UCC', 'indifférent')">SICG</a>
            <a href="#!/about" ng-click="searchFichiers('MLL4UDC', 'indifférent')">Web</a>
            <!--<a href="#!/about" ng-click="searchFichiers('MLL4UZF', 'indifférent')">Entreprenariat 1</a>-->
		<?php
	} elseif ($_GET["niveau"] == "L2_math"){
		?>
			<p class="semestre">1e Semestre</p>
			
			<a href="#!/about" ng-click="searchFichiers('MLJ3E52O', 'indifférent')">PPE</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ3E51O', 'indifférent')">Anglais 2</a>
            <!--<a href="#!/about" ng-click="searchFichiers('MLJ3U5O', 'indifférent')">Culture générale 3</a>-->
            <a href="#!/about" ng-click="searchFichiers('MLJ3U6C', 'indifférent')">Bio 3</a>
            <!--<a href="#!/about" ng-click="searchFichiers('MLJ3U6CI', 'indifférent')">Bio 3 - neurophysi.</a>-->
            <a href="#!/about" ng-click="searchFichiers('MLK3BF1', 'indifférent')">Normes sur RD</a>
            <a href="#!/about" ng-click="searchFichiers('MLL3U1O', 'indifférent')">Algo</a>
            <a href="#!/about" ng-click="searchFichiers('MLL3U2O', 'indifférent')">Prog impérative</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ3U7C', 'indifférent')">Eco 3</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ3U8C', 'indifférent')">Physique 3</a>
            <a href="#!/about" ng-click="searchFichiers('MLK3U1O', 'indifférent')">Algebre 3</a>
            <a href="#!/about" ng-click="searchFichiers('MLK3U2O', 'indifférent')">Analyse 3</a>
            <a href="#!/about" ng-click="searchFichiers('MLK3U3O', 'indifférent')">Intro aux probas</a>
            <a href="#!/about" ng-click="searchFichiers('MLK3UYF', 'indifférent')">Normes sur RD +</a>
            
            <p class="semestre">2e Semestre</p>
            
            <a href="#!/about" ng-click="searchFichiers('MLJ4U7C', 'indifférent')">Eco 4</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ4U8C', 'indifférent')">Physique 4</a>
            <a href="#!/about" ng-click="searchFichiers('MLK4U1O', 'indifférent')">Algebre 4</a>
            <a href="#!/about" ng-click="searchFichiers('MLK4U2O', 'indifférent')">Analyse 4</a>
            <a href="#!/about" ng-click="searchFichiers('MLK4U5O', 'indifférent')">Intro aux stats</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ4U6C', 'indifférent')">Bio 4</a>
            <!--<a href="#!/about" ng-click="searchFichiers('MLJ4U6CI', 'indifférent')">Bio 4 - géné. molécul.</a>-->
            <a href="#!/about" ng-click="searchFichiers('MLK4U3O', 'indifférent')">Env. calc. scienti.</a>
            <a href="#!/about" ng-click="searchFichiers('MLK4U4O', 'indifférent')">Analyse ingé. 1</a>
            <a href="#!/about" ng-click="searchFichiers('MLK4UCC', 'indifférent')">Complé. Math oral</a>
            <a href="#!/about" ng-click="searchFichiers('MLK4UYF', 'indifférent')">Projet: esp. suites</a>
            <a href="#!/about" ng-click="searchFichiers('MLL4U1O', 'indifférent')">POO</a>
            <a href="#!/about" ng-click="searchFichiers('MLL4U2O', 'indifférent')">Projet</a>                            
            <a href="#!/about" ng-click="searchFichiers('MLL4UAC', 'indifférent')">Théorie orga.</a>
            <a href="#!/about" ng-click="searchFichiers('MLL4UBC', 'indifférent')">Théorie langages</a>
		<?php
	} elseif ($_GET["niveau"] == "L3_info"){
		?>
			<p class="semestre">1e Semestre</p>
			
			<a href="#!/about" ng-click="searchFichiers('MLK5U1O', 'indifférent')">Calc. différentiels</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ5U6C', 'indifférent')">Bio 5</a>
            <a href="#!/about" ng-click="searchFichiers('MLK5U71O', 'indifférent')">Eco 5</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ5U8C', 'indifférent')">Physique 5</a>
            <!--<a href="#!/about" ng-click="searchFichiers('MLK5U1O', 'indifférent')">Algebre 5 - Topologie</a> Déjà mis en calc diff ??? -->
            <a href="#!/about" ng-click="searchFichiers('MLK5U5O', 'indifférent')">Esp. eucl. opti.</a>
            <a href="#!/about" ng-click="searchFichiers('MLK5U3O', 'indifférent')">Probas 5</a>
            <a href="#!/about" ng-click="searchFichiers('MLL5U2O', 'indifférent')">POO avancée</a>
            <a href="#!/about" ng-click="searchFichiers('MLL5U1O', 'indifférent')">Gélo</a>
            <a href="#!/about" ng-click="searchFichiers('MLL5U4O', 'indifférent')">Maths pour l'info</a>
            <a href="#!/about" ng-click="searchFichiers('MLL5U5O', 'indifférent')">Reseaux</a>
            <a href="#!/about" ng-click="searchFichiers('MLL5UAC', 'indifférent')">Prog Unix</a>
            <a href="#!/about" ng-click="searchFichiers('MLL5UBC', 'indifférent')">BDD avancée</a>
            <a href="#!/about" ng-click="searchFichiers('MLL5U3O', 'indifférent')">Algo avancée</a>
            <a href="#!/about" ng-click="searchFichiers('MLL5UCO', 'indifférent')">ASCI</a>
            <a href="#!/about" ng-click="searchFichiers('MLL5UDO', 'indifférent')">Gestion entreprise</a>
            
            <p class="semestre">2e Semestre</p>
            
            <a href="#!/about" ng-click="searchFichiers('MLJ6U6CI', 'indifférent')">Bio 6</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ6UHC', 'indifférent')">Bio-Informatique</a>
            <a href="#!/about" ng-click="searchFichiers('MLK6U71C', 'indifférent')">Eco 6 - internatio.</a>
            <a href="#!/about" ng-click="searchFichiers('MLK6U72C', 'indifférent')">Eco 6 - publique</a>
            <!--<a href="#!/about" ng-click="searchFichiers('MLK6U1O', 'indifférent')">Esp. de Hilbert</a> Matiere de maths-->
            <!--<a href="#!/about" ng-click="searchFichiers('MLK6U3O', 'indifférent')">Trans. Fourier</a> Matiere de maths -->
            <!--<a href="#!/about" ng-click="searchFichiers('MLL3U4O', 'indifférent')">Probas pour l'info 2</a> Déjà mis pour proba 1 ??????? -->
            <a href="#!/about" ng-click="searchFichiers('MLL6UCC', 'indifférent')">Reseaux avancés</a>
            
            <a href="#!/about" ng-click="searchFichiers('MLL6E11O', 'indifférent')">Communication</a>
            <a href="#!/about" ng-click="searchFichiers('MLL6E12O', 'indifférent')">Anglais 3</a>
            <!--<a href="#!/about" ng-click="searchFichiers('MLL6E13O', 'indifférent')">Projet tutoré</a>-->
            <a href="#!/about" ng-click="searchFichiers('MLL4U2O', 'indifférent')">Projet</a>
            <a href="#!/about" ng-click="searchFichiers('MLL6U1O', 'indifférent')">Préprofessionnalisation</a>
            <a href="#!/about" ng-click="searchFichiers('MLL6U2O', 'indifférent')">Stage</a>
            <a href="#!/about" ng-click="searchFichiers('MLL6U3C', 'indifférent')">IA</a>
            <a href="#!/about" ng-click="searchFichiers('MLL6U4C', 'indifférent')">Trait. num. données</a>
            <a href="#!/about" ng-click="searchFichiers('MLL6U5C', 'indifférent')">Ana. eco. strat. entrep.</a>
            <a href="#!/about" ng-click="searchFichiers('MLL6UBC', 'indifférent')">Image</a>
            <a href="#!/about" ng-click="searchFichiers('MLL6UDC', 'indifférent')">Sys. num. com.</a>
            <a href="#!/about" ng-click="searchFichiers('MLL6UEC', 'indifférent')">Gest fin + cont gest</a>
		<?php
	} elseif ($_GET["niveau"] == "L3_math"){
		?>
			<p class="semestre">1e Semestre</p>
			
			<a href="#!/about" ng-click="searchFichiers('MLK5U1T1', 'indifférent')">Topo. et Calc. diff.</a>
            <a href="#!/about" ng-click="searchFichiers('MLK5U2O', 'indifférent')">Mesure et intégration</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ5U6C', 'indifférent')">Bio 5</a>
            <a href="#!/about" ng-click="searchFichiers('MLK5U71O', 'indifférent')">Eco 5 - incertain</a>
            <a href="#!/about" ng-click="searchFichiers('MLK5U72O', 'indifférent')">Eco 5 - dyna et croiss</a>
            <!--<a href="#!/about" ng-click="searchFichiers('MLK5U1O', 'indifférent')">Algebre 5 - Topologie</a>
            <a href="#!/about" ng-click="searchFichiers('MLK5U1O', 'indifférent')">Algebre 5 - Mes. & inté.</a>-->
            <a href="#!/about" ng-click="searchFichiers('MLJ5U8C', 'indifférent')">Physique 5</a>
            <a href="#!/about" ng-click="searchFichiers('MLK5UAO', 'indifférent')">Analyse de données</a>
            <a href="#!/about" ng-click="searchFichiers('MLK5UEC', 'indifférent')">Struc algébriques</a>
            <a href="#!/about" ng-click="searchFichiers('MLK5U3O', 'indifférent')">Probabilités</a>
            <a href="#!/about" ng-click="searchFichiers('MLK5U4O', 'indifférent')">Analyse ingé. 2</a>
            <a href="#!/about" ng-click="searchFichiers('MLK5U5O', 'indifférent')">Esp. eucl. opti.</a>
            <a href="#!/about" ng-click="searchFichiers('MLL3U3O', 'indifférent')">BDD</a>
            <a href="#!/about" ng-click="searchFichiers('MLK5UCO', 'indifférent')">Maths appliqués</a>
            <a href="#!/about" ng-click="searchFichiers('MLK5UFC', 'indifférent')">Maths et modéli.</a>
            <a href="#!/about" ng-click="searchFichiers('MLK5UYF', 'indifférent')">Esp. de Banache</a>
            <a href="#!/about" ng-click="searchFichiers('MLL5U1O', 'indifférent')">Gélo</a>
            <a href="#!/about" ng-click="searchFichiers('MLL5U2O', 'indifférent')">POO avancée</a>
            <a href="#!/about" ng-click="searchFichiers('MLL5U3O', 'indifférent')">Algo avancée</a>
            <a href="#!/about" ng-click="searchFichiers('MLL5U5O', 'indifférent')">Réseaux</a>
            
            <p class="semestre">2e Semestre</p>
            
            <a href="#!/about" ng-click="searchFichiers('MLJ6U6CI', 'indifférent')">Bio 6</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ6UHC', 'indifférent')">Bio-Informatique</a>
            <!--<a href="#!/about" ng-click="searchFichiers('MLK6UHC', 'indifférent')">Bio-Informatique B</a> a l'air de ne pas exister-->
            <a href="#!/about" ng-click="searchFichiers('MLK6U71C', 'indifférent')">Eco internatio.</a>
            <a href="#!/about" ng-click="searchFichiers('MLK6U72C', 'indifférent')">Eco publique</a>
            <a href="#!/about" ng-click="searchFichiers('MLK6UDC', 'indifférent')">Projet economie</a>
            <a href="#!/about" ng-click="searchFichiers('MLJ6U8C', 'indifférent')">Physique 6</a>
            <a href="#!/about" ng-click="searchFichiers('MLK6UGC', 'indifférent')">Algebre 6</a>
            <a href="#!/about" ng-click="searchFichiers('MLK6UEC', 'indifférent')">Analyse 6</a>
            <a href="#!/about" ng-click="searchFichiers('MLK6U1O', 'indifférent')">Esp. de Hilbert</a>
            <a href="#!/about" ng-click="searchFichiers('MLK6U3O', 'indifférent')">Trans. Fourier</a>
            <a href="#!/about" ng-click="searchFichiers('MLK6U2O', 'indifférent')">Méthodes num.</a>
            <a href="#!/about" ng-click="searchFichiers('MLK6U4O', 'indifférent')">Stats inféren.</a>
            <a href="#!/about" ng-click="searchFichiers('MLK6U5O', 'indifférent')">Logiciels stats</a>
            <a href="#!/about" ng-click="searchFichiers('MLK6UFC', 'indifférent')">Sys dynamiques</a>
            <!--<a href="#!/about" ng-click="searchFichiers('MLK6UWO', 'indifférent')">Anglais 3 - A</a> Inutile vu la qtté de fic-->
            <a href="#!/about" ng-click="searchFichiers('MLL6E12O', 'indifférent')">Anglais 3</a>
            <a href="#!/about" ng-click="searchFichiers('MLK6UYF', 'indifférent')">Proj. esp. fonc.</a>
            <a href="#!/about" ng-click="searchFichiers('MLL6UCC', 'indifférent')">Réseaux avancés</a>
            <a href="#!/about" ng-click="searchFichiers('MLL6E11O', 'indifférent')">Communication</a>
            <!--<a href="#!/about" ng-click="searchFichiers('MLL6E13O', 'indifférent')">Projet tutoré</a>-->
            <a href="#!/about" ng-click="searchFichiers('MLL4U2O', 'indifférent')">Projet</a>
            <a href="#!/about" ng-click="searchFichiers('MLL6U1O', 'indifférent')">Préprofessionnalisation</a>
            <a href="#!/about" ng-click="searchFichiers('MLL6U3C', 'indifférent')">IA</a>
            <a href="#!/about" ng-click="searchFichiers('MLL6U4C', 'indifférent')">Trait. num. données</a>
            <a href="#!/about" ng-click="searchFichiers('MLL6UBC', 'indifférent')">Image</a>
            <a href="#!/about" ng-click="searchFichiers('MLL6UDC', 'indifférent')">Sys. num. com.</a>
            <a href="#!/about" ng-click="searchFichiers('MLL6UEC', 'indifférent')">Gest fin + cont gest</a>
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