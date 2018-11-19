<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Feed;
use App\Utils\FeedValidator;

class CheckFeedStatus extends Command
{
    protected $signature = 'feeds:check_status {id}';

    protected $description = 'Check if the feed is online';

    public function handle()
    {
        $feed = Feed::find($this->argument('id'));
        $feed->statuses()->create([
            'online' => FeedValidator::isValidFeedSource($feed->url)
        ]);
    }
}
