<?php

namespace Benyi\GitTagGenerator;

class GitCommand
{
    /**
     * @var Command
     */
    private $command;

    /**
     * Construct
     *
     * @param Command $command
     */
    public function __construct(Command $command)
    {
        $this->command = $command;
    }

    /**
     * Get all tags.
     *
     * @return string[]
     */
    public function getTags()
    {
        return $this->execute("git --git-dir {$this->command->getRepository()} tag");
    }

    /**
     * Execute the given command and return the array of result.
     *
     * @param $command
     * @return string[]
     */
    protected function execute($command)
    {
        exec($command, $result);

        return $result;
    }
}
