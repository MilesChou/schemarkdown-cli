<?php

namespace MilesChou\Schemarkdown\Providers;

use Illuminate\Console\Events\ArtisanStarting;
use Illuminate\Console\Events\CommandStarting;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use MilesChou\Schemarkdown\Listeners\BootstrapLogger;
use MilesChou\Schemarkdown\Listeners\BootstrapVersion;

class BaseServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Event::listen(ArtisanStarting::class, BootstrapVersion::class);

        Event::listen(CommandStarting::class, BootstrapLogger::class);
    }
}
