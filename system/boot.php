<?php

$app = require(F3.'/base.php');
$app->set('DEBUG',4);
$app->set('SYSTEM', SYSTEM);
$cfg = ROOT.'config/config.ini';
echo $cfg;
$app->config($cfg, true);
$authors = !$app->devoid('AUTHORS')?true:false;
echo $authors?"<br/>Config set":"<br/>Config NOT set";
new Session(NULL,'CSRF',new Cache('folder='.ROOT.'/cache/sessions/'));
$app->run();
