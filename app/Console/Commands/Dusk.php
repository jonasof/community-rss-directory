<?php

namespace App\Console\Commands;

use Symfony\Component\Process\Process;
use Laravel\Dusk\Console\DuskCommand;

if (class_exists('\Laravel\Dusk\Console\DuskCommand'))
{
    class Dusk extends DuskCommand
    {
        protected $signature = 'dusk {--without-tty : Disable output to TTY}';

        protected $description = 'Run the dusk tests with temporary sqlite database and embed server';

        protected $databaseFile;
        protected $databaseUri;

        public function handle()
        {
            $this->createTemporaryDatabase();

            return $this->runTemporaryServer(function() {
                return parent::handle();
            });
        }

        protected function binary()
        {
            return array_merge(["/usr/bin/env", "DB_DATABASE=$this->databaseUri"], parent::binary());
        }

        protected function createTemporaryDatabase()
        {
            $this->databaseFile = tmpfile();
            $this->databaseUri = stream_get_meta_data($this->databaseFile)['uri'];
        }

        protected function runTemporaryServer(callable $callback)
        {
            chdir(public_path());

            $server = new Process("DB_DATABASE=$this->databaseUri php -S 0.0.0.0:8001 ../server.php");
            $server->start();

            chdir(base_path());

            $return = $callback();

            $server->stop();

            return $return;
        }
    }
}