<?php

namespace App\Utils;

use \GuzzleHttp\Client;

class FeedSourceDownloader
{
    public function download(string $url): string
    {
        $client = new Client();
        $response = $client->request('GET', $url);

        return $response->getBody();
    }
}
