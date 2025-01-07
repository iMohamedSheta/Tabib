<?php

namespace App\Traits\LivewireTraits;

trait ActionResponseHandlerTrait
{
    abstract public function matchStatus($actionResponseStatus = null): string;
}
