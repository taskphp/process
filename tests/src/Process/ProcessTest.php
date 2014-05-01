<?php

namespace Task\Plugin\Process;

use Symfony\Component\Process\Process as BaseProcess;

class ProcessTest extends \PHPUnit_Framework_TestCase
{
    public function testExtend()
    {
        $original = new BaseProcess(
            $command = 'test',
            $cwd = '/tmp',
            $env = ['FOO' => 'BAR'],
            $stdin = 'wow',
            $timeout = 30,
            $options = ['many' => 'options']
        );

        $proc = Process::extend($original);

        $this->assertInstanceOf('Task\Plugin\Process\Process', $proc);
        $this->assertEquals($command, $proc->getCommandLine());
        $this->assertEquals($cwd, $proc->getWorkingDirectory());
        $this->assertEquals($env, $proc->getEnv());
        $this->assertEquals($stdin, $proc->getStdin());
        $this->assertEquals($timeout, $proc->getTimeout());
        $this->assertEquals($options['many'], $proc->getOptions()['many']);
    }
}
