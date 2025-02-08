<?php

namespace App\Http\Controllers\Auth\Socialite;

use App\Enums\User\Auth\OAuthProviderEnum;
use App\Http\Controllers\Controller;
use App\Models\ClinicAdmin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleSocialiteController extends Controller
{
    // Login or Register
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $socialite = Socialite::driver('google')->user();
        $userData = $socialite->user;
        // Check if the user already exists
        $user = User::where(function ($query) use ($userData): void {
            $query->where('oauth_id', $userData['id'])
                ->where('oauth_provider', OAuthProviderEnum::GOOGLE);
        })->orWhere('email', $userData['email'])->first();

        // If the user doesn't exist, create a new one
        if (!$user) {
            $user = User::create([
                'first_name' => $userData['given_name'],
                'last_name' => $userData['family_name'],
                'email' => $userData['email'],
                'profile_photo_path' => $userData['picture'],
                'email_verified_at' => now(),
                'role' => ClinicAdmin::class,
                'oauth_id' => $userData['sub'], // Use 'subject identifier (user id) in most cases' (OAuth ID)
                'oauth_provider' => OAuthProviderEnum::GOOGLE,
                'oauth_token' => $socialite->token,
                'oauth_token_expires_in' => $socialite->expiresIn,
                'oauth_scopes' => json_encode($socialite->approvedScopes),
            ]);
        }

        $clinicAdmin = ClinicAdmin::withoutGlobalScopes()->where('user_id', $user->id)->first();

        if (!$clinicAdmin) {
            return view(
                'auth.register-steps.oauth-callback',
                [
                    'user' => $user,
                ],
            );
        }

        Auth::login($user);

        return to_route('app.admin.dashboard');
    }
}
