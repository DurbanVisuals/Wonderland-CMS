<?php

$app = require(F3.'/base.php');
$app->set('DEBUG',4);
$app->set('SYSTEM', SYSTEM);
$cfg = ROOT.'config/config.ini';
$app->config($cfg, true);
$authors = !$app->devoid('AUTHORS')?true:false;
//todo figure out why this UI needs to be here as the one in config isn't loading.
$app->set('UI', UI);
//new Session(NULL,'CSRF',new Cache('folder='.CACHE.'sessions/'));
$app->run();
