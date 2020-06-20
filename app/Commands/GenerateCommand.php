<?php

namespace App\Commands;

use App\Commands\Concerns\DatabaseConnection;
use App\Commands\Concerns\Environment;
use Illuminate\Container\Container;
use Illuminate\Database\DatabaseManager;
use MilesChou\Codegener\Traits\Path;
use MilesChou\Codegener\Writer;
use MilesChou\Schemarkdown\Builder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCommand extends Command
{
    use DatabaseConnection;
    use Environment;
    use Path;

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
        $this->setName('generate')
            ->setDescription('Generate Markdown')
            ->addOption('--config-file', null, InputOption::VALUE_REQUIRED, 'Config file', 'config/database.php')
            ->addOption('--connection', null, InputOption::VALUE_REQUIRED, 'Connection name will only build')
            ->addOption('--output-dir', null, InputOption::VALUE_REQUIRED, 'Relative path with getcwd()', 'generated')
            ->addOption('--overwrite', null, InputOption::VALUE_NONE, 'Overwrite the exist file');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $env = $input->getOption('env');
        $configFile = $input->getOption('config-file');
        $connection = $input->getOption('connection');
        $outputDir = $input->getOption('output-dir');
        $overwrite = $input->getOption('overwrite');

        $this->loadDotEnv($this->formatPath($env));

        $this->container['config']['database.connections'] = $this->normalizeConnectionConfig(
            $this->formatPath($configFile)
        );

        if ($connection === null) {
            $connections = array_keys($this->container['config']['database.connections']);
        } else {
            $connections = [$connection];
        }

        // Initial connection
        /** @var DatabaseManager $databaseManager */
        $databaseManager = $this->container->get('db');

        foreach ($connections as $connection) {
            $databaseManager->connection($connection);
        }

        $code = (new Builder(
            $databaseManager,
            $this->container->make('view'),
            $this->container->make('events')
        ))->build();

        $logger = $this->container->make('log');

        $logger->info('All document build success, next will write files');

        /** @var Writer $writer */
        $writer = $this->container->make(Writer::class);
        $writer->appendBasePath($outputDir)
            ->writeMass($code, $overwrite);

        $logger->info('All document write success');

        return 0;
    }
}
