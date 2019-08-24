<?php

namespace Benyi\GitTagGenerator;

class VersionFactory
{
    /**
     * Create the array of Version
     *
     * @param array $versions
     * @return Version[]
     */
    public static function create($versions)
    {
        return collect($versions)->mapInto(Version::class)->filter(function (Version $version) {
            return $version->isVersionFormat();
        })->values()->toArray();
    }
}
