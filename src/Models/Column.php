<?php

namespace MilesChou\Schemarkdown\Models;

use BadMethodCallException;
use Doctrine\DBAL\Schema\Column as DoctrineColumn;

/**
 * @mixin DoctrineColumn
 */
class Column
{
    /**
     * @var DoctrineColumn
     */
    private $doctrineColumn;

    public function __construct(DoctrineColumn $doctrineColumn)
    {
        $this->doctrineColumn = $doctrineColumn;
    }

    public function __call($name, $arguments)
    {
        if (method_exists($this->doctrineColumn, $name)) {
            return $this->doctrineColumn->$name(...$arguments);
        }

        throw new BadMethodCallException('Undefined method ' . $name . ' in class ' . static::class);
    }
}
