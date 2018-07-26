<?php
function get_browsername() {
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'WOW64') !== FALSE){
    $browser = 'Internet Explorer';
    }elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE) {
    $browser = 'Internet Explorer';
    }elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== FALSE) {
    $browser = 'Chrome';
    }elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== FALSE) {
    $browser = 'Firefox';
    }elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== FALSE) {
    $browser = 'Opera';
    }elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== FALSE) {
    $browser = 'Safari';
    }elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Edge') !== FALSE) {
    $browser = 'Edge';
    }else {
    $browser = 'Other'; //<-- Browser not found.
    }
    return $browser;
}

$navigateur = get_browsername();
?>