<?php

namespace App\Traits\Helper;

trait isClassUseTrait
{
    private $traits;

    public function __construct()
    {
        $this->traits = class_uses($this);
    }

    public function isClassUseTrait($trait)
    {
        return in_array($trait, $this->traits);
    }
}
