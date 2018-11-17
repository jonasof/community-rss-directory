<?php

namespace Tests\Unit\Util;

use Tests\TestCase;

use App\Utils\{FeedSource};

class FeedSourceTest extends TestCase
{
    public function testSourceIsPodcastType()
    {
        $this->mockValidPodcastFeedSource();

        $this->assertEquals((new FeedSource('mocked'))->getFeedMeta()->type, 'podcast');
    }

    public function testSourceIsRssType()
    {
        $this->mockValidFeedSource();

        $this->assertEquals((new FeedSource('mocked'))->getFeedMeta()->type, 'rss');
    }
}
