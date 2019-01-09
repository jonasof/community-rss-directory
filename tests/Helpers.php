<?php

namespace Tests;

use App\Feed\SourceDownloader;

trait Helpers
{
    function mockValidFeedSource ()
    {
        $mockedDownloader = $this->createMock(SourceDownloader::class);
        $mockedDownloader
            ->method('download')
            ->willReturn(file_get_contents(base_path('tests/Fixtures/Sources/Valid/folha.xml')));

        app()->instance(SourceDownloader::class, $mockedDownloader);
    }

    function mockValidPodcastFeedSource ()
    {
        $mockedDownloader = $this->createMock(SourceDownloader::class);
        $mockedDownloader
            ->method('download')
            ->willReturn(file_get_contents(base_path('tests/Fixtures/Sources/Valid/podcast-nbw.xml')));

        app()->instance(SourceDownloader::class, $mockedDownloader);
    }

    function mockInvalidFeedSource ()
    {
        $mockedDownloader = $this->createMock(SourceDownloader::class);
        $mockedDownloader
            ->method('download')
            ->willReturn(file_get_contents(base_path('tests/Fixtures/Sources/Invalid/duckduckgo.html')));

        app()->instance(SourceDownloader::class, $mockedDownloader);
    }
}
