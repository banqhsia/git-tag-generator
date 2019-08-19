<?php

namespace Benyi\GitTagGenerator;

class Generator
{
    /**
     * Construct
     *
     * @param Version[] $versions
     */
    public function __construct($versions)
    {
        $this->versions = $versions;
    }

    /**
     * Get the latest version of current versions.
     *
     * @return Version
     */
    public function getLatest()
    {
        $majors = [];

        foreach ($this->versions as $version) {
            $majors[] = $version->getMajor();

            $sorted[$version->getMajor()][$version->getMinor()][$version->getBuild()] = $version;
        }

        $majored = $sorted[max($majors)];

        $minor = max(array_keys($majored));
        $minored = $majored[$minor];

        $build = max(array_keys($minored));
        return $minored[$build];
    }
}
