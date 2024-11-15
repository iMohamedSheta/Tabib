<?php

namespace App\Services\User;

use Illuminate\Support\Facades\Storage;

class GetProfilePhotoUrlService
{
    public static function handle($profile_photo_path, $username, $first_name) {

        if (str_starts_with($profile_photo_path, 'http')) {
            return $profile_photo_path;
        }
        return $profile_photo_path
                ? Storage::disk(config('jetstream.profile_photo_disk', 'public'))->url($profile_photo_path)
                : self::defaultProfilePhotoUrl($username, $first_name);
    }

    public static function defaultProfilePhotoUrl($username, $first_name)
    {
        $useName = $username ?? $first_name ?? 'X';

        $name = trim(collect(explode(' ', $useName))->map(function ($segment) {
            return mb_substr($segment, 0, 1);
        })->join(' '));

        return 'https://ui-avatars.com/api/?name='.urlencode($name).'&color=7F9CF5&background=EBF4FF';
    }
}
