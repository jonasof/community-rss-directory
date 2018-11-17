<?php

namespace App\Utils;

class FeedSourceDownloader
{
    public function download(string $url): string
    {
        return file_get_contents($url);
    }
}
