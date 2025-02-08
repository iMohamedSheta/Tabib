<?php

use App\Enums\User\Auth\OAuthProviderEnum;
use App\Enums\User\UserRoleEnum;
use App\Http\Controllers\Auth\Socialite\FacebookSocialiteController;
use App\Models\ClinicAdmin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;

use function Pest\Laravel\get;

uses(RefreshDatabase::class);


beforeEach(function (): void {
    Storage::fake('public');
});

it('redirects to facebook', function (): void {
    Socialite::shouldReceive('driver->redirect')->andReturn('Redirected');

    $response = (new FacebookSocialiteController())->redirect();

    expect($response)->toBe('Redirected');
});

describe('callback', function () {
    it('creates a new user if one does not exist', function (): void {
        Socialite::shouldReceive('driver->stateless->user')->andReturn((object) [
            'id' => 'facebook_id',
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'avatar' => 'http://example.com/avatar.jpg',
            'token' => 'facebook_token',
            'expiresIn' => 3600,
            'approvedScopes' => [],
        ]);

        Storage::fake('public');

        $this->get(route('facebook.callback'))
            ->assertViewIs('auth.register-steps.oauth-callback')
            ->assertViewHas('userData', function ($userData) {
                expect($userData['first_name'])->toBe('John')
                    ->and($userData['last_name'])->toBe('Doe')
                    ->and($userData['email'])->toBe('john.doe@example.com')
                    ->and($userData['oauth_id'])->toBe('facebook_id')
                    ->and($userData['oauth_provider'])->toBe(OAuthProviderEnum::META)
                    ->and($userData['oauth_token'])->toBe('facebook_token')
                    ->and($userData['oauth_token_expires_in'])->toBe(3600)
                    ->and($userData['oauth_scopes'])->toBeEmpty()
                    ->and($userData['role'])->toBe(ClinicAdmin::class);

                return true;
            });

        $this->assertDatabaseMissing('users', ['email' => 'john.doe@example.com']);
    });

    it('logs in an existing user if one exists', function (): void {
        $user = User::factory()->create([
            'email' => 'john.doe@example.com',
            'oauth_id' => 'facebook_id',
            'oauth_provider' => OAuthProviderEnum::META,
        ]);

        Socialite::shouldReceive('driver->stateless->user')->andReturn((object) [
            'id' => 'facebook_id',
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'avatar' => 'http://example.com/avatar.jpg',
            'token' => 'facebook_token',
            'expiresIn' => 3600,
            'approvedScopes' => [],
        ]);

        Auth::shouldReceive('login')->once()->with($user);

        $this->get(route('facebook.callback'))
            ->assertRedirect(UserRoleEnum::authRedirectRouteBasedOnType());
    });

    it('handles the case where only the email exists', function (): void {
        $user = User::factory()->create([
            'email' => 'john.doe@example.com',
        ]);

        Socialite::shouldReceive('driver->stateless->user')->andReturn((object) [
            'id' => 'facebook_id',
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'avatar' => 'http://example.com/avatar.jpg',
            'token' => 'facebook_token',
            'expiresIn' => 3600,
            'approvedScopes' => [],
        ]);

        Auth::shouldReceive('login')->once()->with($user);

        $this->get(route('facebook.callback'))
            ->assertRedirect(UserRoleEnum::authRedirectRouteBasedOnType());

    });
});
