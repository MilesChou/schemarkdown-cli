<?php

namespace MilesChou\Docusema;

use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Illuminate\Database\Connection;

class Schema
{
    /**
     * @var AbstractSchemaManager
     */
    private $schema;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $doctrineConnection = $connection->getDoctrineConnection();

        $this->schema = $doctrineConnection->getSchemaManager();
    }

    /**
     * @return mixed
     */
    public function getTables()
    {
        return $this->schema->listTableNames();
    }
}
