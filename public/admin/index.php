<?php

$root =  str_replace('\\','../',__DIR__.'/');

define('ROOT', $root);
define('VENDORS', $root."vendors/");
define('F3', VENDORS."f3/");
define('SYSTEM', $root."system/");
define('WONDERLAND', true);
if ( ! file_exists(SYSTEM.'boot.php')) {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, '503');
    exit('Your system folder path does not appear to be set correctly. Please open the following file and correct this: '.pathinfo(__FILE__, PATHINFO_BASENAME));
}

require(SYSTEM.'boot.php');
