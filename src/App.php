<?php

namespace MilesChou\Docusema;

use Illuminate\Container\Container;
use Symfony\Component\Console\Application;

class App extends Application
{
    public function __construct()
    {
        $version = 'dev-master';

        parent::__construct('Docusema', $version);

        $container = Container::getInstance();

        $this->bootstrap($container);
    }

    public function bootstrap(Container $container): void
    {
    }
}
