<?php

namespace Tests\Unit\Util;

use Tests\TestCase;

use App\Utils\{FeedValidator};

class FeedValidatorTest extends TestCase
{
    public function testSourceIsValid()
    {
        $this->mockValidFeedSource();

        $this->assertTrue(FeedValidator::isValidFeedSource("http://feeds.folha.uol.com.br/rss091.xml"));
    }

    public function testSourceIsInvalid()
    {
        $this->mockInvalidFeedSource();

        $this->assertFalse(FeedValidator::isValidFeedSource("http://duckduckgo.com"));
    }
}
