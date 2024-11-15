<?php

namespace App\Traits;

use App\Services\User\GetProfilePhotoUrlService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;


trait HasCustomDefaultProfilePhoto
{
    public function profilePhotoUrl(): Attribute
    {
        return Attribute::get(function (): string
        {
            return $this->profile_photo_path = GetProfilePhotoUrlService::handle($this->profile_photo_path, $this->username, $this->first_name);
        });
    }
}
