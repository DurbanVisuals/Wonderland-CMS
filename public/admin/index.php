<?php

$root =  str_replace('\\','/',__DIR__.'/');
$root =  str_replace('/public/admin','',$root);
define('ROOT', $root);
define('PUB_ROOT', $root."public/");
define('VENDORS', $root."vendors/");
define('F3', VENDORS."f3/");
define('SYSTEM', $root."system/");
define('MODELS', $root."system/models");
define('TABLES', $root."system/tables");
define('LANGS', $root."system/langs");
define('FIELDS', $root."system/fields");
define('WONDERLAND', true);
if ( ! file_exists(SYSTEM.'boot.php')) {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, '503');
    exit('Your system folder path does not appear to be set correctly. Please open the following file and correct this: '.pathinfo(__FILE__, PATHINFO_BASENAME));
}

require_once(SYSTEM.'boot.php');
