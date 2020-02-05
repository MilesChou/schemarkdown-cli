<?php

use LaravelBridge\Scratch\Application as LaravelBridge;
use MilesChou\Docusema\App;

require __DIR__ . '/../vendor/autoload.php';

$container = new LaravelBridge();
$container->setupDatabase([]);
$container->bootstrap();

$app = new App($container);
$app->run();
