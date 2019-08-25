<?php

namespace Benyi\GitTagGenerator;

use Codedungeon\PHPCliColors\Color;
use IlluminateAgnostic\Collection\Support\Collection;

class Response
{
    /**
     * @var Response
     */
    protected static $instance;

    /**
     * The output buffer.
     *
     * @var string[]
     */
    private $output = [];

    /**
     * Construct
     */
    private function __construct()
    {
        $this->c = new Color;
        $this->output = new Collection;

        $this->initialTitle();
    }

    /**
     * Initialize a response title.
     *
     * @return void
     */
    protected function initialTitle()
    {
        $this->blankLine()
            ->push("{$this->c->bg_cyan()}Git Tag Generator by Benyi Hsia{$this->c->reset()}", -1)
            ->blankLine();
    }

    /**
     * Push a message to buffer.
     *
     * @param string $message
     * @param int $indent
     * @return static
     */
    public function push($message, $indent = 0)
    {
        $space = str_repeat(" ", 2 + $indent);

        $this->output->push("{$space}{$message}");

        return $this;
    }

    /**
     * Push messages to buffer.
     *
     * @param string[] $messages
     * @return static
     */
    public function pushMany($messages)
    {
        foreach ($messages as $message) {
            $this->push($message);
        }

        return $this;
    }

    /**
     * Append a blank line.
     *
     * @param int $lineCount
     * @return static
     */
    public function blankLine($lineCount = 1)
    {
        for ($count = 0; $count < $lineCount; $count++) {
            $this->push(null);
        }

        return $this;
    }

    /**
     * Echos the buffer.
     *
     * @param bool $error
     * @return void
     */
    public function send($error = false)
    {
        $this->push(PHP_EOL);

        echo $this->output->implode(PHP_EOL);

        exit((int) $error);
    }

    /**
     * Echos the buffer with terminal error.
     *
     * @return void
     */
    public function sendError()
    {
        $this->send(true);
    }

    /**
     * Get the instance.
     *
     * @return self
     */
    public static function buffer()
    {
        if (null === static::$instance) {
            static::$instance = new static;
        }

        return static::$instance;
    }
}
