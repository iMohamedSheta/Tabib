<?php

namespace App\Traits\LivewireTraits;

use App\Services\Internal\User\GetProfilePhotoUrlService;
use Livewire\Attributes\Computed;

trait WithProfilePhotoTrait
{
    #[Computed(true)]
    public function getUserProfilePhotoUrl(?string $profilePhotoPath, ?string $username, ?string $firstName): string
    {
        return GetProfilePhotoUrlService::handle($profilePhotoPath, $username, $firstName);
    }
}
