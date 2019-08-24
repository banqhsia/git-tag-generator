<?php

use Benyi\GitTagGenerator\Command;
use Codedungeon\PHPCliColors\Color;
use Benyi\GitTagGenerator\Generator;
use Benyi\GitTagGenerator\GitCommand;
use Benyi\GitTagGenerator\VersionFactory;

require_once __DIR__ . '/vendor/autoload.php';

$command = new Command(getopt('', ['repo:', 'next:', 'create']));
$gitCommand = new GitCommand($command);
$versions = VersionFactory::create($gitCommand->getTags());
$generator = new Generator($versions);

$c = new Color;

$output = collect([
    null,
    " {$c->bg_cyan()}Git Tag Generator by Benyi Hsia{$c->reset()}",
    null,
    "  {$c->gray()}- Git repository:{$c->reset()} {$command->getRepository()}",
    "  {$c->gray()}- Current version:{$c->reset()} {$generator->getLatest()}",
]);

if ($command->hasNext()) {
    $nextVersion = $generator->getNext($command->getNext());

    $output->push("  - {$c->gray()}Next{$c->reset()} {$command->getNext()} {$c->gray()}will be:{$c->reset()} {$nextVersion}");

    $output->push(null);
    if (false === $command->hasCreate()) {
        $output->push("  {$c->gray()}append{$c->reset()} --create {$c->gray()}to create tag{$c->reset()}");
    } else {
        $gitCommand->createTag($nextVersion);
        $output->push(" {$c->green()} New tag created successfully:{$c->reset()} $nextVersion");
    }
}

echo $output->push(PHP_EOL)->implode(PHP_EOL);
exit;
