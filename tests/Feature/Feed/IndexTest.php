<?php

namespace Tests\Feature;

use Tests\TestCase;

use App\Models\Feed;

class IndexTest extends TestCase
{
    public function testReturnsFeed()
    {
        $feed = factory(Feed::class)->create();

        $response = $this->json('GET', '/api/feeds');

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
                [
                    'id' => $feed->id
                ]
            ]
        ]);
    }

    public function testReturnsFeedsFilteredByTag()
    {
        $feedWithoutTag = factory(Feed::class)->create();

        $feedWithTag = factory(Feed::class)->create([
            'tags' => ['noticias']
        ]);

        $response = $this->json('GET', '/api/feeds?tag=noticias');

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [ ['id' => $feedWithTag->id] ]
        ]);

        $response->assertJsonMissing([
            'data' => [ ['id' => $feedWithoutTag->id] ]
        ]);
    }
}
