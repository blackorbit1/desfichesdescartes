<?php

function get_browsername2() {
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE){
    $browser = 'internet_explorer';
    }elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== FALSE) {
    $browser = 'chrome';
    }elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== FALSE) {
    $browser = 'firefox';
    }elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== FALSE) {
    $browser = 'opera';
    }elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== FALSE) {
    $browser = 'safari';
    }else {
    $browser = 'autre'; //<-- Browser not found.
    }
    return $browser;
}
$nav = get_browsername2();

function detection_mobile(){
	if (isset($_SERVER['HTTP_X_WAP_PROFILE']) || isset($_SERVER['HTTP_PROFILE']))
		return TRUE;
	if (isset ($_SERVER['HTTP_ACCEPT'])){
		$accept = strtolower($_SERVER['HTTP_ACCEPT']);
		if (strpos($accept, 'wap'))
			return TRUE;
	}
	if (isset ($_SERVER['HTTP_USER_AGENT'])){
		if (strpos ($_SERVER['HTTP_USER_AGENT'], 'Mobile'))
			return TRUE;
		if (strpos ($_SERVER['HTTP_USER_AGENT'], 'Opera Mini'))
			return TRUE;
	}
	return FALSE;
}

//$bdd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
$req = $bdd->exec('UPDATE compteur_vues SET general = general + 1, '. $nav .' = '. $nav .' + 1 WHERE id = 1');

?>