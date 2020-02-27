<?php

namespace Tests\Schemarkdown;

use MilesChou\Schemarkdown\Commands\GenerateCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Tests\TestCase;

class ApplicationTest extends TestCase
{
    /**
     * @test
     */
    public function shouldReturnEmptyStringWhenConfigIsEmptyArray(): void
    {
        $output = new BufferedOutput();

        $target = new Application('Schemarkdown');
        $target->add(new GenerateCommand($this->container));
        $target->setAutoExit(false);
        $target->run(new ArrayInput(['--version' => null]), $output);

        $this->assertStringContainsString('Schemarkdown', $output->fetch());
    }
}
