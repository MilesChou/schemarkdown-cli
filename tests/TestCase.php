<?php

namespace Tests;

use Illuminate\Container\Container;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;

class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * @var vfsStreamDirectory
     */
    protected $root;

    protected function setUp(): void
    {
        parent::setUp();

        $this->root = vfsStream::setup();

        $this->putConfigFileWithVfs();

        $this->container = $this->createContainer();
    }

    protected function tearDown(): void
    {
        $this->container = null;

        parent::tearDown();
    }

    protected function createContainer(): Container
    {
        return Container::getInstance();
    }

    /**
     * @param string $path
     * @param array $config
     */
    protected function putConfigFileWithVfs(array $config = [], $path = '/config/database.php'): void
    {
        if (!array_key_exists('connections', $config)) {
            $config = ['connections' => $config];
        }

        $fullPath = $this->root->url() . '/config/database.php';

        mkdir(dirname($fullPath), 0777, true);

        $code = '<?php return ' . var_export($config, true) . ';';

        file_put_contents($this->root->url() . $path, $code);
    }
}
