<?php

namespace App\Feed;

use Celd\Opml\Importer as CeldImporter;
use Celd\Opml\Model\Feed as OpmlFeed;
use App\Models\Feed;
use Illuminate\Support\Collection;

class Importer
{
    private $importer;

    public function __construct(CeldImporter $importer)
    {
        $this->importer = $importer;
    }

    /**
     * @return Collection<Feed>
     */
    public function getImportableItems(string $feedsFile): Collection
    {
        $feeds = $this->parseXml($feedsFile);

        return $feeds->map(function(Feed $feed) {
            $existentFeedId = Feed::where("url", $feed->url)->pluck('id')->first();

            if ($existentFeedId) {
                $feed->id = $existentFeedId;
            }

            return $feed;
        });
    }

    /**
     * @return Collection<Feed>
     */
    private function parseXml(string $feedsFile): Collection
    {
        $this->importer->import($feedsFile);
        $feeds = $this->importer->getFeedList()->getItems();

        return collect($feeds)->map(function(OpmlFeed $feed) {
            return new Feed([
                "url" => $feed->getXmlUrl(),
                "title" => $feed->getTitle(),
                "homepage" => $feed->getHtmlUrl()
            ]);
        });
    }
}
