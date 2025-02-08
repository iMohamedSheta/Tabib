<?php

use App\Services\Internal\User\GetProfilePhotoUrlService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;


beforeEach(function () {
    Storage::fake('public');
});

describe('GetProfilePhotoUrlService', function () {
    it('should return the profile photo URL if it starts with http', function () {
        $profilePhotoPath = 'http://example.com/image.jpg';
        $username = 'testuser';
        $firstName = 'Test';

        $result = GetProfilePhotoUrlService::handle($profilePhotoPath, $username, $firstName);

        expect($result)->toBe($profilePhotoPath);
    });

    it('should generate a profile URL if the profile photo path exists', function () {
        $profilePhotoPath = 'profile-photos/test.jpg';
        $username = 'testuser';
        $firstName = 'Test';

        Storage::disk(config('jetstream.profile_photo_disk', 'public'))->put($profilePhotoPath, 'test content');
        
        URL::shouldReceive('route')
            ->once()
            ->with('storage.private.tmp.profile_picture', ['profilePhotoPath' => encrypt($profilePhotoPath)])
            ->andReturn('http://example.com/storage/profile-photos/test.jpg');

        $result = GetProfilePhotoUrlService::handle($profilePhotoPath, $username, $firstName);

        expect($result)->toBe('http://example.com/storage/profile-photos/test.jpg');
    });

    it('should return the default profile photo URL if the profile photo path does not exist', function () {
        $profilePhotoPath = 'profile-photos/nonexistent.jpg';
        $username = 'testuser';
        $firstName = 'Test';

        $defaultUrl = GetProfilePhotoUrlService::defaultProfilePhotoUrl($username, $firstName);
        
        $result = GetProfilePhotoUrlService::handle($profilePhotoPath, $username, $firstName);

        expect($result)->toBe($defaultUrl);
    });

    it('should return the default profile photo URL if the profile photo path is null', function () {
        $profilePhotoPath = null;
        $username = 'testuser';
        $firstName = 'Test';

        $defaultUrl = GetProfilePhotoUrlService::defaultProfilePhotoUrl($username, $firstName);

        $result = GetProfilePhotoUrlService::handle($profilePhotoPath, $username, $firstName);

        expect($result)->toBe($defaultUrl);
    });

    it('should generate the correct default profile photo URL with username', function () {
        $username = 'testuser';
        $firstName = null;

        $result = GetProfilePhotoUrlService::defaultProfilePhotoUrl($username, $firstName);

        expect($result)->toBe('https://ui-avatars.com/api/?name=t&color=7F9CF5&background=EBF4FF');
    });

    it('should generate the correct default profile photo URL with first name', function () {
        $username = null;
        $firstName = 'Test User';

        $result = GetProfilePhotoUrlService::defaultProfilePhotoUrl($username, $firstName);

        expect($result)->toBe('https://ui-avatars.com/api/?name=T U&color=7F9CF5&background=EBF4FF');
    });

    it('should generate the correct default profile photo URL with username and firstname', function () {
        $username = 'Test User';
        $firstName = 'Test User';

        $result = GetProfilePhotoUrlService::defaultProfilePhotoUrl($username, $firstName);

        expect($result)->toBe('https://ui-avatars.com/api/?name=T&color=7F9CF5&background=EBF4FF');
    });

    it('should generate the correct default profile photo URL with default X', function () {
        $username = null;
        $firstName = null;

        $result = GetProfilePhotoUrlService::defaultProfilePhotoUrl($username, $firstName);

        expect($result)->toBe('https://ui-avatars.com/api/?name=X&color=7F9CF5&background=EBF4FF');
    });
});
