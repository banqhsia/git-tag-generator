<?php

require_once __DIR__ . '/vendor/autoload.php';

use Benyi\GitTagGenerator\Response;
use Codedungeon\PHPCliColors\Color;

set_exception_handler(function ($exception) {
    $c = new Color;

    Response::buffer()
        ->push("{$c->yellow()}{$exception->getMessage()}{$c->reset()}")
        ->sendError();
});
