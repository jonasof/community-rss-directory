<?php

namespace Tests\Unit\Util;

use Tests\TestCase;

use App\Feed\{Source};

class SourceTest extends TestCase
{
    public function testSourceIsPodcastType()
    {
        $this->mockValidPodcastFeedSource();

        $this->assertEquals((new Source('mocked'))->getFeedMeta()->type, 'podcast');
    }

    public function testSourceIsRssType()
    {
        $this->mockValidFeedSource();

        $this->assertEquals((new Source('mocked'))->getFeedMeta()->type, 'rss');
    }
}
