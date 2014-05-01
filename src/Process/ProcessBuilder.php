<?php

namespace Task\Plugin\Process;

use Symfony\Component\Process\ProcessBuilder as BaseProcessBuilder;
use Task\Plugin\Stream\WritableInterface;

class ProcessBuilder extends BaseProcessBuilder implements WritableInterface
{
    public function getProcess()
    {
        return Process::extend(parent::getProcess());
    }

    public function run()
    {
        $proc = $this->getProcess();
        $proc->run();
        return $proc;
    }

    public function read()
    {
        return $this->run()->getOutput();
    }

    public function write($data)
    {
        $this->setInput($data);
        return $this->run();
    }

    public function pipe(WritableInterface $to)
    {
        return $this->getProcess()->pipe($to);
    }
}
