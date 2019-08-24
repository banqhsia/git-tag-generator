<?php

namespace Benyi\GitTagGenerator;

use IlluminateAgnostic\Collection\Support\Arr;
use IlluminateAgnostic\Collection\Support\Str;

class Command
{
    const OPTION_REPOSITORY = 'repo';
    const OPTION_CREATE = 'create';

    /**
     * The git directory.
     */
    const GIT_DIRECTORY = '.git';

    /**
     * @var array
     */
    private $commands;

    /**
     * The version identifiers.
     *
     * @var string[]
     */
    protected $identifiers = ['major', 'minor', 'patch'];

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
        return Arr::has($this->commands, static::OPTION_REPOSITORY);
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

        /**
         * If the last item of exploded array is not ".git" folder, give them one.
         */
        if (static::GIT_DIRECTORY !== $exploded->last()) {
            $exploded->push(static::GIT_DIRECTORY);
        }

        /**
         * If the repository path starts with directory separator, the first
         * one will be lost after passing through the "explode" function.
         */
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
        return Arr::has($this->commands, static::OPTION_CREATE);
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

        $identifier = Arr::get($this->commands, static::OPTION_CREATE);

        if (in_array($identifier, $this->identifiers)) {
            return $identifier;
        }

        throw new \InvalidArgumentException("$identifier is not support");
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
