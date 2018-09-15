<?php
include_once("bdd.php");

$req = $bdd->prepare("SELECT dissident FROM bots WHERE ip = :ip");
$req->execute(array("ip" => $_SERVER["REMOTE_ADDR"]));
if($req->rowCount()){
    $donnees = $req->fetch();
    if($donnees["dissident"]){ /* Si le bot ne respecte pas les robots.txt */
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
        $req = $bdd->prepare("UPDATE bots SET nb_acces = nb_acces+1 WHERE ip = :ip");
        $req->execute(array("ip" => $_SERVER["REMOTE_ADDR"]));
        header('Location: unetunfontdeux.txt');
    } else { /* Si le bot respecte bien les robots.txt */
        $req = $bdd->prepare("UPDATE bots SET nb_acces = nb_acces+1 WHERE ip = :ip");
        $req->execute(array("ip" => $_SERVER["REMOTE_ADDR"]));
    } 
} else { /* Si le bot n'a pas encore été enregistré dans la liste */ 
    $req = $bdd->prepare('INSERT INTO bots( ip,
                                            date,
                                            systeme,
                                            nb_acces) 
                            VALUES( :ip,
                                    NOW(),
                                    :systeme,
                                    1)');
    $req->execute(array(
        "ip" => $_SERVER["REMOTE_ADDR"],
        "systeme" => $_SERVER["HTTP_USER_AGENT"]
    ));
}




?>
User-agent: *

Disallow: /inutile/
Disallow: /uploads/
Disallow: /logs/
Disallow: /he/
Disallow: /admin/
Disallow: /cicada/
Disallow: /megatruchiddenquepersonneconnaismemeleFBI/

Disallow: /admin.php
Disallow: /user.php

Disallow: /*.sql$
Disallow: /*.pdf$

Disallow: /Les_gens_qui_fouinnent_dans_le_code__O_o

Allow: /*
