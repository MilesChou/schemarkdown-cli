<?php

namespace MilesChou\Docusema\Commands;

use Illuminate\Container\Container;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Facades\View;
use MilesChou\Docusema\Commands\Concerns\DatabaseConnection;
use MilesChou\Docusema\Schema;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCommand extends Command
{
    use DatabaseConnection;

    /**
     * @var Container
     */
    private $container;

    /**
     * @param Container $container
     * @param string|null $name
     */
    public function __construct(Container $container, string $name = null)
    {
        parent::__construct($name);

        $this->container = $container;
    }

    protected function configure()
    {
        parent::configure();

        $this->setName('generate')
            ->setDescription('Generate Markdown')
            ->addOption('--config-file', null, InputOption::VALUE_REQUIRED, 'Config file', 'config/database.php')
            ->addOption('--connection', null, InputOption::VALUE_REQUIRED, 'Connection name will only build', null)
            ->addOption('--output-dir', null, InputOption::VALUE_REQUIRED, 'Relative path with getcwd()', 'build');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configFile = $input->getOption('config-file');
        $connection = $input->getOption('connection');
        $outputDir = $input->getOption('output-dir');

        $connections = $this->normalizeConnectionConfig($this->normalizePath($configFile));

        $this->container['config']['database.connections'] = $this->filterConnection($connections, $connection);

        /** @var DatabaseManager $databaseManager */
        $databaseManager = $this->container->get('db');

        $databaseConnection = $databaseManager->connection('test_mysql');
        $schemaManager = $databaseConnection
            ->getDoctrineConnection()
            ->getSchemaManager();

        echo View::make('table', [
            'schema' => new Schema(
                $schemaManager->listTableDetails('test_basic'),
                $databaseConnection->getDatabaseName()
            ),
        ])
            ->render();

        return 0;
    }

    /**
     * @param string $path
     * @return string
     */
    private function normalizePath(string $path): string
    {
        if ($path[0] !== '/') {
            $path = getcwd() . '/' . $path;
        }

        return $path;
    }
}
