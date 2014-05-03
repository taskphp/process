<?php

namespace spec\Task\Plugin;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProcessPluginSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Task\Plugin\ProcessPlugin');
    }

    function it_should_init_a_process_builder()
    {
        $ps = $this->build('foo', ['bar']);
        $ps->shouldHaveType('Task\Plugin\Process\ProcessBuilder');
        $ps->getProcess()->getCommandLine()->shouldReturn("'foo' 'bar'");
    }

    function it_should_run_a_process()
    {
        $tmp = sys_get_temp_dir();
        $env = ['FOO' => 'BAR'];
        $ps = $this->run('echo', ['foo'], $tmp, $env);

        $ps->shouldHaveType('Task\Plugin\Process\Process');
        $ps->isStarted()->shouldReturn(true);
        $ps->getCommandLine()->shouldReturn("'echo' 'foo'");
        $ps->getWorkingDirectory()->shouldReturn($tmp);
        $ps->getEnv()->shouldContainArray($env);
    }
    
    public function getMatchers()
    {
        return [
            'containArray' => function ($subject, $data) {
                $pass = true;

                foreach ($data as $key => $value) {
                    $pass = $pass && array_key_exists($key, $subject) && $subject[$key] == $value;
                }

                return $pass;
            }
        ];
    }
}
