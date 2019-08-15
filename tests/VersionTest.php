<?php

use PHPUnit\Framework\TestCase;
use Benyi\GitTagGenerator\Version;

class VersionTest extends TestCase
{
    /**
     * @dataProvider versionProvider
     */
    public function test_should_parse_number($given, $major, $minor, $build)
    {
        $target = new Version($given);

        $this->assertSame($major, $target->getMajor());
        $this->assertSame($minor, $target->getMinor());
        $this->assertSame($build, $target->getBuild());
    }

    public function versionProvider()
    {
        return [
            ["v0.0.0", "0", "0", "0"],
            ["v1.2.3", "1", "2", "3"],
            ["v2.4.2", "2", "4", "2"],
            ["v3.5.1", "3", "5", "1"],
            ["v4.6.0", "4", "6", "0"],
        ];
    }
}
