<?php
include_once("bdd.php");
include_once("logs.php");

logs("dissident", "nouveau dissident banni");

$header_full = "";
foreach ($_SERVER as $key => $value) {
    if (strpos($key, 'HTTP_') === 0) {
        $chunks = explode('_', $key);
        $header = '';
        for ($i = 1; $y = sizeof($chunks) - 1, $i < $y; $i++) {
            $header .= ucfirst(strtolower($chunks[$i])).'-';
        }
        $header .= ucfirst(strtolower($chunks[$i])).': '.$value;
        $header_full .= $header."\n";
    }
}

// test existence du bot dans la BDD
$req = $bdd->prepare("SELECT id FROM bots WHERE ip = :ip");
$req->execute(array("ip" => $_SERVER["REMOTE_ADDR"]));
if($req->rowCount()){ /* Si l'user est déjà dans la liste des bots */
    // Enregistrement individuelle de la requete en tant que bot dissident
    $req = $bdd->prepare('INSERT INTO bots_dissidents(  ip,
                                                        date,
                                                        header,
                                                        post,
                                                        gets,
                                                        files) 
                            VALUES( :ip,
                                    NOW(),
                                    :header,
                                    :post,
                                    :gets,
                                    :files)');
    $req->execute(array(
        "ip" => $_SERVER["REMOTE_ADDR"],
        "header" => $header_full,
        "post" => serialize($_POST),
        "gets" => serialize($_GET),
        "files" => serialize($_FILES)
    ));
    // Activation statut dissident
    $req = $bdd->prepare("UPDATE bots SET nb_acces = nb_acces+1, dissident = 1 WHERE ip = :ip");
    $req->execute(array("ip" => $_SERVER["REMOTE_ADDR"]));


    header('Location: unetunfontdeux.txt');
    exit;
} else { /* Si l'user n'est pas dans la liste des bots */ 

    // Enregistrement individuelle de la requete en tant que bot dissident
    $req = $bdd->prepare('INSERT INTO bots_dissidents(  ip,
                                                        date,
                                                        header,
                                                        post,
                                                        gets,
                                                        files) 
                            VALUES( :ip,
                                    NOW(),
                                    :header,
                                    :post,
                                    :gets,
                                    :files)');
    $req->execute(array(
        "ip" => $_SERVER["REMOTE_ADDR"],
        "header" => $header_full,
        "post" => serialize($_POST),
        "gets" => serialize($_GET),
        "files" => serialize($_FILES)
    ));
    // Enregistrement de l'IP du bot et statut de dissident = 1
    $req = $bdd->prepare('INSERT INTO bots( ip,
                                            date,
                                            systeme,
                                            nb_acces,
                                            dissident) 
                            VALUES( :ip,
                                    NOW(),
                                    :systeme,
                                    1,
                                    1)');
    $req->execute(array(
        "ip" => $_SERVER["REMOTE_ADDR"],
        "systeme" => $_SERVER["HTTP_USER_AGENT"]
    ));


    header('Location: unetunfontdeux.txt');
    exit;
}
?>