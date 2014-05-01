<?php

namespace Task\Plugin;

use Task\Plugin\Process\ProcessBuilder;
use Symfony\Component\Console\Output\OutputInterface;

class ProcessPlugin implements PluginInterface
{
    public function build($command, array $args = [])
    {
        return ProcessBuilder::create()
            ->setPrefix($command)
            ->setArguments($args);
    }

    public function run($command, array $args = [], $cwd = null, array $env = [])
    {
        $proc = $this->build($command, $args)
            ->setWorkingDirectory($cwd)
            ->addEnvironmentVariables($env)
            ->getProcess();

        $proc->run();

        return $proc;
    }
}
