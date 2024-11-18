<?php
namespace App\Transformers;

use App\Services\User\GetProfilePhotoUrlService;
use App\Transformers\Base\Transformer;

class UserTransformer extends Transformer
{
    public function fullname()
    {
        if ($this->item){

            $this->item->fullname = "{$this->item->first_name} {$this->item->last_name}";
        }
        return $this;
    }

    public function profile_photo_url()
    {
        if ($this->item) {

            $this->item->profile_photo_url = GetProfilePhotoUrlService::handle($this->item->profile_photo_path, $this->item->username, $this->item->first_name);
        }
        return $this;
    }
}
