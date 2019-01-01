<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feed;
use App\Http\Requests\StoreFeedRequest;
use App\Utils\{FeedSource, Exporter};
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
            $feedMeta = (new FeedSource($request->url))->getFeedMeta();
            return response()->json($feedMeta);
        } catch (\Exception $e) {
            return response()->json([
                "error" => "Error parsing data from url $request->url. Details: ${$e->getMessage()})"
            ], 400);
        }
    }

    public function export()
    {
        return response()->streamDownload(function () {
            $exporter = new Exporter();
            echo $exporter->export(Feed::all());
        }, 'response.opml');
    }

    public function download(int $id)
    {
        $feed = Feed::findOrFail($id);

        $minutes = 10;

        return Cache::remember("feed_$id", $minutes, function () use ($feed) {
            return (new FeedSource($feed->url))->download();
        });
    }
}
