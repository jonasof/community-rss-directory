<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Facebook\WebDriver\WebDriverKeys;
use App\Models\Feed;

class ListTest extends DuskTestCase
{
    public function testCreateNewFeed()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit('/')
                ->click('.navbar-toggler')
                ->pause(1000)
                ->click('.new')
                ->waitForText('New Feed')
                ->type('url', 'http://pox.globo.com/rss/g1/')
                ->tap(function (Browser $browser) {
                    $browser->driver->getKeyboard()->sendKeys(WebDriverKeys::TAB);
                })
                ->waitUntil("$('#description').val().includes('Últimas notícias de economia')")
                ->click('.btn')
                ->waitForText('Feed List');

            $this->assertDatabaseHas('feeds', [
               'title' => 'G1'
            ]);
        });
    }

    public function testEditFeed()
    {
        factory(Feed::class)->create([
            'url' => 'http://pox.globo.com/rss/g1',
            'title' => 'G1',
            'description' => 'Últimas notícias de economia'
        ]);

        $this->browse(function (Browser $browser) {
            $browser
                ->visit('/')
                ->waitForText('G1')
                ->click('.edit')
                ->waitUntil("$('#description').val().includes('Últimas notícias de economia')")
                ->type('title', ' Editado')
                ->click('.btn')
                ->waitForText('Feed List');

            $this->assertDatabaseHas('feeds', [
               'title' => 'G1 Editado'
            ]);
        });
    }

    public function testListFeed()
    {
        factory(Feed::class)->create([
            'title' => 'G1',
        ]);

        $this->browse(function (Browser $browser) {
            $browser
                ->visit('/')
                ->waitForText('G1')
                ->assertSee('G1');
          });
    }

    public function testCanAddTagsToExistingFeed()
    {
        factory(Feed::class)->create([
            'url' => 'http://pox.globo.com/rss/g1',
            'title' => 'G1',
            'description' => 'Últimas notícias de economia',
            'tags' => ['tagteste']
        ]);

        $this->browse(function (Browser $browser) {
            $browser
                ->visit('/')
                ->waitForText('Feed List')
                ->click('.edit')
                ->waitUntil("$('#description').val().includes('Últimas notícias de economia')")
                ->assertInputValue('tags', 'tagteste')
                ->type('.tags-input input[type=text]', 'maisumatag')
                ->tap(function (Browser $browser) {
                    $browser->driver->getKeyboard()->sendKeys(WebDriverKeys::ENTER);
                })
                ->click('.btn')
                ->waitForText('G1')
                ->assertSee('tagteste')
                ->assertSee('maisumatag');
        });
    }
}
