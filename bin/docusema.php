<?php

use Illuminate\Container\Container;
use MilesChou\Docusema\App;

require __DIR__ . '/../vendor/autoload.php';

Container::setInstance(new Container());

$app = new App();
$app->run();
