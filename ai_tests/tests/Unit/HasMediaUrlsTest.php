<?php

use App\Models\Media;
use App\Services\Internal\Media\MediaUrlGeneratorService;

uses(Tests\TestCase::class);

describe('HasMediaUrls Trait', function () {
    it('should return the media URL', function () {
        // Arrange
        $media = Media::factory()->create();
        $mediaUrlGeneratorServiceMock = Mockery::mock(MediaUrlGeneratorService::class);
        $mediaUrlGeneratorServiceMock->shouldReceive('handle')
            ->with($media->id)
            ->andReturn('http://example.com/media/' . $media->id);

        $this->app->bind(MediaUrlGeneratorService::class, function () use ($mediaUrlGeneratorServiceMock) {
            return $mediaUrlGeneratorServiceMock;
        });

        // Act
        $url = $media->url;

        // Assert
        expect($url)->toBe('http://example.com/media/' . $media->id);
    });

    it('should call the MediaUrlGeneratorService with the correct media ID', function () {
        // Arrange
        $media = Media::factory()->create();
        $mediaUrlGeneratorServiceMock = Mockery::mock(MediaUrlGeneratorService::class);
        $mediaUrlGeneratorServiceMock->shouldReceive('handle')
            ->with($media->id)
            ->andReturn('http://example.com/media/' . $media->id);

        $this->app->bind(MediaUrlGeneratorService::class, function () use ($mediaUrlGeneratorServiceMock) {
            return $mediaUrlGeneratorServiceMock;
        });

        // Act
        $media->url;

        // Assert
        $mediaUrlGeneratorServiceMock->shouldHaveReceived('handle')->with($media->id);
    });
});
