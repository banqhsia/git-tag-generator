<?php

use Benyi\GitTagGenerator\Command;
use Benyi\GitTagGenerator\Generator;
use Benyi\GitTagGenerator\GitCommand;
use Benyi\GitTagGenerator\VersionFactory;

require_once __DIR__ . '/vendor/autoload.php';

$command = new Command(getopt('', ['repo:', 'create:']));
$gitCommand = new GitCommand($command);

$versions = $gitCommand->getTags();

$versions = VersionFactory::create($versions);

$generator = new Generator($versions);

dump($generator->getLatest());
dump($generator->getNextPatch());
dump($generator->getNextMinor());
dump($generator->getNextMajor());
