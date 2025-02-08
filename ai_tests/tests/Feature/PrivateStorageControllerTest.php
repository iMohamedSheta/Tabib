<?php

use App\Http\Controllers\Storage\PrivateStorageController;
use App\Models\Media;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class, WithFaker::class);


beforeEach(function (): void {
    Storage::fake('public');
});


describe('PrivateStorageController', function () {
    describe('showMedia', function () {
        it('should return a 403 if the user is not authorized to view the media', function () {
            $user = User::factory()->create();
            $media = Media::factory()->create();
            Gate::shouldReceive('allows')
                ->with('view', $media)
                ->andReturn(false);
            
            $this->actingAs($user);

            $encryptedMedia = encrypt($media->id);

            $response = $this->get(route('media.show', $encryptedMedia));

            $response->assertStatus(403);
        });

        it('should return a 404 if the file does not exist', function () {
            $user = User::factory()->create();
            $media = Media::factory()->create();
            Gate::shouldReceive('allows')
                ->with('view', $media)
                ->andReturn(true);

            $this->actingAs($user);

            $encryptedMedia = encrypt($media->id);

            $response = $this->get(route('media.show', $encryptedMedia));

            $response->assertStatus(404);
        });

        it('should return the file if the user is authorized and the file exists', function () {
            $user = User::factory()->create();
            $media = Media::factory()->create();

            Gate::shouldReceive('allows')
                ->with('view', $media)
                ->andReturn(true);

            $this->actingAs($user);

            $filePath = $media->getPath();

            Storage::disk('public')->put($filePath, 'test content');
            $fullPath = Storage::disk('public')->path($filePath);

            $encryptedMedia = encrypt($media->id);
            
            $response = $this->get(route('media.show', $encryptedMedia));

            $response->assertStatus(200);
            $response->assertHeader('Content-Type', mime_content_type($fullPath));
            $response->assertHeader('Content-Disposition', 'inline');
            $this->assertStringContainsString('test content', $response->getContent());
        });
    });

    describe('showProfilePicture', function () {
        it('should return a 403 if the user is not authorized to view the profile picture', function () {
            $user = User::factory()->create();
            Auth::shouldReceive('user')
                ->andReturn($user);
            Gate::shouldReceive('allows')
                ->with('view', $user)
                ->andReturn(false);

            $this->actingAs($user);

            $encryptedPath = encrypt('path/to/profile.jpg');

            $response = $this->get(route('profile.show', $encryptedPath));

            $response->assertStatus(403);
        });

        it('should return a 404 if the file does not exist', function () {
            $user = User::factory()->create();

            Auth::shouldReceive('user')
                ->andReturn($user);

            Gate::shouldReceive('allows')
                ->with('view', $user)
                ->andReturn(true);

            $this->actingAs($user);
            $encryptedPath = encrypt('path/to/profile.jpg');

            $response = $this->get(route('profile.show', $encryptedPath));

            $response->assertStatus(404);
        });

        it('should return the file if the user is authorized and the file exists', function () {
            $user = User::factory()->create();
            Auth::shouldReceive('user')
                ->andReturn($user);
            Gate::shouldReceive('allows')
                ->with('view', $user)
                ->andReturn(true);

            $this->actingAs($user);

            $profilePhotoPath = 'path/to/profile.jpg';
            Storage::disk('public')->put($profilePhotoPath, 'profile picture content');
            $fullPath = Storage::disk('public')->path($profilePhotoPath);

            $encryptedPath = encrypt($profilePhotoPath);

            $response = $this->get(route('profile.show', $encryptedPath));

            $response->assertStatus(200);
            $response->assertHeader('Content-Type', mime_content_type($fullPath));
            $response->assertHeader('Content-Disposition', 'inline');
            $this->assertStringContainsString('profile picture content', $response->getContent());
        });
    });
});
