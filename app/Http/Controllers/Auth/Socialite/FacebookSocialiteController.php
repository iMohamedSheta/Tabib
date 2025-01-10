<?php

namespace App\Http\Controllers\Auth\Socialite;

use App\Enums\User\Auth\OAuthProviderEnum;
use App\Enums\User\UserRoleEnum;
use App\Http\Controllers\Controller;
use App\Models\ClinicAdmin;
use App\Models\User;
use App\Services\Register\StoreProfileImageService;
use App\Traits\Socialite\SocialiteResponseTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class FacebookSocialiteController extends Controller
{
    use SocialiteResponseTrait;

    public function redirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback()
    {
        $socialite = Socialite::driver('facebook')->stateless()->user();

        // Search for existing user either by OAuth ID or email
        $user = User::where(function ($query) use ($socialite): void {
            $query->where('oauth_id', $socialite->id)
                ->where('oauth_provider', OAuthProviderEnum::META);
        })->orWhere('email', $socialite->email)->first();

        if (! $user) {
            // Parse user data
            $fullname = explode(' ', $socialite->name ?? '', 2);

            $userData = [
                'first_name' => $fullname[0],
                'last_name' => $fullname[1] ?? 'Unknown',
                'email' => $socialite->email,
                'profile_photo_path' => null,
                'email_verified_at' => now()->toDateTimeString(),
                'oauth_id' => $socialite->id,
                'oauth_provider' => OAuthProviderEnum::META,
                'oauth_token' => $socialite->token,
                'oauth_token_expires_in' => $socialite->expiresIn,
                'oauth_scopes' => $socialite->approvedScopes ?? [],
                'role' => ClinicAdmin::class,
            ];

            // Download and save profile image
            if ($socialite->avatar) {
                $imageURL = sprintf('%s?type=large&access_token=%s', $socialite->avatar, $socialite->token);
                $userData['profile_photo_path'] = StoreProfileImageService::handleFacebookImage($imageURL, $socialite->id);
            }

            return view('auth.register-steps.oauth-callback', ['userData' => $userData]);
        }

        // Log in the existing user
        Auth::login($user);

        return redirect(UserRoleEnum::authRedirectRouteBasedOnType());
    }
}
