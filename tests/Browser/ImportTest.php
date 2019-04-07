<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\Feed\Source;

class ImportTest extends DuskTestCase
{
    public function testImportFeedsSavesTheFirstFeed()
    {
        app()->factory(Source::class, function () {
            $stub = $this->createPartialMock(Source::class, 'isValidSource');
            $stub->method('isValidSource')->willReturn(true);
            return $stub;
        });

        $this->browse(function (Browser $browser) {
            $browser
                ->visit('/')
                ->click('.navbar-toggler')
                ->pause(1000)
                ->click('.import')
                ->waitForText('Import OPML')
                ->tap(function() use ($browser) {
                    $browser->attach('file', base_path('tests/Fixtures/OPMLs/valid-opml-list.opml'));
                })
                ->click('.btn-primary')
                ->waitFor('.card')
                ->tap(function() use ($browser) {
                    $this->assertEquals(119, count($browser->elements('.card')));
                })
                ->select('type', 'rss')
                ->click('.btn')
                ->pause(1000);

            $this->assertDatabaseHas('feeds', [
               'title' => 'A VC'
            ]);
        });
    }
}
