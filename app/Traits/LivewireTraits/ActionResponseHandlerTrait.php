<?php

namespace App\Traits\LivewireTraits;

use App\Collections\ActionResponseCollection;
use App\Enums\ActionResponseEnum;

trait ActionResponseHandlerTrait
{
   abstract public function matchStatus($actionResponseStatus = null): string;
}
