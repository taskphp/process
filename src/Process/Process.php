<?php

namespace Task\Plugin\Process;

use Symfony\Component\Process\Process as BaseProcess;
use Task\Plugin\Stream\WritableInterface;
use Task\Plugin\Stream\ReadableInterface;

class Process extends BaseProcess implements WritableInterface, ReadableInterface
{
    public static function extend(BaseProcess $proc)
    {
        return new static(
            $proc->getCommandLine(),
            $proc->getWorkingDirectory(),
            $proc->getEnv(),
            $proc->getStdin(),
            $proc->getTimeout(),
            $proc->getOptions()
        );
    }

    public function run($callback = null)
    {
        $exitcode = parent::run($callback);

        if ($this->isSuccessful()) {
            return $exitcode;
        } else {
            throw new \RuntimeException(
                sprintf(
                    "%s returned %d\n%s",
                    $this->getCommandLine(),
                    $this->getExitCode(),
                    $this->getErrorOutput()
                )
            );
        }

        return $this;
    }

    public function read()
    {
        $this->run();
        return $this->getOutput();
    }

    public function write($data)
    {
        return $this->setStdin($data);
    }

    public function pipe(WritableInterface $to)
    {
        $this->run(function ($type, $data) use ($to) {
            $to->write($data);
        });

        return $to;
    }
}
