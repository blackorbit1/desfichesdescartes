<?php
    ob_start();
    system('ipconfig /all');
    $mycom=ob_get_contents();
    ob_clean();
      
    $findme = 'physique';
    $pmac = strpos($mycom, $findme);
    $mac=substr($mycom,($pmac+32),20);
    echo $mac;
?>