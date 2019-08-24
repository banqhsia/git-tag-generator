<?php

namespace Benyi\GitTagGenerator;

use IlluminateAgnostic\Collection\Support\Str;

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
        return $this->execute("tag");
    }

    /**
     * Create the tag using the given tag name.
     *
     * @param string $tagName
     * @return string[]
     */
    public function createTag($tagName)
    {
        return $this->execute("tag {$tagName}");
    }

    /**
     * Get the current branch.
     *
     * @return string
     */
    public function getCurrentBranch()
    {
        $branch = $this->execute("branch | grep \*");

        return Str::replaceFirst("* ", null, $branch[0]);
    }

    /**
     * Determine if the current branch is equal to target branch.
     *
     * @param string $targetBranch
     * @return bool
     */
    public function isOnBranch($targetBranch)
    {
        return $this->getCurrentBranch() === $targetBranch;
    }

    /**
     * Execute the given command and return the array of result.
     *p
     * @param string $command
     * @return string[]
     */
    protected function execute($command)
    {
        exec("git --git-dir {$this->command->getRepository()} {$command}", $result);

        return $result;
    }
}
