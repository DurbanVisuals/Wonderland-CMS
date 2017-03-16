<?php

$root =  str_replace('\\','/',__DIR__.'/')
define('ROOT', '../'.$root);
define('SYSTEM', $root."/system/"));
define('f3', $root."/vendors/f3/"));

if ( ! file_exists(f3.'boot.php')) {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, '503');
    exit('Your system folder path does not appear to be set correctly. Please open the following file and correct this: '.pathinfo(__FILE__, PATHINFO_BASENAME));
}

require(f3.'boot.php');
