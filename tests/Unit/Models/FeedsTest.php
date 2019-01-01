<?php

namespace Tests\Unit;

use App\Models\Feed;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FeedsTest extends TestCase
{
    use RefreshDatabase;

    public function testGetStatusInitial()
    {
        $feed = factory(Feed::class)->create();

        $this->assertEquals(true, $feed->status);
    }

    public function testGetStatusWhenIsOnline()
    {
        $feed = factory(Feed::class)->create();
        $feed->statuses()->create(['online' => true]);

        $this->assertEquals(true, $feed->status);
    }

    public function testGetStatusWhenIsOffline()
    {
        $feed = factory(Feed::class)->create();
        $feed->statuses()->create(['online' => false]);

        $this->assertEquals(false, $feed->status);
    }

    public function testGetStatusWhenTurnsOffline()
    {
        $feed = factory(Feed::class)->create();
        $feed->statuses()->create(['online' => true]);
        $feed->statuses()->create(['online' => false]);

        $this->assertEquals(false, $feed->status);
    }

    public function testFilterByTagsReturnByTag()
    {
        factory(Feed::class)->create(['tags' => []]);
        $feedWithTag = factory(Feed::class)->create(['tags' => ['example']]);

        $query = Feed::withTags(['example']);

        $this->assertEquals(1, $query->count());
        $this->assertEquals($feedWithTag->id, $query->first()->id);
    }

    public function testFilterByTagsIgnoreEmptiness()
    {
        factory(Feed::class)->create(['tags' => []]);
        factory(Feed::class)->create(['tags' => ['example']]);

        $this->assertEquals(2, Feed::withTags()->count());
    }
}
