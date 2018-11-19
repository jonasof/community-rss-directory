<?php

namespace Tests\Unit;

use App\Models\Feed;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FeedsTest extends TestCase
{
    use RefreshDatabase;

    public function testGetFeedStatusInitial()
    {
        $feed = factory(Feed::class)->create();

        $this->assertEquals(true, $feed->status);
    }

    public function testGetFeedStatusWhenIsOnline()
    {
        $feed = factory(Feed::class)->create();
        $feed->statuses()->create(['online' => true]);

        $this->assertEquals(true, $feed->status);
    }

    public function testGetFeedStatusWhenIsOffline()
    {
        $feed = factory(Feed::class)->create();
        $feed->statuses()->create(['online' => false]);

        $this->assertEquals(false, $feed->status);
    }

    public function testGetFeedStatusWhenTurnsOffline()
    {
        $feed = factory(Feed::class)->create();
        $feed->statuses()->create(['online' => true]);
        $feed->statuses()->create(['online' => false]);

        $this->assertEquals(false, $feed->status);
    }
}
