<?php

use App\Models\User;
use App\Services\Internal\User\GetProfilePhotoUrlService;
use App\Transformers\UserTransformer;

uses(Tests\TestCase::class);


beforeEach(function (): void {
    $this->user = User::factory()->make([
        'first_name' => 'John',
        'last_name' => 'Doe',
        'username' => 'johndoe',
        'profile_photo_path' => 'path/to/photo.jpg',
    ]);

    $this->userTransformer = new UserTransformer($this->user);
});


describe('fullname', function () {
    it('should set the fullname attribute on the item', function () {
        $this->userTransformer->fullname();

        expect($this->user->fullname)->toBe('John Doe');
    });
});


describe('profilePhotoUrl', function () {
    it('should set the profile_photo_url attribute on the item', function () {
        $mockedUrl = 'mocked_url';
        
        
        
        
        
        GetProfilePhotoUrlService::shouldReceive('handle')
            ->once()
            ->with(
                $this->user->profile_photo_path,
                $this->user->username,
                $this->user->first_name
            )
            ->andReturn($mockedUrl);

        $this->userTransformer->profilePhotoUrl();

        expect($this->user->profile_photo_url)->toBe($mockedUrl);
    });
});
