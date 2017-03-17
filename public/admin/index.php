<?php

$root =  str_replace('\\','/',__DIR__.'/');
$root =  str_replace('/public/admin','',$root);
define('ROOT', $root);
define('PUB_ROOT', ROOT."public/");
define('FILES', PUB_ROOT."files/");
define('VENDORS', ROOT."vendors/");
define('F3', VENDORS."f3/");
define('PHPDOM', VENDORS."simplehtmldom_1_5/");
define('TEMP', ROOT."tmp/");
define('CACHE', TEMP."cache/");
define('SYSTEM', ROOT."system/");
define('UI', SYSTEM."UI/");
define('CMS', SYSTEM."CMS/");
define('ADMIN', SYSTEM."admin/");
define('MODELS', SYSTEM."models/");
define('TABLES', SYSTEM."tables/");
define('LANGS', SYSTEM."langs/");
define('FIELDS', SYSTEM."fields/");
define('ADDONS', SYSTEM."addons/");
define('PLUGINS', ADDONS."plugins/");
define('WONDERLAND', true);

if ( ! file_exists(SYSTEM.'boot.php')) {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, '503');
    exit('Your system folder path does not appear to be set correctly. Please open the following file and correct this: '.pathinfo(__FILE__, PATHINFO_BASENAME));
}

require_once(SYSTEM.'boot.php');
