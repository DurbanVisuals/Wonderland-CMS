<?php

$app = require(F3.'/base.php');
$app->set('DEBUG',4);
$app->set('SYSTEM', SYSTEM);
echo ROOT.'config/config.ini';
$app->config(ROOT.'config/config.ini', true);

new Session(NULL,'CSRF',new Cache('folder=cache/sessions/'));

$app->run();
