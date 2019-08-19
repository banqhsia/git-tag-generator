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

    /**
     * Get the next major version.
     *
     * @return Version
     */
    public function getNextMajor()
    {
        $latest = $this->getLatest();
        $next = $latest->getMajor() + 1;

        $versionString = [$next, 0, 0];

        return Version::createFromArray($versionString);
    }

    /**
     * Get the next minor version.
     *
     * @return Version
     */
    public function getNextMinor()
    {
        $latest = $this->getLatest();
        $next = $latest->getMinor() + 1;

        $versionString = [$latest->getMajor(), $next, 0];

        return Version::createFromArray($versionString);
    }

    /**
     * Get the next build version.
     *
     * @return Version
     */
    public function getNextBuild()
    {
        $latest = $this->getLatest();
        $next = $latest->getBuild() + 1;

        $versionString = [$latest->getMajor(), $latest->getMinor(), $next];

        return Version::createFromArray($versionString);
    }
}
