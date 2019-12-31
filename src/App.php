<?php

namespace MilesChou\Docusema;

use Illuminate\Container\Container;
use MilesChou\Docusema\Commands\GenerateCommand;
use Symfony\Component\Console\Application;

class App extends Application
{
    public function __construct()
    {
        $version = 'dev-master';

        parent::__construct('Docusema', $version);

        $container = Container::getInstance();

        $this->bootstrap($container);

        $this->addCommands([
            new GenerateCommand(),
        ]);
    }

    public function bootstrap(Container $container): void
    {
    }
}
