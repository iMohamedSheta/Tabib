<?php

namespace App\Services\User;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class GetProfilePhotoUrlService
{
    public static function handle($profile_photo_path, $username, $first_name)
    {
        if (str_starts_with((string) $profile_photo_path, 'http')) {
            return $profile_photo_path;
        }

        return $profile_photo_path
            ? self::generateTemporaryUrl($profile_photo_path)
            : self::defaultProfilePhotoUrl($username, $first_name);
    }

    protected static function generateTemporaryUrl($profile_photo_path): string
    {
        $disk = Storage::disk(config('jetstream.profile_photo_disk', 'public'));

        if ($disk->exists($profile_photo_path)) {
            return URL::temporarySignedRoute(
                'storage.private.tmp.profile_picture',
                now()->addMinutes(10),
                ['profilePhotoPath' => encrypt($profile_photo_path)]
            );
        }

        return self::defaultProfilePhotoUrl(null, null);
    }

    public static function defaultProfilePhotoUrl($username, $first_name): string
    {
        $useName = $username ?? $first_name ?? 'X';

        $name = trim(collect(explode(' ', (string) $useName))->map(fn ($segment): string => mb_substr($segment, 0, 1))->join(' '));

        return 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&color=7F9CF5&background=EBF4FF';
    }
}
