<?php

namespace App\Feed;

class Validator
{
    public static function isValidFeedSource($url): bool
    {
        return (new Source($url))->isValidSource();
    }
}
