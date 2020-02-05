<?php

namespace MilesChou\Docusema;

use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\Schema\Index;
use Doctrine\DBAL\Schema\Table;

class Schema
{
    /**
     * @var string
     */
    private $database;

    /**
     * @var Table
     */
    private $table;

    /**
     * @param Table $table
     * @param string $database
     */
    public function __construct(Table $table, string $database)
    {
        $this->table = $table;
        $this->database = $database;
    }

    public function comment(): string
    {
        // Workaround for PHP 7.1
        return $this->table->hasOption('comment') ? $this->table->getOption('comment') : '';
    }

    /**
     * @return Column[]
     */
    public function columns(): iterable
    {
        return $this->table->getColumns();
    }

    public function database(): string
    {
        return $this->database;
    }

    /**
     * @return Index[]
     */
    public function indexes(): iterable
    {
        return $this->table->getIndexes();
    }

    public function table(): string
    {
        return $this->table->getName();
    }
}
