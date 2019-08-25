<?php

require_once __DIR__ . '/bootstrap.php';

use Benyi\GitTagGenerator\Command;
use Benyi\GitTagGenerator\Response;
use Codedungeon\PHPCliColors\Color;
use Benyi\GitTagGenerator\Generator;
use Benyi\GitTagGenerator\GitCommand;
use Benyi\GitTagGenerator\VersionFactory;

$command = new Command(getopt('h', ['repo:', 'next:', 'create', 'help']));
$gitCommand = new GitCommand($command);
$versions = VersionFactory::create($gitCommand->getTags());
$generator = new Generator($versions);
$c = new Color;

$currentBranch = (function () use ($gitCommand, $c) {
    if ($gitCommand->isOnBranch("release")) {
        return "{$c->green()}{$gitCommand->getCurrentBranch()}{$c->reset()}";
    }

    return "{$c->yellow()}{$gitCommand->getCurrentBranch()}{$c->reset()} (Not on release)";
})();

$output = Response::buffer();

$output->pushMany([
    "{$c->gray()}- Git repository:{$c->reset()} {$command->getRealPath()}",
    "{$c->gray()}- Current branch:{$c->reset()} {$currentBranch}",
    "{$c->gray()}- Current version:{$c->reset()} {$generator->getLatest()}"]
)->blankLine();

if ($command->hasNext()) {
    $nextVersion = $generator->getNext($command->getNext());

    $output->push("- {$c->gray()}Next{$c->reset()} {$command->getNext()} {$c->gray()}will be:{$c->reset()} {$nextVersion}");

    $output->push(null);
    if (false === $command->hasCreate()) {
        $output->push("{$c->gray()}append{$c->reset()} --create {$c->gray()}to create tag{$c->reset()} on $currentBranch");
    } else {
        $gitCommand->createTag($nextVersion);
        $output->push("{$c->green()}New tag created successfully:{$c->reset()} $nextVersion");
    }
}

$output->send();
