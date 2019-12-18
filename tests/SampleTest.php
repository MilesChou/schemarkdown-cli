<?php

namespace Tests;

use MilesChou\Template\Sample;
use PHPUnit\Framework\TestCase;

class SampleTest extends TestCase
{
    public function testSample()
    {
        $this->assertTrue((new Sample())->alwaysTrue());
    }
}
