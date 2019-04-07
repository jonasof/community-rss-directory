<?php

namespace Tests\Feature\FeedImport;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;

class ParseTest extends TestCase
{
    public function testParseOpmlSuccessfully()
    {
        $validOpml = new UploadedFile(
            base_path("tests/Fixtures/OPMLs/valid-opml-list.opml"),
            "feeds.opml",
            null,
            UPLOAD_ERR_OK,
            true
        );

        $response = $this->post('/api/feeds/import/parse-file', [
            "feeds" => $validOpml
        ]);

        $response->assertJsonStructure([
            [
                "url",
                "title",
                "homepage"
            ]
        ]);
        $response->assertOk();
        $this->assertCount(119, $response->json());
    }

    public function testAddFlagToExistentFeeds()
    {
        factory(\App\Models\Feed::class)->create([
            "url" => "http://blogs.zdnet.com/microsoft/?feed=rss2"
        ]);

        $validOpml = new UploadedFile(
            base_path("tests/Fixtures/OPMLs/valid-opml-list.opml"),
            "feeds.opml",
            null,
            UPLOAD_ERR_OK,
            true
        );

        $response = $this->post('/api/feeds/import/parse-file', [
            "feeds" => $validOpml
        ]);

        $foundFeed = collect($response->json())
            ->filter(function($feed) {
                return $feed['url'] === "http://blogs.zdnet.com/microsoft/?feed=rss2";
            })
            ->first();

        $this->assertIsArray($foundFeed);

        $this->assertGreaterThan(0, $foundFeed['id']);
    }
}
