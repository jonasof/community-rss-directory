<?php

declare(strict_types = 1);

namespace App\Utils;

class FeedValidator
{
    public static function isValidFeedSource($url): bool
    {
        return (new FeedSource($url))->isValidSource();
    }
}
