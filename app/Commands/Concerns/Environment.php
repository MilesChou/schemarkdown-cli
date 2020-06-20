<?php

namespace App\Commands\Concerns;

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

        if (getenv('MEMORY_LIMIT')) {
            ini_set('memory_limit', getenv('MEMORY_LIMIT'));
        }
    }
}
