<?php

use App\Enums\User\Auth\OAuthProviderEnum;
use App\Http\Controllers\Auth\Socialite\GoogleSocialiteController;
use App\Models\ClinicAdmin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\post;


beforeEach(function (): void {
    $this->mockSocialiteUser = Mockery::mock('Laravel\Socialite\Contracts\User');
    $this->mockSocialiteProvider = Mockery::mock('Laravel\Socialite\Contracts\Provider');

    $this->mockSocialiteUser->shouldReceive([ // Define expectations for user data returned from Socialite.
        'getId' => 'google_user_id',
        'getEmail' => 'test@example.com',
        'getName' => 'Test User',
        'getFirstName' => 'Test',
        'getLastName' => 'User',
        'getAvatar' => 'https://example.com/avatar.jpg',
    ]);

    $this->mockSocialiteProvider->shouldReceive('user')->andReturn($this->mockSocialiteUser);
    Socialite::shouldReceive('driver')->with('google')->andReturn($this->mockSocialiteProvider);
});


describe('GoogleSocialiteController', function () {

    it('redirects to Google for authentication', function () {
        Socialite::shouldReceive('driver')->with('google')->andReturnSelf();
        Socialite::shouldReceive('redirect')->andReturn(
            redirect('/login/google/callback')
        );
        $response = get(action([GoogleSocialiteController::class, 'redirect']));
        $response->assertStatus(302);
    });

    it('handles callback from Google and authenticates user if they exist', function () {

        $user = User::factory()->create([
            'email' => 'test@example.com',
            'oauth_id' => 'google_user_id',
            'oauth_provider' => OAuthProviderEnum::GOOGLE,
            'role' => ClinicAdmin::class,
        ]);

        $clinicAdmin = ClinicAdmin::factory()->create(['user_id' => $user->id, 'organization_id' => $user->organization_id]);
        Auth::shouldReceive('login')->with($user)->once();

        $response = get(action([GoogleSocialiteController::class, 'callback']));

        $response->assertRedirect(route('app.admin.dashboard'));
        expect(Auth::check())->toBeTrue();
        expect(Auth::user()->id)->toEqual($user->id);
    });

    it('handles callback from Google and creates a new user if they do not exist and redirects to register steps if clinic admin is not found', function () {
        $response = get(action([GoogleSocialiteController::class, 'callback']));

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'oauth_id' => 'google_user_id',
            'oauth_provider' => OAuthProviderEnum::GOOGLE,
            'first_name' => 'Test',
            'last_name' => 'User',
        ]);

        $user = User::where('email', 'test@example.com')->first();

        $response->assertViewIs('auth.register-steps.oauth-callback');
        $response->assertViewHas('user', $user);

        expect(Auth::check())->toBeFalse();
    });

});
