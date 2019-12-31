<?php

namespace Tests\Docusema;

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

        $target = new App();
        $target->setAutoExit(false);
        $target->run(new ArrayInput([]), $output);

        $this->assertStringContainsString('Docusema', $output->fetch());
    }
}
