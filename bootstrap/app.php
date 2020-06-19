<?php

use Illuminate\Console\Application as IlluminateApplication;
use LaravelBridge\Scratch\Application as LaravelBridge;
use MilesChou\Codegener\CodegenerServiceProvider;
use MilesChou\Schemarkdown\Commands\GenerateCommand;
use MilesChou\Schemarkdown\Providers\BaseServiceProvider;
use org\bovigo\vfs\vfsStream;

require_once dirname(__DIR__) . '/vendor/autoload.php';

// Fix https://github.com/MilesChou/schemarkdown/issues/2
$helpers = getcwd() . '/vendor/laravel/framework/src/Illuminate/Foundation/helpers.php';
if (file_exists($helpers)) {
    require_once $helpers;
}

return (function () {
    $vfs = vfsStream::setup('view');

    $container = (new LaravelBridge())
        ->setupView(dirname(__DIR__) . '/src/templates', $vfs->url())
        ->setupProvider(CodegenerServiceProvider::class)
        ->setupProvider(BaseServiceProvider::class)
        ->withFacades()
        ->bootstrap();

    $app = new IlluminateApplication($container, $container->make('events'), 'dev-master');
    $app->add(new GenerateCommand($container));
    $app->setDefaultCommand('generate');

    return $app;
})();
