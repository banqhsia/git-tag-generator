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

    public function test_should_get_false_when_create_NOT_given()
    {
        $this->givenCommands([
        ]);

        $this->assertFalse($this->target->hasCreate());
    }

    public function test_should_get_false_when_create_given()
    {
        $this->givenCommands([
            'create' => 'major',
        ]);

        $this->assertTrue($this->target->hasCreate());
    }

    public function test_should_throw_InvalidArgumentException_when_create_not_allowed()
    {
        $this->givenCommands([
            'create' => 'some_patch_version',
        ]);

        $this->expectException(\InvalidArgumentException::class);

        $this->target->getCreate();
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
