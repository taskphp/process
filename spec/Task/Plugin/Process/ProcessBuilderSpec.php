<?php

namespace spec\Task\Plugin\Process;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Task\Plugin\Stream\WritableInterface;

class ProcessBuilderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Task\Plugin\Process\ProcessBuilder');
    }

    function it_should_extend_process()
    {
        $this->add('foo')->getProcess()->shouldReturnAnInstanceOf('Task\Plugin\Process\Process');
    }

    function it_should_run_a_process()
    {
        $ps = $this->add('echo')->run();
        $ps->shouldHaveType('Task\Plugin\Process\Process');
        $ps->isStarted()->shouldReturn(true);
    }

    function it_should_read_output()
    {
        $this->add('echo')->add('foo')->read()->shouldReturn("foo\n");
    }

    function it_should_write_to_stdin()
    {
        $ps = $this->add('cat')->write('foo');
        $ps->getStdin()->shouldReturn('foo');
        $ps->isStarted()->shouldReturn(true);
    }

    function it_should_pipe_to_process(WritableInterface $to)
    {
        $this->add('echo')->pipe($to);
    }
}
