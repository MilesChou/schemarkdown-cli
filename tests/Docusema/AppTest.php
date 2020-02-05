<?php

namespace Tests\Docusema;

use Corp104\Eloquent\Generator\Commands\GenerateCommand;
use MilesChou\Docusema\App;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Tests\TestCase;

class AppTest extends TestCase
{
    /**
     * @test
     */
    public function shouldReturnEmptyStringWhenConfigIsEmptyArray(): void
    {
        $output = new BufferedOutput();

        $target = new App($this->container);
        $target->setAutoExit(false);
        $target->run(new ArrayInput(['--version' => null]), $output);

        $this->assertStringContainsString('Docusema', $output->fetch());
    }
}
