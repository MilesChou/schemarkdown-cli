<?php

use App\Commands\GenerateCommand;
use App\Providers\BaseServiceProvider;
use Illuminate\Console\Application as IlluminateApplication;
use LaravelBridge\Scratch\Application as LaravelBridge;
use MilesChou\Codegener\CodegenerServiceProvider;
use MilesChou\Schemarkdown\SchemarkdownServiceProvider;
use org\bovigo\vfs\vfsStream;

require dirname(__DIR__) . '/vendor/autoload.php';

return (static function () {
    $vfs = vfsStream::setup('view');

    $container = (new LaravelBridge())
        ->setupViewCompiledPath($vfs->url())
        ->setupProvider(CodegenerServiceProvider::class)
        ->setupProvider(SchemarkdownServiceProvider::class)
        ->setupProvider(BaseServiceProvider::class)
        ->withFacades()
        ->bootstrap();

    $app = new IlluminateApplication($container, $container->make('events'), 'dev-master');
    $app->add(new GenerateCommand($container));
    $app->setDefaultCommand('generate');

    return $app;
})();
