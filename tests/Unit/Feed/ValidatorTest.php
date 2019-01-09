<?php

namespace Tests\Unit\Feed;

use Tests\TestCase;

use App\Feed\{Validator};

class ValidatorTest extends TestCase
{
    public function testSourceIsValid()
    {
        $this->mockValidFeedSource();

        $this->assertTrue(Validator::isValidFeedSource("http://feeds.folha.uol.com.br/rss091.xml"));
    }

    public function testSourceIsInvalid()
    {
        $this->mockInvalidFeedSource();

        $this->assertFalse(Validator::isValidFeedSource("http://duckduckgo.com"));
    }
}
