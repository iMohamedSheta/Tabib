<?php

namespace App\Traits\LivewireTraits;

use App\Services\Internal\User\GetProfilePhotoUrlService;
use Livewire\Attributes\Computed;

trait withProfilePhotoTrait
{
    #[Computed]
    public function getUserProfilePhotoUrl($profile_photo_path, $username, $first_name)
    {
        return GetProfilePhotoUrlService::handle($profile_photo_path, $username, $first_name);
    }
}
