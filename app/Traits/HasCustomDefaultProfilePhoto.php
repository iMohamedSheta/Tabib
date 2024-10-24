<?php

namespace App\Traits;


use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;


trait HasCustomDefaultProfilePhoto
{
    protected function defaultProfilePhotoUrl()
    {
        $name = trim(collect(explode(' ', $this->username))->map(function ($segment) {
            return mb_substr($segment, 0, 1);
        })->join(' '));

        return 'https://ui-avatars.com/api/?name='.urlencode($name).'&color=7F9CF5&background=EBF4FF';
    }


    public function profilePhotoUrl(): Attribute
    {
        return Attribute::get(function (): string
        {
            if (str_starts_with($this->profile_photo_path, 'http')) {
                return $this->profile_photo_path;
            }

            return $this->profile_photo_path
                    ? Storage::disk($this->profilePhotoDisk())->url($this->profile_photo_path)
                    : $this->defaultProfilePhotoUrl();
        });
    }
}
