<?php

namespace App\Utils;

use Zend\Feed\Reader\Feed\AbstractFeed;

class FeedTypeResolver
{
    public function __construct(AbstractFeed $feedSource)
    {
        $this->feed_source = $feedSource;
    }

    public function getType()
    {
        $enclosure = $this->feed_source->current()->getEnclosure();
        $type = $enclosure->type ?? '';

        if (str_contains($type, 'audio')) {
            return 'podcast';
        }

        return 'rss';
    }
}