<?php

use App\Enums\Media\MediaCollectionEnum;

it('can determine the correct collection for image mime types', function () {
    expect(MediaCollectionEnum::determineCollection('image/png'))->toBe(MediaCollectionEnum::IMAGES);
    expect(MediaCollectionEnum::determineCollection('image/jpg'))->toBe(MediaCollectionEnum::IMAGES);
    expect(MediaCollectionEnum::determineCollection('image/jpeg'))->toBe(MediaCollectionEnum::IMAGES);
    expect(MediaCollectionEnum::determineCollection('image/gif'))->toBe(MediaCollectionEnum::IMAGES);
    expect(MediaCollectionEnum::determineCollection('image/bmp'))->toBe(MediaCollectionEnum::IMAGES);
    expect(MediaCollectionEnum::determineCollection('image/svg+xml'))->toBe(MediaCollectionEnum::IMAGES);
    expect(MediaCollectionEnum::determineCollection('image/webp'))->toBe(MediaCollectionEnum::IMAGES);
});

it('can determine the correct collection for video mime types', function () {
    expect(MediaCollectionEnum::determineCollection('video/mp4'))->toBe(MediaCollectionEnum::VIDEOS);
    expect(MediaCollectionEnum::determineCollection('video/mov'))->toBe(MediaCollectionEnum::VIDEOS);
    expect(MediaCollectionEnum::determineCollection('video/avi'))->toBe(MediaCollectionEnum::VIDEOS);
    expect(MediaCollectionEnum::determineCollection('video/wmv'))->toBe(MediaCollectionEnum::VIDEOS);
});

it('can determine the correct collection for audio mime types', function () {
    expect(MediaCollectionEnum::determineCollection('audio/mp3'))->toBe(MediaCollectionEnum::AUDIOS);
    expect(MediaCollectionEnum::determineCollection('audio/wav'))->toBe(MediaCollectionEnum::AUDIOS);
    expect(MediaCollectionEnum::determineCollection('audio/m4a'))->toBe(MediaCollectionEnum::AUDIOS);
    expect(MediaCollectionEnum::determineCollection('audio/wma'))->toBe(MediaCollectionEnum::AUDIOS);
});

it('can determine the correct collection for document mime types', function () {
    expect(MediaCollectionEnum::determineCollection('application/pdf'))->toBe(MediaCollectionEnum::DOCUMENTS);
    expect(MediaCollectionEnum::determineCollection('application/msword'))->toBe(MediaCollectionEnum::DOCUMENTS);
    expect(MediaCollectionEnum::determineCollection('application/vnd.openxmlformats-officedocument.wordprocessingml.document'))->toBe(MediaCollectionEnum::DOCUMENTS);
    expect(MediaCollectionEnum::determineCollection('application/vnd.ms-excel'))->toBe(MediaCollectionEnum::DOCUMENTS);
    expect(MediaCollectionEnum::determineCollection('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'))->toBe(MediaCollectionEnum::DOCUMENTS);
    expect(MediaCollectionEnum::determineCollection('text/plain'))->toBe(MediaCollectionEnum::DOCUMENTS);
    expect(MediaCollectionEnum::determineCollection('text/csv'))->toBe(MediaCollectionEnum::DOCUMENTS);
    expect(MediaCollectionEnum::determineCollection('text/xml'))->toBe(MediaCollectionEnum::DOCUMENTS);
    expect(MediaCollectionEnum::determineCollection('application/json'))->toBe(MediaCollectionEnum::DOCUMENTS);
});

it('can determine the correct collection for archive mime types', function () {
    expect(MediaCollectionEnum::determineCollection('application/zip'))->toBe(MediaCollectionEnum::ARCHIVES);
    expect(MediaCollectionEnum::determineCollection('application/x-zip-compressed'))->toBe(MediaCollectionEnum::ARCHIVES);
    expect(MediaCollectionEnum::determineCollection('application/x-rar-compressed'))->toBe(MediaCollectionEnum::ARCHIVES);
});

it('defaults to others for unknown mime types', function () {
    expect(MediaCollectionEnum::determineCollection('unknown/mime'))->toBe(MediaCollectionEnum::OTHERS);
});

it('can get the correct enum instance from a collection value', function () {
    expect(MediaCollectionEnum::getCollection('images'))->toBe(MediaCollectionEnum::IMAGES);
    expect(MediaCollectionEnum::getCollection('videos'))->toBe(MediaCollectionEnum::VIDEOS);
    expect(MediaCollectionEnum::getCollection('documents'))->toBe(MediaCollectionEnum::DOCUMENTS);
    expect(MediaCollectionEnum::getCollection('others'))->toBe(MediaCollectionEnum::OTHERS);
});

it('defaults to others when getting collection from unknown value', function () {
    expect(MediaCollectionEnum::getCollection('unknown'))->toBe(MediaCollectionEnum::OTHERS);
});
