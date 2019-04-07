<?php

namespace App\Feed;

class Validator
{
    public static function isValidFeedSource($url): bool
    {
        return app(Source::class, ['url' => $url])->isValidSource();
    }
}
