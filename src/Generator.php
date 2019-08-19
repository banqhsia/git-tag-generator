<?php

namespace Benyi\GitTagGenerator;

class Generator
{
    /**
     * @var Version[]
     */
    private $versions;

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
        foreach ($this->versions as $version) {
            $sorted[$version->getMajor()][$version->getMinor()][$version->getBuild()] = $version;
        }

        $latestMajor = $sorted[max(array_keys($sorted))];
        $latestMinor = $latestMajor[max(array_keys($latestMajor))];

        return $latestMinor[max(array_keys($latestMinor))];
    }

    /**
     * Get the next major version.
     *
     * @return Version
     */
    public function getNextMajor()
    {
        return Version::createFromArray([
            $this->getLatest()->getMajor() + 1,
            0,
            0,
        ]);
    }

    /**
     * Get the next minor version.
     *
     * @return Version
     */
    public function getNextMinor()
    {
        return Version::createFromArray([
            $this->getLatest()->getMajor(),
            $this->getLatest()->getMinor() + 1,
            0,
        ]);
    }

    /**
     * Get the next build version.
     *
     * @return Version
     */
    public function getNextBuild()
    {
        return Version::createFromArray([
            $this->getLatest()->getMajor(),
            $this->getLatest()->getMinor(),
            $this->getLatest()->getBuild() + 1,
        ]);
    }
}
