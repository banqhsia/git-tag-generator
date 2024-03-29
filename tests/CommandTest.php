<?php

use PHPUnit\Framework\TestCase;
use Benyi\GitTagGenerator\Command;

class CommandTest extends TestCase
{
    /**
     * @var Command
     */
    private $target;

    public function test_should_get_false_when_repo_NOT_given()
    {
        $this->givenCommands([
        ]);

        $this->assertFalse($this->target->hasRepository());
    }

    public function test_should_get_true_when_repo_given()
    {
        $this->givenCommands([
            'repo' => '/home/benyi/project',
        ]);

        $this->assertTrue($this->target->hasRepository());
    }

    public function test_should_get_true_when_help_option_given()
    {
        $this->givenCommands([
            'help' => false,
        ]);

        $this->assertTrue($this->target->hasHelp());
    }

    public function test_should_get_true_when_h_option_given()
    {
        // short option
        $this->givenCommands([
            'h' => false,
        ]);

        $this->assertTrue($this->target->hasHelp());
    }

    public function test_should_get_false_when_next_NOT_given()
    {
        $this->givenCommands([
        ]);

        $this->assertFalse($this->target->hasNext());
    }

    public function test_should_get_false_when_next_given()
    {
        $this->givenCommands([
            'next' => 'major',
        ]);

        $this->assertTrue($this->target->hasNext());
    }

    public function test_should_throw_InvalidArgumentException_when_next_not_allowed()
    {
        $this->givenCommands([
            'next' => 'some_patch_version',
        ]);

        $this->expectException(\InvalidArgumentException::class);

        $this->target->getNext();
    }

    public function test_should_get_true_when_create_option_is_false()
    {
        $this->givenCommands([
            'create' => false,
        ]);

        $this->assertTrue($this->target->hasCreate());
    }

    public function test_should_get_false_when_create_option_is_empty()
    {
        $this->givenCommands([
        ]);

        $this->assertFalse($this->target->hasCreate());
    }

    /**
     * @testWith ["/var/www/html/project"]
     *           ["/var/www/html/project/"]
     *           ["/var/www/html/project/.git"]
     *           ["/var/www/html/project/.git/"]
     */
    public function test_should_parse_git_path_when_path_is_given($given)
    {
        $expected = '/var/www/html/project/.git';

        $this->givenCommands([
            'repo' => $given,
        ]);
        $this->givenDirectorySeparator("/");

        $this->assertSame($expected, $this->target->getRepository());
    }

    /**
     * @testWith ["C:\\User\\Benyi\\myproject"]
     *           ["C:\\User\\Benyi\\myproject\\"]
     *           ["C:\\User\\Benyi\\myproject\\.git"]
     *           ["C:\\User\\Benyi\\myproject\\.git\\"]
     */
    public function test_should_parse_git_path_when_path_is_windows_style($given)
    {
        $expected = 'C:\User\Benyi\myproject\.git';

        $this->givenCommands([
            'repo' => $given,
        ]);
        $this->givenDirectorySeparator("\\");

        $this->assertSame($expected, $this->target->getRepository());
    }

    public function test_should_use_current_working_directory_when_repo_path_is_not_given()
    {
        $this->givenCommands([
        ]);
        $this->givenCurrentWorkingDirectory('/var/www/html/the-project');
        $this->givenDirectorySeparator("/");

        $expected = '/var/www/html/the-project/.git';

        $this->assertSame($expected, $this->target->getRepository());
    }

    private function givenCommands($commands)
    {
        $this->target = $this->getMockBuilder(Command::class)
            ->setConstructorArgs([$commands])
            ->setMethods(['getCurrentWorkingDirectory', 'getDirectorySeparator'])
            ->getMock();
    }

    private function givenDirectorySeparator($separator)
    {
        $this->target->method('getDirectorySeparator')->willReturn($separator);
    }

    private function givenCurrentWorkingDirectory($path)
    {
        $this->target->method('getCurrentWorkingDirectory')->willReturn($path);
    }
}
