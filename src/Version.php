<?php

namespace Benyi\GitTagGenerator;

use IlluminateAgnostic\Collection\Support\Str;

class Version
{
    /**
     * @var string
     */
    private $version;

    /**
     * Construct
     *
     * @param string $version
     */
    public function __construct($version)
    {
        $this->version = $version;
    }

    /**
     * Determine if the given string is valid version or not.
     *
     * @return bool
     */
    public function isVersionFormat()
    {
        return Str::startsWith($this->version, 'v') && (3 === count($this->getExplodedVersion()));
    }

    /**
     * Get the pure version without the prefixed "v".
     *
     * @return string
     */
    protected function getPureVersion()
    {
        return Str::replaceFirst('v', null, $this->version);
    }

    /**
     * Get the exploded version string.
     *
     * @return string
     */
    public function getExplodedVersion()
    {
        return explode('.', $this->getPureVersion());
    }

    /**
     * Get the exploded major number.
     *
     * @return string
     */
    public function getMajor()
    {
        return (int) $this->getExplodedVersion()[0];
    }

    /**
     * Get the exploded minor number.
     *
     * @return string
     */
    public function getMinor()
    {
        return (int) $this->getExplodedVersion()[1];
    }

    /**
     * Get the exploded build number.
     *
     * @return string
     */
    public function getBuild()
    {
        return (int) $this->getExplodedVersion()[2];
    }
}
