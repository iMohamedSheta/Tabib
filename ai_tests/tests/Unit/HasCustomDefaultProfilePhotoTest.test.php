<?php

use App\Models\User;
use App\Services\Internal\User\GetProfilePhotoUrlService;

use function Pest\Laravel\mock;

uses()->group('User');

beforeEach(function (): void {
    $this->user = User::factory()->make();
});

it('profilePhotoUrl attribute calls GetProfilePhotoUrlService with correct parameters', function () {
    $mock = mock(GetProfilePhotoUrlService::class);
    $mock->shouldReceive('handle')
        ->once()
        ->with(null, $this->user->username, $this->user->first_name)
        ->andReturn('test-url');

    app()->instance(GetProfilePhotoUrlService::class, $mock);

    $url = $this->user->profile_photo_url;

    expect($url)->toBe('test-url');
});

it('profilePhotoUrl attribute uses existing profile_photo_path if available', function () {
    $this->user->profile_photo_path = 'existing-path';

    $mock = mock(GetProfilePhotoUrlService::class);
    $mock->shouldReceive('handle')
        ->once()
        ->with('existing-path', $this->user->username, $this->user->first_name)
        ->andReturn('test-url');

    app()->instance(GetProfilePhotoUrlService::class, $mock);

    $url = $this->user->profile_photo_url;

    expect($url)->toBe('test-url');
});
