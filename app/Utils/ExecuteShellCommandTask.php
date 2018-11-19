<?php

namespace App\Utils;

use Amp\Parallel\Worker\Task;
use Amp\Parallel\Worker\Environment;

class ExecuteShellCommandTask implements Task
{
    public function __construct($command)
    {
        $this->command = $command;
    }

    public function run (Environment $environment)
    {
         return exec($this->command);
    }
}