<?php

namespace App\Utils;

use Zend\Feed\Reader\Reader;
use GuzzleHttp\Exception\RequestException;
use Zend\Feed\Reader\Exception\RuntimeException;
use Zend\Feed\Reader\Feed\AbstractFeed;

class FeedSource
{
    public $url;

    function __construct(string $url)
    {
        $this->url = $url;
    }

    function import(): AbstractFeed
    {
        return Reader::importString($this->download());
    }

    function getFeedMeta(): FeedMeta
    {
        $imported = $this->import();

        return new FeedMeta([
            'url' => $this->url,
            'title' => $imported->getTitle(),
            'homepage' => $imported->getLink(),
            'description' => $imported->getDescription(),
            'type' => (new FeedTypeResolver($imported))->getType()
        ]);
    }

    function isValidSource(): bool
    {
        try {
            $this->import();
            return true;
        } catch (RuntimeException | RequestException $e) {
            return false;
        }
    }

    protected function download(): string
    {
        return app(FeedSourceDownloader::class)->download($this->url);
    }
}
