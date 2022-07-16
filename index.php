<?php

require __DIR__ . '/vendor/autoload.php';

use Capangas\Touchfic\app\Application;

$router = require_once __DIR__ . '/web.php';

require_once __DIR__ . '/database.php';

$app = new Application($router);

$app->send();