<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feed;
use App\Http\Requests\StoreFeedRequest;
use App\Feeds\{Source, Exporter};
use Cache;

class FeedController extends Controller
{
    public function index(Request $request)
    {
        return datatables()->of(Feed::withTags($request->tag))->toJson();
    }

    public function store(StoreFeedRequest $request)
    {
        return Feed::create($request->all());
    }

    public function update(StoreFeedRequest $request, $id)
    {
        $feed = Feed::findOrFail($id);
        $feed->update($request->all());
        return $feed;
    }

    public function show(int $id)
    {
        return Feed::find($id);
    }

    public function tags()
    {
        return Feed::existingTags();
    }

    public function parse(Request $request)
    {
        try {
            $feedMeta = (new Source($request->url))->getFeedMeta();
            return response()->json($feedMeta);
        } catch (\Exception $e) {
            return response()->json([
                "error" => "Error parsing data from url $request->url. Details: ${$e->getMessage()})"
            ], 400);
        }
    }

    public function export(Request $request)
    {
        $feeds = datatables()->of(Feed::withTags($request->tag))
            ->skipPaging()
            ->getFilteredQuery()
            ->get();

        return response()->streamDownload(function () use ($feeds) {
            $exporter = new Exporter();
            echo $exporter->export($feeds);
        }, 'response.opml');
    }

    public function download(int $id)
    {
        $feed = Feed::findOrFail($id);

        $minutes = 10;

        return Cache::remember("feed_$id", $minutes, function () use ($feed) {
            return (new Source($feed->url))->download();
        });
    }
}