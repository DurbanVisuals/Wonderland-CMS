<?php

$app = require('base/base.php');

$app->set('SYSTEM', str_replace(ROOT,'',SYSTEM));

$app->config($app->get('SYSTEM').'klay/config.ini', true);

new Session(NULL,'CSRF',new Cache('folder=cache/sessions/'));

Klay::instance()->start();
