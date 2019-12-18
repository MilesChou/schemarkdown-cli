<?php

namespace Tests;

use MilesChou\Docusema\App;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

class AppTest extends TestCase
{
    /**
     * @test
     */
    public function shouldReturnEmptyStringWhenConfigIsEmptyArray(): void
    {
        $output = new BufferedOutput();

        $target = new App();
        $target->setAutoExit(false);
        $target->run(new ArrayInput([]), $output);

        $this->assertStringContainsString('Docusema', $output->fetch());
    }
}
