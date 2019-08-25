<?php

if (file_exists(__DIR__ . '/../../autoload.php')) {
    require __DIR__ . '/../../autoload.php';
} else {
    require __DIR__ . '/vendor/autoload.php';
}

use Benyi\GitTagGenerator\Response;
use Codedungeon\PHPCliColors\Color;

set_exception_handler(function ($exception) {
    $c = new Color;

    Response::buffer()
        ->push("{$c->yellow()}{$exception->getMessage()}{$c->reset()}")
        ->sendError();
});
