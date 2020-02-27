<?php

namespace MilesChou\Schemarkdown\Listeners;

use Illuminate\Console\Events\CommandStarting;
use LaravelBridge\Scratch\Application;
use Symfony\Component\Console\Logger\ConsoleLogger;

class BootstrapLogger
{
    /**
     * @var Application
     */
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function handle(CommandStarting $event): void
    {
        $this->app->setupLogger('schemarkdown', new ConsoleLogger($event->output), true);
    }
}
