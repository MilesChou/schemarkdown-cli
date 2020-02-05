<?php

namespace MilesChou\Docusema\Commands\Concerns;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Fluent;
use RuntimeException;

trait DatabaseConnection
{
    /**
     * @var array
     */
    protected $connections;

    /**
     * @param Container $container
     * @param string $configFile
     */
    protected function prepareConnection(Container $container, $configFile): void
    {
        $this->connections = $this->normalizeConnectionConfig($configFile);

        $container->singleton('db', function () {
            $capsule = new \Illuminate\Database\Capsule\Manager();

            foreach ($this->connections as $connectionName => $setting) {
                $capsule->addConnection($setting, $connectionName);
            }

            $capsule->setAsGlobal();

            return $capsule;
        });
    }

    /**
     * @param null|string $connection
     */
    protected function filterConnection($connection = null)
    {
        if (null === $connection) {
            return;
        }

        if (empty($this->connections[$connection])) {
            throw new \RuntimeException("Connection '{$connection}' is not found in config file");
        }

        $this->connections = [
            $connection => $this->connections[$connection],
        ];
    }

    /**
     * @param string $configFile
     * @return array
     */
    protected function normalizeConnectionConfig($configFile): array
    {
        $config = require $configFile;

        $config = new Fluent($config);

        if (!isset($config['connections'])) {
            throw new RuntimeException("The key 'connections' is not set in config file");
        }

        $connections = $config->get('connections');

        if (!is_array($connections)) {
            throw new RuntimeException('Connections config is not an array');
        }

        return $connections;
    }
}
