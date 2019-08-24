<?php

use Benyi\GitTagGenerator\Generator;
use Benyi\GitTagGenerator\VersionFactory;

require_once __DIR__ . '/vendor/autoload.php';

exec("git --git-dir $argv[1] tag", $versions);

$versions = VersionFactory::create($versions);

$generator = new Generator($versions);

dump($generator->getLatest());
dump($generator->getNextPatch());
dump($generator->getNextMinor());
dump($generator->getNextMajor());
