<?php

namespace MilesChou\Docusema\Commands;

use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager;
use MilesChou\Docusema\Commands\Concerns\DatabaseConnection;
use MilesChou\Docusema\Schema;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCommand extends Command
{
    use DatabaseConnection;

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

        $container = Container::getInstance();

        $this->prepareConnection(
            $container,
            $this->normalizePath($configFile)
        );

        $this->filterConnection($connection);

        /** @var Manager $manager */
        $manager = Container::getInstance()->get('db');

        $schema = new Schema($manager->getConnection('test_mysql'));
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
