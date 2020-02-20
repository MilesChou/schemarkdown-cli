<?php

namespace MilesChou\Schemarkdown\Models;

use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Illuminate\Support\Collection;

class Schema
{
    /**
     * @var string
     */
    private $database;

    /**
     * @var AbstractSchemaManager
     */
    private $schemaManager;

    /**
     * @param AbstractSchemaManager $schemaManager
     * @param string $database
     */
    public function __construct(AbstractSchemaManager $schemaManager, string $database)
    {
        $this->schemaManager = $schemaManager;
        $this->database = $database;
    }

    /**
     * @return string
     */
    public function database(): string
    {
        return $this->database;
    }

    /**
     * Table name
     *
     * @return Collection
     */
    public function tables(): Collection
    {
        return collect($this->schemaManager->listTableNames())->sort();
    }
}
