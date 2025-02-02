<?php

declare(strict_types=1);

namespace App\Transformers;

use App\Services\Internal\User\GetProfilePhotoUrlService;
use App\Transformers\Base\Transformer;

class UserTransformer extends Transformer
{
    public function fullname(): self
    {
        if ($this->item) {
            $this->item->fullname = sprintf('%s %s', $this->item->first_name, $this->item->last_name);
        }

        return $this;
    }

    public function profilePhotoUrl(): self
    {
        if ($this->item) {
            $this->item->profile_photo_url = GetProfilePhotoUrlService::handle(
                $this->item->profile_photo_path,
                $this->item->username,
                $this->item->first_name
            );
        }

        return $this;
    }
}
