<?php

namespace MilesChou\Schemarkdown;

use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\Schema\Index;
use Doctrine\DBAL\Schema\Table as DoctrineTable;

class Table
{
    /**
     * @var string
     */
    private $database;

    /**
     * @var DoctrineTable
     */
    private $table;

    /**
     * @param DoctrineTable $table
     * @param string $database
     */
    public function __construct(DoctrineTable $table, string $database)
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

    /**
     * Database name
     *
     * @return string
     */
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

    /**
     * Table name
     *
     * @return string
     */
    public function table(): string
    {
        return $this->table->getName();
    }
}
