<?php

use PHPUnit\Framework\TestCase;
use Benyi\GitTagGenerator\Version;
use Benyi\GitTagGenerator\Generator;

class GeneratorTest extends TestCase
{
    public function test_should_get_latest_version()
    {
        $this->givenVersions([
            new Version('v1.1.0'),
            new Version('v2.6.0'),
            new Version('v2.12.3'),
            new Version('v2.12.4'),
        ]);

        $this->assertEquals(
            new Version('v2.12.4'),
            $this->target->getLatest()
        );
    }

    public function test_should_get_next_major_version()
    {
        $this->givenVersions([
            new Version('v1.1.0'),
            new Version('v2.6.0'),
        ]);

        $this->assertEquals(new Version('v3.0.0'), $this->target->getNextMajor());
    }

    public function test_should_get_next_minor_version()
    {
        $this->givenVersions([
            new Version('v1.1.0'),
            new Version('v2.6.0'),
        ]);

        $this->assertEquals(new Version('v2.7.0'), $this->target->getNextMinor());
    }

    public function test_should_get_next_patch_version()
    {
        $this->givenVersions([
            new Version('v1.1.0'),
            new Version('v2.6.0'),
        ]);

        $this->assertEquals(new Version('v2.6.1'), $this->target->getNextPatch());
    }

    private function givenVersions($versions)
    {
        $this->target = new Generator($versions);
    }
}
