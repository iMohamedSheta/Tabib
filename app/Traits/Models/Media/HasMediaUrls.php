<?php

namespace App\Traits\Models\Media;

use App\Services\Internal\Media\MediaUrlGeneratorService;

trait HasMediaUrls
{
    public function getUrlAttribute(): string
    {
        return (new MediaUrlGeneratorService())->handle($this->id);
    }
}
