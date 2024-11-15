<?php

namespace App\Http\Controllers\Auth\Socialite;

use App\Enums\User\Auth\OAuthProviderEnum;
use App\Enums\User\UserRoleEnum;
use App\Http\Controllers\Controller;
use App\Models\ClinicAdmin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;

class FacebookSocialiteController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback()
    {
        $socialite = Socialite::driver('facebook')->user();
        // Use optional chaining to prevent errors if `name` is not set
        $fullname = explode(" ", $socialite->name ?? '', 2);

        $userData = [
            'given_name' => $fullname[0] ?? '',
            'family_name' => $fullname[1] ?? '',
            'email' => $socialite->email ?? null,
            'avatar' => $socialite->avatar ?? null,
            'id' => $socialite->id,
            'token' => $socialite->token,
            'expiresIn' => $socialite->expiresIn,
            'approvedScopes' => $socialite->approvedScopes ?? []
        ];

        // Search for existing user either by OAuth ID or email
        $user = User::where(function ($query) use ($userData) {
            $query->where('oauth_id', $userData['id'])
                ->where('oauth_provider', OAuthProviderEnum::META);
        })->orWhere('email', $userData['email'])->first();

        // Create a new user if none exists
        if (!$user)
        {
            // Download and save profile image
            if ($userData['avatar']) {
                $imageURL = "{$userData['avatar']}?type=large&access_token={$userData['token']}";
                $imageName = $this->storeProfileImage($imageURL, $userData['id']);
                $userData['avatar'] = $imageName;
            }

            $user = User::create([
                'first_name' => $userData['given_name'],
                'last_name' => $userData['family_name'] ?: 'Unknown', // Better than 'x'
                'email' => $userData['email'],
                'profile_photo_path' => $userData['avatar'],
                'email_verified_at' => now(),
                'role' => ClinicAdmin::class,
                'oauth_id' => $userData['id'],
                'oauth_provider' => OAuthProviderEnum::META,
                'oauth_token' => $userData['token'],
                'oauth_token_expires_in' => $userData['expiresIn'],
                'oauth_scopes' => json_encode($userData['approvedScopes']),
            ]);
        }

        // Check for associated clinic admin and login
        $clinicAdmin = ClinicAdmin::firstWhere('user_id', $user->id);

        if (!$clinicAdmin) {
            return view('auth.register-steps.oauth-callback', ['user' => $user]);
        }

        Auth::login($user);

        return redirect(UserRoleEnum::authRedirectRouteBasedOnType());
    }

    private function storeProfileImage($imageURL, $userId)
    {
        try {
            $imageContents = file_get_contents($imageURL);

            if ($imageContents) {
                $filename = 'facebook/'. $userId. '/' .$userId . '_' . time() . '.jpg';
                $saved = Storage::disk(config('jetstream.profile_photo_disk', 'public'))->put($filename, $imageContents);
                if($saved) {
                    return $filename;
                }

                dd('fail');
            }
        } catch (\Exception $e) {
            Log::error("Failed to download or store profile image: {$e->getMessage()}");
        }

        return null;  // Return null if the image couldn't be stored
    }


}
