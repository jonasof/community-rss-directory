<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Feed;

use App\Utils\ExecuteShellCommandTask;

use Amp\Parallel\Worker;
use Amp\Promise;

class CheckAllFeedsStatus extends Command
{
    protected $signature = 'feeds:check_all_status';

    protected $description = 'Check if all feeds are online';

    public function handle()
    {
        $promises = Feed::pluck('id')->map(function ($id) {
            $task = new ExecuteShellCommandTask(base_path('artisan') . " feeds:check_status $id");
            return Worker\enqueue($task);
        });

        Promise\wait(Promise\all($promises->toArray()));
    }
}
