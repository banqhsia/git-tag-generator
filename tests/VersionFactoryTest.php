<?php

use PHPUnit\Framework\TestCase;
use Benyi\GitTagGenerator\Version;
use Benyi\GitTagGenerator\VersionFactory;

class VersionFactoryTest extends TestCase
{
    public function test_should_create_Version_objects()
    {
        $givenVersions = [
            'v1.5.0',
            'feature/lists',
            'v1.6',
        ];

        $expected = [
            new Version('v1.5.0'),
            new Version('v1.6'),
        ];

        $actual = VersionFactory::create($givenVersions);

        $this->assertEquals($expected, $actual);
    }

}
