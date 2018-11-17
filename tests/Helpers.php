<?php

namespace Tests;

use App\Utils\FeedSourceDownloader;

trait Helpers
{
    function mockValidFeedSource ()
    {
        $mockedDownloader = $this->createMock(FeedSourceDownloader::class);
        $mockedDownloader
            ->method('download')
            ->willReturn(file_get_contents(base_path('tests/Fixtures/Sources/Valid/folha.xml')));

        app()->instance(FeedSourceDownloader::class, $mockedDownloader);
    }

    function mockValidPodcastFeedSource ()
    {
        $mockedDownloader = $this->createMock(FeedSourceDownloader::class);
        $mockedDownloader
            ->method('download')
            ->willReturn(file_get_contents(base_path('tests/Fixtures/Sources/Valid/podcast-nbw.xml')));

        app()->instance(FeedSourceDownloader::class, $mockedDownloader);
    }

    function mockInvalidFeedSource ()
    {
        $mockedDownloader = $this->createMock(FeedSourceDownloader::class);
        $mockedDownloader
            ->method('download')
            ->willReturn(file_get_contents(base_path('tests/Fixtures/Sources/Invalid/duckduckgo.html')));

        app()->instance(FeedSourceDownloader::class, $mockedDownloader);
    }
}
