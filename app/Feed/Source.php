<?php

namespace App\Feed;

use Zend\Feed\Reader\Reader;
use GuzzleHttp\Exception\RequestException;
use Zend\Feed\Reader\Exception\RuntimeException;
use Zend\Feed\Reader\Feed\AbstractFeed;
use App\Helpers\Http;

class Source
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

    function getFeedMeta(): Meta
    {
        $imported = $this->import();

        return new Meta([
            'url' => $this->url,
            'title' => $imported->getTitle(),
            'homepage' => $imported->getLink(),
            'description' => $imported->getDescription(),
            'type' => (new TypeResolver($imported))->getType(),
            'image_url' => $this->getImageUrl($imported),
            'icon_url' => $this->getIconUrl($imported)
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

    function download(): string
    {
        return app(SourceDownloader::class)->download($this->url);
    }

    protected function getImageUrl(AbstractFeed $feed) : ?string
    {
        return method_exists($feed, 'getImage')
            ? $feed->getImage()['uri']
            : null;
    }

    protected function getIconUrl(AbstractFeed $feed) : ?string
    {
        $parsed = parse_url($feed->getLink());

        if (!$parsed['scheme'] || !$parsed['host']) {
            return null;
        }

        $url = $parsed['scheme'] . "://" . $parsed['host'] . "/favicon.ico";

        if (!Http::isUrlValid($url)) {
            return null;
        }

        return $url;
    }
}
