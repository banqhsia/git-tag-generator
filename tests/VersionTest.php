<?php

use PHPUnit\Framework\TestCase;
use Benyi\GitTagGenerator\Version;

class VersionTest extends TestCase
{
    /**
     * @testWith ["v0.0.0", 0, 0, 0]
     *           ["v1.2.3", 1, 2, 3]
     *           ["v2.4.2", 2, 4, 2]
     *           ["v3.5.1", 3, 5, 1]
     *           ["v4.6.0", 4, 6, 0]
     *           ["v1.2", 1, 2, 0]
     *           ["v1", 1, 0, 0]
     *           ["v2.3", 2, 3, 0]
     */
    public function test_should_parse_number($given, $major, $minor, $patch)
    {
        $target = new Version($given);

        $this->assertSame($major, $target->getMajor());
        $this->assertSame($minor, $target->getMinor());
        $this->assertSame($patch, $target->getPatch());
    }

    /**
     * @testWith ["v1", true]
     *           ["v1.5", true]
     *           ["v1.5.0", true]
     *           ["v1.5.6", true]
     *           ["vx.y.z", false]
     *           ["v1..6", false]
     *           ["v.1.6.5", false]
     *           ["v.1.6.0", false]
     *           ["v0.1.6.", false]
     *           ["v", false]
     *           ["feature/create_version", false]
     */
    public function test_isVersionFormat($given, $expected)
    {
        $target = new Version($given);

        $this->assertSame($expected, $target->isVersionFormat());
    }
}
