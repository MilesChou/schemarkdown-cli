<?php

namespace MilesChou\Schemarkdown\Commands\Concerns;

use Dotenv\Dotenv;

trait Environment
{
    /**
     * @param string $envFile
     */
    protected function loadDotEnv($envFile): void
    {
        if (is_file($envFile)) {
            $file = basename($envFile);
            $path = dirname($envFile);
            (Dotenv::create($path, $file))->load();
        }
    }
}
