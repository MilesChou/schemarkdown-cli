<?php

namespace Tests;

use Illuminate\Container\Container;

class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Container
     */
    protected $container;

    protected function setUp(): void
    {
        parent::setUp();

        $this->container = $this->createContainer();
    }

    protected function tearDown(): void
    {
        $this->container = null;

        parent::tearDown();
    }

    protected function createContainer(): Container
    {
        $container = new Container();

        Container::setInstance($container);

        return $container;
    }
}
