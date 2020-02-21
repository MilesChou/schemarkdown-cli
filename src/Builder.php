<?php

namespace MilesChou\Schemarkdown;

use Doctrine\DBAL\DBALException;
use Illuminate\Container\Container;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use MilesChou\Schemarkdown\Models\Schema;
use MilesChou\Schemarkdown\Models\Table;
use Psr\Log\LoggerInterface;

class Builder
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
     * @throws DBALException
     */
    public function build(): iterable
    {
        foreach (array_keys($this->connections) as $connection) {
            $this->logger->info("Build connection '{$connection}' to markdown ...");

            yield from $this->buildConnection($connection);
        }
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

        $schemaManager = $doctrineConnection->getSchemaManager();

        $relativePath = $this->createReadmePath($connection);

        $this->logger->info("Build readme markdown '{$relativePath}' ...");

        yield $relativePath => View::make('schema', [
            'schema' => new Schema($schemaManager, $databaseConnection->getDatabaseName()),
        ])->render();

        foreach ($schemaManager->listTableNames() as $tableName) {
            $relativePath = $this->createRelativePath($connection, $tableName);

            $this->logger->info("Build schema markdown '{$relativePath}' ...");

            yield $relativePath => View::make('table', [
                'table' => new Table(
                    $schemaManager->listTableDetails($tableName),
                    $databaseConnection->getDatabaseName()
                ),
            ])->render();
        }
    }

    /**
     * @param string $connection
     * @param string $table
     * @return string
     */
    private function createRelativePath($connection, $table): string
    {
        if ($this->withConnectionNamespace) {
            return Str::snake($connection) . '/' . Str::snake($table) . '.md';
        }

        return Str::snake($table) . '.md';
    }

    /**
     * @param string $connection
     * @return string
     */
    private function createReadmePath($connection): string
    {
        if ($this->withConnectionNamespace) {
            return Str::snake($connection) . '/README.md';
        }

        return 'README.md';
    }
}
