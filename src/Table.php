<?php

namespace MilesChou\Schemarkdown;

use Doctrine\DBAL\Schema\Column as DoctrineColumn;
use Doctrine\DBAL\Schema\Index as DoctrineIndex;
use Doctrine\DBAL\Schema\Table as DoctrineTable;
use MilesChou\Schemarkdown\Models\Column;
use MilesChou\Schemarkdown\Models\Index;

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
     * @return DoctrineColumn[]
     */
    public function columns(): iterable
    {
        return collect($this->table->getColumns())->transform(function ($value) {
            return new Column($value);
        });
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
     * @return DoctrineIndex[]
     */
    public function indexes(): iterable
    {
        return collect($this->table->getIndexes())->transform(function ($value) {
            return new Index($value);
        });
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
