<?php

namespace App\Helpers;

use GuzzleHttp\Client;

class Http
{
    static function isUrlValid(string $url) : bool
    {
        try {
            (new Client())->head($url);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
