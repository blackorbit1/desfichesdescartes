<?php
include_once("bdd.php");
include_once("logs.php");


if(isset($_POST["g-recaptcha-response"])){
    // Ma clé privée
    $secret = "6LcldHAUAAAAAEJW6qVPDNADwRVreNuc0Irwi5U5";
    // Paramètre renvoyé par le recaptcha
    $response = $_POST['g-recaptcha-response'];
    // On récupère l'IP de l'utilisateur
    $remoteip = $_SERVER['REMOTE_ADDR'];

    $api_url = "https://www.google.com/recaptcha/api/siteverify?secret=" 
        . $secret
        . "&response=" . $response
        . "&remoteip=" . $remoteip ;

    $decode = json_decode(file_get_contents($api_url), true);

    if ($decode['success'] == true) { /* c'est un citoyen du monde */
        $req = $bdd->prepare("UPDATE bots SET nb_acces = nb_acces+1, dissident = 0, humain = 1 WHERE ip = :ip");
        $req->execute(array("ip" => $_SERVER["REMOTE_ADDR"]));
        logs("user", "n'est plus dissident car a reussit recaptcha");
        header('Location: index.php');
    }

    else {
        logs("dissident", "dissident a raté recaptcha");
    }
}

		
?>

<!doctype html>
<html lang="fr">
    <head>
        <title>IP bannie</title>
        <meta name="robots" content="none"> <!-- Doctype HTML -->
        <meta name="robots" content="none" /> <!-- Doctype XHTML -->
        <meta name="description" content="un robot ne devrait jamais se retrouver sur cette page" />
        <link rel="icon" type="image/png" href="favicon2.png" />
        <script src='https://www.google.com/recaptcha/api.js'></script>
    </head>
    <body>
        <br>Une personne du reseau a tenté d'aspirer le site ce qui a entrainé un bannissement de l'IP du réseau.
        <br>
        <br>
        <form method="post" action="">
            <div class="g-recaptcha" data-sitekey="6LcldHAUAAAAAHSs6X1HDStyftJlYeaDgYupsNfj"></div>
            <input type="submit" id="valider" value="Acceder au site" />
        </form>

    </body>
</html>