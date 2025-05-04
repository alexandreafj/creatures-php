<?php

use App\Conf\LoadEnv;
use App\App;

require __DIR__ . '/../vendor/autoload.php';

LoadEnv::load();
$app = new App();
$app->run();