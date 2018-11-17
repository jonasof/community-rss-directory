<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Feed;
use App\Utils\FeedValidator;

class CheckFeedsStatus extends Command
{
    protected $signature = 'feeds:check_status';

    protected $description = 'Check if all feeds are online';
    
    public function handle()
    {
        $feeds = Feed::all();

        foreach($feeds as $feed) {
            $feed->feedStatuses()->create([
                'online' => FeedValidator::isValidFeedSource($feed->url)
            ]);
        }
    }
}
