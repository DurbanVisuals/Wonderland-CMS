<?php

$app = require(F3.'/base.php');

$app->set('SYSTEM', SYSTEM);

$app->config(SYSTEM.'cms/config.ini', true);

new Session(NULL,'CSRF',new Cache('folder=cache/sessions/'));

Klay::instance()->start();
