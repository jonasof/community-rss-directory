<?php

namespace Tests\Unit\Util;

use Tests\TestCase;

use App\Feed\{Exporter};
use App\Models\Feed;

class ExporterTest extends TestCase
{
    public function testExportOutputsTheOPMLFeeds()
    {
        factory(Feed::class, 5)->create();

        $exporter = new Exporter();
        $result = $exporter->export(Feed::all());

        $this->assertEquals(5, substr_count($result, '<outline'));
    }
}
