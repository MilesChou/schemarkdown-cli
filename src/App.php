<?php

namespace MilesChou\Schemarkdown;

use Illuminate\Container\Container;
use MilesChou\Schemarkdown\Commands\GenerateCommand;
use Symfony\Component\Console\Application;

class App extends Application
{
    public function __construct(Container $container)
    {
        $version = 'dev-master';

        if (class_exists(Version::class)) {
            $version = Version::VERSION;
        }

        parent::__construct('Schemarkdown', $version);

        $this->addCommands([
            new GenerateCommand($container),
        ]);

        $this->setDefaultCommand('generate');
    }
}
