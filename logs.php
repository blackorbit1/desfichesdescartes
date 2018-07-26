<?php
include_once("navigateur.php");

function crawler_detector() {
    // User lowercase string for comparison.
    $user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
    // A list of some common words used only for bots and crawlers.
    $bot_identifiers = array(
        'bot',
        'slurp',
        'crawler',
        'spider',
        'curl',
        'facebook',
        'fetch',
    );

    // See if one of the identifiers is in the UA string.
    foreach ($bot_identifiers as $identifier) {
        if (strpos($user_agent, $identifier) !== FALSE) {
            return TRUE;
        }
    }
    $server_host = $_SERVER["HTTP_HOST"];
    $host_name = gethostname();
    if(preg_match("#(?:googlebot|google\.com|slurp|crawler|w3af|havij|baidu|bingbot|feedfetcher|exabot|yandex|FacebookExternalHit|Discordbot|xml\-sitemaps|uCrawler|DuckDuckGo|SurdotlyBot)#iu", $server_host.$host_name)){
        return TRUE;
    }
    return FALSE;
}

function logs($auteur, $action){
    include("bdd.php");
    if(crawler_detector()){
        $auteur = "bot";
    }
    $req = $bdd->prepare('INSERT INTO logs_admins(  admin,
                                                    date,
                                                    IP,
                                                    navigateur,
                                                    action) 
                            VALUES( :admin,
                                    NOW(),
                                    :ip,
                                    :navigateur,
                                    :action)');
    $req->execute(array(
        "admin" => $auteur,
        "ip" => $_SERVER["REMOTE_ADDR"],
        "navigateur" => get_browsername(),
        "action" => $action
    ));
    $req->closeCursor();
}

if(isset($_GET)){
    /* une personne a tenté d'acceder au fichier php des logs -> avec des parametres GET -> les mettres */
    /* === === === Le fait à chaque include donc inutile === === ===
    if(isset($_SESSION['pseudo'])){
        logs($_SESSION['pseudo'], "A tenté d'acceder au fichier php avec les parametres GET suivants :" . serialize($_GET));
    } else {
        logs("inconnu", "A tenté d'acceder au fichier php avec les parametres GET suivants :" . serialize($_GET));
    }
    */
} elseif(!isset($_POST)) {
    if(isset($_SESSION['pseudo'])){
        logs($_SESSION['pseudo'], "A tenté d'acceder au fichier php avec les parametres POST suivants :" . serialize($_POST));
    } else {
        logs("inconnu", "A tenté d'acceder au fichier php avec les parametres POST suivants :" . serialize($_POST));
    }
}



?>