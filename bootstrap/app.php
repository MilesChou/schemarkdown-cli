<?php

use Illuminate\Console\Application as IlluminateApplication;
use LaravelBridge\Scratch\Application as LaravelBridge;
use MilesChou\Codegener\CodegenerServiceProvider;
use MilesChou\Schemarkdown\Commands\GenerateCommand;
use MilesChou\Schemarkdown\Providers\BaseServiceProvider;
use org\bovigo\vfs\vfsStream;

require dirname(__DIR__) . '/vendor/autoload.php';

return (function () {
    $vfs = vfsStream::setup('view');

    $container = (new LaravelBridge())
        ->setupDatabase([])
        ->setupView(dirname(__DIR__) . '/src/templates', $vfs->url())
        ->setupProvider(CodegenerServiceProvider::class)
        ->setupProvider(BaseServiceProvider::class)
        ->bootstrap();

    $app = new IlluminateApplication($container, $container->make('events'), 'dev-master');
    $app->add(new GenerateCommand($container));
    $app->setDefaultCommand('generate');

    return $app;
})();
