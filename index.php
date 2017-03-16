<?php

$system = './system';

define('ROOT', str_replace('\\','/',__DIR__.'/'));

define('SYSTEM', str_replace('\\','/',realpath($system).'/'));

if ( ! file_exists(SYSTEM.'boot.php')) {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, '503');
    exit('Your system folder path does not appear to be set correctly. Please open the following file and correct this: '.pathinfo(__FILE__, PATHINFO_BASENAME));
}

require(SYSTEM.'boot.php');
