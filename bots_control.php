<?php
include_once("bdd.php");
include_once("logs.php");

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
        logs("dissident", "dissident - tentative d'acces au site");
        header('Location: banni.php');
        exit;
    } else { /* Si le bot respecte bien les robots.txt */
        $req = $bdd->prepare("UPDATE bots SET nb_acces = nb_acces+1 WHERE ip = :ip");
        $req->execute(array("ip" => $_SERVER["REMOTE_ADDR"]));
    } 
} else { /* Si l'user n'est pas dans la liste des bots */ 

    // Tester si l'user est un bot
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
            'python',
            'googlebot',
            'w3af',
            'havij',
            'baidu',
            'bingbot',
            'feedfetcher',
            'exabot',
            'yandex',
            'FacebookExternalHit',
            'Discordbot',
            'uCrawler',
            'DuckDuckGo',
            'SurdotlyBot',
            'BingPreview',
            'Zermelo',
            'Zeus',
            'zgrab',
            'ZnajdzFoto',
            'Zombie\.js',
            'ZyBorg',
            'SpamExperts',
            'Zade',
            'Zao',
            'Zauba',
            'Zemanta Aggregator',
            'yanga',
            'yeti',
            'Yo-yo',
            'Yoleo Consumer',
            'yoogliFetchAgent',
            'YottaaMonitor',
            'Yaanb',
            'yacy',
            'Yahoo',
            'yahoo',
            'YandeG',
            'Site24x7',
            'Site Sucker',
            'SiteBar',
            'Sitebeam',
            'Sitebulb\/',
            'SiteCondor',
            'SiteExplorer',
            'SiteGuardian',
            'Siteimprove',
            'SiteIndexed',
            'Sitemap',
            'SiteMonitor',
            'Siteshooter B0t',
            'SiteSnagger',
            'SiteSucker',
            'SiteTruth',
            'Sitevigil',
            'ShopWiki',
            'ShortLinkTranslate',
            'shrinktheweb',
            'Sideqik',
            'SilverReader',
            'SimplePie',
            'SimplyFast',
            'Siphon',
            'SISTRIX',
            'Searchestate',
            'SearchSight',
            'Seeker',
            'internet_archive',
            'InternetSeer',
            'internetVista monitor',
            'intraVnews',
            'IODC',
            'IOI',
            'iplabel',
            'ips-agent',
            'HTTP_Compression_Test',
            'http_request2',
            'http_requester',
            'HttpComponents',
            'httphr',
            'HTTPMon',
            'httpscheck',
            'httpssites_power',
            'httpunit',
            'HttpUrlConnection',
            'httrack',

        );
    
        // See if one of the identifiers is in the UA string.
        foreach ($bot_identifiers as $identifier) {
            if (strpos($user_agent, $identifier) !== FALSE) {
                return TRUE;
            }
        }
        /*
        $server_host = $_SERVER["HTTP_HOST"];
        $host_name = gethostname();
        if(preg_match("#(?:googlebot|google\.com|slurp|crawler|w3af|havij|baidu|bingbot|feedfetcher|exabot|yandex|FacebookExternalHit|Discordbot|xml\-sitemaps|uCrawler|DuckDuckGo|SurdotlyBot)#iu", $server_host.$host_name)){
            return TRUE;
        }
        */
        return FALSE;
    }

    if(crawler_detector()){
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

    

}




?>
