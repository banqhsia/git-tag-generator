<?php

use PHPUnit\Framework\TestCase;
use Benyi\GitTagGenerator\Version;
use Benyi\GitTagGenerator\Generator;

class GeneratorTest extends TestCase
{
    public function test_should_get_latest_version()
    {
        $givenVersions = [
            new Version('v1.1.0'),
            new Version('v2.6.0'),
            new Version('v2.12.3'),
            new Version('v2.12.4'),
        ];

        $target = new Generator($givenVersions);

        $this->assertEquals(new Version('v2.12.4'), $target->getLatest());
    }
}
