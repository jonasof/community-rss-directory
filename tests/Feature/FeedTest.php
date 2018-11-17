<?php

namespace Tests\Feature;

use Tests\TestCase;

class FeedTest extends TestCase
{
    public function testCreateValidFeed()
    {
        $this->mockValidFeedSource();

        $response = $this->json('POST', '/api/feeds', [
            "url" => "http://feeds.folha.uol.com.br/rss091.xml",
            "title" => "Testing",
            "description" => "TestingDb"
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('feeds', [
            'title' => 'Testing'
        ]);
    }

    public function testInvalidUrl()
    {
        $this->mockInvalidFeedSource();

        $response = $this->json('POST', '/api/feeds', [
            "url" => "http://lala.com",
            "title" => "Testing",
            "description" => "TestingDb"
        ]);

        $response->assertStatus(422);
    }

    public function testTitlePresence()
    {
        $this->mockValidFeedSource();

        $response = $this->json('POST', '/api/feeds', [
            "url" => "http://lala.com",
            "title" => "",
            "description" => "TestingDb"
        ]);

        $response->assertStatus(422);
    }
}
