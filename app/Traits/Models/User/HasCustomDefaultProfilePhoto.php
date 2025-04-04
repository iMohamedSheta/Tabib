<?php

namespace App\Traits\Models\User;

use App\Services\Internal\User\GetProfilePhotoUrlService;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasCustomDefaultProfilePhoto
{
    public function profilePhotoUrl(): Attribute
    {
        return Attribute::get(fn (): string => $this->profile_photo_path = GetProfilePhotoUrlService::handle($this->profile_photo_path, $this->username, $this->first_name));
    }
}
