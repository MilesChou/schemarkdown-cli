<?php

namespace MilesChou\Schemarkdown\Commands;

use Illuminate\Container\Container;
use Illuminate\Database\DatabaseManager;
use Illuminate\Log\LogManager;
use MilesChou\Codegener\Traits\Path;
use MilesChou\Codegener\Writer;
use MilesChou\Schemarkdown\Builder;
use MilesChou\Schemarkdown\Commands\Concerns\DatabaseConnection;
use MilesChou\Schemarkdown\Commands\Concerns\Environment;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Logger\ConsoleLogger;
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

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $loggerName = 'schemarkdown';

        $this->container['config']['logging.default'] = $loggerName;
        $this->container['config']["logging.channels.{$loggerName}"] = [
            'driver' => $loggerName,
        ];

        /** @var LogManager $loggerManager */
        $loggerManager = $this->container->make('log');
        $loggerManager->extend($loggerName, function () use ($output) {
            return new ConsoleLogger($output);
        });

        $loggerManager->setDefaultDriver($loggerName);
    }

    protected function configure()
    {
        parent::configure();

        $this->setName('generate')
            ->setDescription('Generate Markdown')
            ->addOption('--env', null, InputOption::VALUE_REQUIRED, '.env file', '.env')
            ->addOption('--config-file', null, InputOption::VALUE_REQUIRED, 'Config file', 'config/database.php')
            ->addOption('--connection', null, InputOption::VALUE_REQUIRED, 'Connection name will only build', null)
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

        $connections = $this->normalizeConnectionConfig($this->formatPath($configFile));

        $this->container['config']['database.connections'] = $this->filterConnection($connections, $connection);

        /** @var DatabaseManager $databaseManager */
        $databaseManager = $this->container->get('db');

        $code = (new Builder($this->container, $databaseManager))->build();

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
