<?php

namespace Benyi\GitTagGenerator;

use IlluminateAgnostic\Collection\Support\Arr;
use IlluminateAgnostic\Collection\Support\Str;

class Command
{
    /**
     * @var array
     */
    private $commands;

    /**
     * Construct
     *
     * @param array $commands [option => value]
     */
    public function __construct($commands)
    {
        $this->commands = $commands;
    }

    /**
     * Determine if commands have "repo" option.
     *
     * @return bool
     */
    public function hasRepository()
    {
        return Arr::has($this->commands, 'repo');
    }

    /**
     * Get the ".git" repository path.
     *
     * @return string
     */
    public function getRepository()
    {
        if ($this->hasRepository()) {
            $repository = Arr::get($this->commands, 'repo');
        } else {
            $repository = $this->getCurrentWorkingDirectory();
        }

        $exploded = collect(explode($this->getDirectorySeparator(), $repository))
            ->reject(function ($segment) {
                return empty($segment);
            });

        if ('.git' !== $exploded->last()) {
            $exploded->push('.git');
        }

        $path = '';
        if (Str::startsWith($repository, $this->getDirectorySeparator())) {
            $path .= $this->getDirectorySeparator();
        }

        $path .= $exploded->implode($this->getDirectorySeparator());

        return $path;
    }

    /**
     * Determine if commands have "create" option.
     *
     * @return bool
     */
    public function hasCreate()
    {
        return Arr::has($this->commands, 'create');
    }

    /**
     * Get the "create" option.
     *
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    public function getCreate()
    {
        if (false === $this->hasCreate()) {
            return null;
        }

        $create = Arr::get($this->commands, 'create');

        if (in_array($create, ['major', 'minor', 'build'], $create)) {
            return $create;
        }

        throw new \InvalidArgumentException("$create is not support");
    }

    /**
     * Get the current working directory.
     *
     * @return string
     */
    protected function getCurrentWorkingDirectory()
    {
        return getcwd();
    }

    /**
     * Get the directory separator for the system.
     *
     * @return string
     */
    protected function getDirectorySeparator()
    {
        return DIRECTORY_SEPARATOR;
    }
}
