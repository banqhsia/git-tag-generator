<?php

use Benyi\GitTagGenerator\Version;
use Benyi\GitTagGenerator\Generator;

require_once __DIR__ . '/vendor/autoload.php';

exec("git --git-dir $argv[1] tag", $versions);

$versions = collect($versions)->mapInto(Version::class)->filter(function (Version $version) {
    return $version->isVersionFormat();
});

$generator = new Generator($versions);

dump($generator->getLatest());
dump($generator->getNextBuild());
dump($generator->getNextMinor());
dump($generator->getNextMajor());
