<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Facebook\WebDriver\WebDriverKeys;

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

    /**
     * @depends testCreateNewFeed
     */
    public function testEditFeed()
    {
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

    /**
     * @depends testCreateNewFeed
     */
    public function testListFeed()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit('/')
                ->waitForText('G1')
                ->assertSee('G1');
          });
    }
}
