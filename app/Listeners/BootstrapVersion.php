<?php

namespace App\Listeners;

use Illuminate\Console\Events\ArtisanStarting;
use App\Version;

class BootstrapVersion
{
    public function handle(ArtisanStarting $event): void
    {
        $event->artisan->setName('Schemarkdown');

        if (class_exists(Version::class)) {
            $event->artisan->setVersion(Version::VERSION);
        }
    }
}
