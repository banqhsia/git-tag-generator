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
     * Create the tag using the given tag name.
     *
     * @param string $tagName
     * @return string[]
     */
    public function createTag($tagName)
    {
        return $this->execute("git --git-dir {$this->command->getRepository()} tag {$tagName}");
    }

    /**
     * Execute the given command and return the array of result.
     *
     * @param string $command
     * @return string[]
     */
    protected function execute($command)
    {
        exec($command, $result);

        return $result;
    }
}
