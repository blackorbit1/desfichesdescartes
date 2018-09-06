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
		print('"image": "https://desfichesdescartes.fr/uploads/' . $miniature . '",'); 
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