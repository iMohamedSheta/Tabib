<?php

use App\Models\Media;
use App\Services\Internal\Media\MediaUrlGeneratorService;
use Illuminate\Support\Facades\URL;


it('generates a temporary URL for a media item', function () {
    // Mock the URL::route method to return a specific URL
    URL::shouldReceive('route')
        ->once()
        ->with('storage.private.tmp.media', ['encryptedMedia' => encrypt(1)])
        ->andReturn('http://example.com/temporary-media-url');

    $service = new MediaUrlGeneratorService();
    $url = $service->handle(1);

    expect($url)->toBe('http://example.com/temporary-media-url');
});

