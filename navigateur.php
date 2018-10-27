<?php
function get_browsername() {
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'rv:11.0') !== FALSE){
    $browser = 'Internet Explorer';
    }elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE) {
    $browser = 'Internet Explorer';
    }elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Edge') !== FALSE) {
    $browser = 'Edge';
    }elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== FALSE) {
    $browser = 'Chrome';
    }elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== FALSE) {
    $browser = 'Firefox';
    }elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== FALSE) {
    $browser = 'Opera';
    }elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== FALSE) {
    $browser = 'Safari';
    }else {
    $browser = 'Other'; //<-- Browser not found.
    }
    return $browser;
}
//print($_SERVER['HTTP_USER_AGENT']);

$navigateur = get_browsername();

//print($navigateur);
?>