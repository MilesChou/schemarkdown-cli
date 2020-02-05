<?php

namespace MilesChou\Docusema;

use Illuminate\Container\Container;
use MilesChou\Docusema\Commands\GenerateCommand;
use Symfony\Component\Console\Application;

class App extends Application
{
    public function __construct(Container $container)
    {
        $version = 'dev-master';

        parent::__construct('Docusema', $version);

        $this->addCommands([
            new GenerateCommand($container),
        ]);
    }
}
