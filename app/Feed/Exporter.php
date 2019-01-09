<?php

namespace App\Feed;

use Celd\Opml\Importer as CeldExporter;
use Celd\Opml\Model\FeedList;
use Celd\Opml\Model\Feed;

class Exporter
{
    public function export($feeds): string
    {
        $feedList = new FeedList();

        foreach ($feeds as $feed) {
            $f = new Feed();
            $f->setTitle($feed->title);
            $f->setXmlUrl($feed->url);
            $f->setType('rss');
            $feedList->addItem($f);
        }

        $importer = new CeldExporter();
        return $importer->export($feedList);
    }
}
