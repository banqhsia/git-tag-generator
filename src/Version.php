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
     * Get the version.
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Determine if the given string is valid version or not.
     *
     * @return bool
     */
    public function isVersionFormat()
    {
        if (false === Str::startsWith($this->version, 'v')) {
            return false;
        }

        $exploded = collect($this->getExplodedVersion());

        if (in_array($exploded->count(), range(1, 3))) {
            return $exploded->every(function ($number) {
                return is_numeric($number);
            });
        }

        return false;
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

    /**
     * Create instance from given array.
     *
     * @param int[] $versionArray
     * @return static
     */
    public static function createFromArray($versionArray)
    {
        $version = implode('.', $versionArray);

        return new static("v{$version}");
    }
}
