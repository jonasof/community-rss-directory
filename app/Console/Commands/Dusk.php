<?php

namespace App\Console\Commands;

use Symfony\Component\Process\Process;
use Illuminate\Console\Command;
use Artisan;

class Dusk extends Command
{
    protected $signature = 'test:browser';

    protected $description = 'Run the Dusk tests for the application';

    protected $process;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->prepareServer();

        $result = Artisan::call('dusk');

        $this->killServer();

        return $result;
    }

    /**
     * Build a process to run php artisan serve
     *
     * @return Process
     */
    protected function prepareServer()
    {
        shell_exec('echo "" > /tmp/dusk.sqlite');
        shell_exec('php artisan migrate --env dusk');

        chdir(public_path());

        $this->process = new Process('APP_ENV=dusk php -S 0.0.0.0:8001 ../server.php');
        $this->process->start();

        chdir(base_path());
    }

    protected  function killServer()
    {
        $this->process->stop();
    }
}