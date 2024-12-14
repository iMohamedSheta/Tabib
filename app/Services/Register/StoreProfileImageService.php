<?php

namespace App\Services\Register;

use Illuminate\Support\Facades\Storage;

class StoreProfileImageService
{
    public static function handleFacebookImage($imageURL, $userId)
    {
        try {
            $imageContents = file_get_contents($imageURL);

            if ($imageContents) {
                $filename = 'facebook/' . $userId . '/' . $userId . '_' . time() . '.jpg';
                $saved = Storage::disk(config('jetstream.profile_photo_disk', 'public'))->put($filename, $imageContents);
                if ($saved) {
                    return $filename;
                }

                throw new \Exception('Failed to store profile image');
            }

            return null;
        } catch (\Exception $e) {
            log_error($e);
            return null;
        }
    }
}
