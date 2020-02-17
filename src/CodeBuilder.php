<?php

namespace MilesChou\Schemarkdown;

use Doctrine\DBAL\DBALException;
use Illuminate\Container\Container;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Psr\Log\LoggerInterface;

class CodeBuilder
{
    /**
     * @var array
     */
    private $connections;

    /**
     * @var DatabaseManager
     */
    private $databaseManager;

    /**
     * @var bool
     */
    private $withConnectionNamespace;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param Container $container
     * @param DatabaseManager $databaseManager
     */
    public function __construct(Container $container, DatabaseManager $databaseManager)
    {
        $this->databaseManager = $databaseManager;

        $this->connections = $container['config']['database.connections'];
        $this->logger = $container->make('log');
        $this->withConnectionNamespace = count($this->connections) > 1;
    }

    /**
     * @return array [filepath => code]
     */
    public function build(): array
    {
        return collect($this->connections)->flatMap(function ($config, $connection) {
            $this->logger->info("Build connection '{$connection}' to markdown ...");

            return $this->buildConnection($connection);
        })->toArray();
    }

    /**
     * @param string $connection
     * @return mixed
     * @throws DBALException
     */
    private function buildConnection($connection)
    {
        $databaseConnection = $this->databaseManager->connection($connection);

        $doctrineConnection = $databaseConnection->getDoctrineConnection();

        $databasePlatform = $doctrineConnection->getDatabasePlatform();
        $databasePlatform->registerDoctrineTypeMapping('json', 'text');
        $databasePlatform->registerDoctrineTypeMapping('jsonb', 'text');
        $databasePlatform->registerDoctrineTypeMapping('enum', 'string');
        $databasePlatform->registerDoctrineTypeMapping('bit', 'boolean');

        // Postgres types
        $databasePlatform->registerDoctrineTypeMapping('_text', 'text');
        $databasePlatform->registerDoctrineTypeMapping('_int4', 'integer');
        $databasePlatform->registerDoctrineTypeMapping('_numeric', 'float');
        $databasePlatform->registerDoctrineTypeMapping('cidr', 'string');
        $databasePlatform->registerDoctrineTypeMapping('inet', 'string');

        $schemaManager = $doctrineConnection
            ->getSchemaManager();

        $reduce = collect($schemaManager->listTableNames())
            ->reduce(function ($carry, $table) use ($connection, $databaseConnection, $schemaManager) {
                $relativePath = $this->createRelativePath($connection, $table);

                $this->logger->info("Build schema markdown '{$relativePath}' ...");

                $carry[$relativePath] = View::make('table', [
                    'schema' => new Table(
                        $schemaManager->listTableDetails($table),
                        $databaseConnection->getDatabaseName()
                    ),
                ])->render();

                return $carry;
            }, []);

        $relativePath = $this->createReadmePath($connection);

        $this->logger->info("Build readme markdown '{$relativePath}' ...");

        $reduce[$relativePath] = View::make('database', [
            'database' => new Database($schemaManager, $databaseConnection->getDatabaseName()),
        ])->render();

        return $reduce;
    }

    /**
     * @param string $connection
     * @param string $table
     * @return string
     */
    private function createRelativePath($connection, $table): string
    {
        if ($this->withConnectionNamespace) {
            return '/' . Str::snake($connection) . '/' . Str::snake($table) . '.md';
        }

        return '/' . Str::snake($table) . '.md';
    }

    /**
     * @param string $connection
     * @return string
     */
    private function createReadmePath($connection): string
    {
        if ($this->withConnectionNamespace) {
            return '/' . Str::snake($connection) . '/README.md';
        }

        return '/README.md';
    }
}
