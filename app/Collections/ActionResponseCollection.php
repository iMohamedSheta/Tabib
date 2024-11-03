<?php

namespace App\Collections;

use Illuminate\Support\Collection;
class ActionResponseCollection extends Collection
{
    // Override the method to make data accessible as properties
    public function __get($key)
    {
        return $this->get($key);
    }
}
