<?php
$server_host = $_SERVER["HTTP_HOST"];
$host_name = gethostname();

if(preg_match("#(?:localhost|8888)#iu", $server_host.$host_name)){
    print("oui");
}

print($server_host.$host_name);
?>