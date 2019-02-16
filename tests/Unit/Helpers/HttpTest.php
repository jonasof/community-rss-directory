<?php

namespace Tests\Unit\Helpers;

use Tests\TestCase;
use App\Helpers\{Http};
use GuzzleHttp\Client;
use Exception;

class HttpTest extends TestCase
{
    function testIsUrlValidReturnsFalse()
    {
        app()->instance(Client::class, new class() {
            function head() {
                throw new Exception();
            }
        });

        $result = Http::isUrlValid('any_url');

        $this->assertFalse($result);
    }
}