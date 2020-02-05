<?php

namespace MilesChou\Docusema;

use Illuminate\Container\Container;
use MilesChou\Docusema\Commands\GenerateCommand;
use Symfony\Component\Console\Application;

class App extends Application
{
    /**
     * @var Container
     */
    private $container;

    public function __construct(Container $container)
    {
        parent::__construct('Docusema', 'dev-master');

        $this->container = $container;

        $this->addCommands([
            new GenerateCommand($container),
        ]);
    }

    /**
     * @return Container
     */
    public function getContainer(): Container
    {
        return $this->container;
    }
}
