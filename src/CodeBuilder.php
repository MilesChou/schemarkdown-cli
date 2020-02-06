<?php

namespace MilesChou\Docusema;

use Doctrine\DBAL\DBALException;
use Illuminate\Container\Container;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

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
     * @var string
     */
    private $namespace;

    /**
     * @var bool
     */
    private $withConnectionNamespace;

    /**
     * @param Container $container
     * @param DatabaseManager $databaseManager
     */
    public function __construct(Container $container, DatabaseManager $databaseManager)
    {
        $this->databaseManager = $databaseManager;

        $this->connections = $container['config']['database.connections'];
        $this->withConnectionNamespace = count($this->connections) > 1;
    }

    /**
     * @return array [filepath => code]
     */
    public function build(): array
    {
        return collect($this->connections)->flatMap(function ($config, $connection) {
            return $this->transferDatabaseToCode($connection);
        })->toArray();
    }

    /**
     * @param string $namespace
     * @return static
     */
    public function setNamespace($namespace): CodeBuilder
    {
        $this->namespace = $namespace;

        return $this;
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
     * @return mixed
     * @throws DBALException
     */
    private function transferDatabaseToCode($connection)
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


        return collect($schemaManager->listTableNames())
            ->reduce(function ($carry, $table) use ($connection, $databaseConnection, $schemaManager) {
                $relativePath = $this->createRelativePath($connection, $table);

                $carry[$relativePath] = View::make('table', [
                    'schema' => new Schema(
                        $schemaManager->listTableDetails($table),
                        $databaseConnection->getDatabaseName()
                    )
                ])->render();

                return $carry;
            }, []);
    }
}
