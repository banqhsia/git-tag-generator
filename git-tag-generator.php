<?php

require_once __DIR__ . '/vendor/autoload.php';

dump($argv);

exec("git --git-dir $argv[1] tag", $tags);

$tags = collect($tags)->sort();

dump($tags);
