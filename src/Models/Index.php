<?php

namespace MilesChou\Schemarkdown\Models;

use BadMethodCallException;
use Doctrine\DBAL\Schema\Index as DoctrineIndex;

/**
 * @mixin DoctrineIndex
 */
class Index
{
    /**
     * @var DoctrineIndex
     */
    private $doctrineIndex;

    public function __construct(DoctrineIndex $doctrineIndex)
    {
        $this->doctrineIndex = $doctrineIndex;
    }

    public function __call($name, $arguments)
    {
        if (method_exists($this->doctrineIndex, $name)) {
            return $this->doctrineIndex->$name(...$arguments);
        }

        throw new BadMethodCallException('Undefined method ' . $name . ' in class ' . static::class);
    }

    public function type(): string
    {
        if ($this->doctrineIndex->isPrimary()) {
            return 'primary';
        }

        if ($this->doctrineIndex->isUnique()) {
            return 'unique';
        }

        return 'index';
    }
}
