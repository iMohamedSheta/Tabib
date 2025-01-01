<?php

namespace App\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class UsedIn
{
    public array $places;

    public function __construct(...$places)
    {
        $this->places = $places;
    }
}
