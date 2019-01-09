<?php

namespace App\Feed;

use \GuzzleHttp\Client;

class SourceDownloader
{
    public function download(string $url): string
    {
        $client = new Client();
        $response = $client->request('GET', $url);

        return $response->getBody();
    }
}
