<?php

namespace App\Transformers;

use App\Services\Internal\User\GetProfilePhotoUrlService;
use App\Transformers\Base\Transformer;

class UserTransformer extends Transformer
{
    public function fullname(): static
    {
        if ($this->item) {
            $this->item->fullname = sprintf('%s %s', $this->item->first_name, $this->item->last_name);
        }

        return $this;
    }

    public function profile_photo_url(): static
    {
        if ($this->item) {
            $this->item->profile_photo_url = GetProfilePhotoUrlService::handle($this->item->profile_photo_path, $this->item->username, $this->item->first_name);
        }

        return $this;
    }
}
