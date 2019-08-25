<?php

namespace Benyi\GitTagGenerator;

class VersionFactory
{
    /**
     * Create the array of Version
     *
     * @param array $versions
     * @return Version[]
     *
     * @throws \RuntimeException
     */
    public static function create($versions)
    {
        $versions = collect($versions)->mapInto(Version::class)->filter(function (Version $version) {
            return $version->isVersionFormat();
        });

        if ($versions->isEmpty()) {
            throw new \RuntimeException("There's no valid version of your git tags.");
        }

        return $versions->values()->toArray();
    }
}
