<?php

namespace MilesChou\Docusema\Commands;

use MilesChou\Docusema\Commands\Concerns\Environment;
use Illuminate\Container\Container;
use Illuminate\Database\DatabaseManager;
use MilesChou\Docusema\CodeBuilder;
use MilesChou\Docusema\CodeWriter;
use MilesChou\Docusema\Commands\Concerns\DatabaseConnection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCommand extends Command
{
    use DatabaseConnection;
    use Environment;

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
            ->addOption('--env', null, InputOption::VALUE_REQUIRED, '.env file', '.env')
            ->addOption('--config-file', null, InputOption::VALUE_REQUIRED, 'Config file', 'config/database.php')
            ->addOption('--connection', null, InputOption::VALUE_REQUIRED, 'Connection name will only build', null)
            ->addOption('--output-dir', null, InputOption::VALUE_REQUIRED, 'Relative path with getcwd()', 'generated');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $env = $input->getOption('env');
        $configFile = $input->getOption('config-file');
        $connection = $input->getOption('connection');
        $outputDir = $input->getOption('output-dir');

        $this->loadDotEnv($this->normalizePath($env));

        $connections = $this->normalizeConnectionConfig($this->normalizePath($configFile));

        $this->container['config']['database.connections'] = $this->filterConnection($connections, $connection);

        /** @var DatabaseManager $databaseManager */
        $databaseManager = $this->container->get('db');

        $code = (new CodeBuilder($this->container, $databaseManager))->build();

        (new CodeWriter())->generate($code, $outputDir);

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
