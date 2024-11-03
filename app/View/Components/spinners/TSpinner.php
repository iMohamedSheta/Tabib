<?php

namespace App\View\Components\spinners;

use Closure;
use Illuminate\View\Component;

class TSpinner extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): string
    {
        return <<<'blade'
        <div style="position: absolute;top:50vh;left:45vw">
            <li class="fa fa-spinner fa-2x  fa-spin-pulse" wire:loading></li>
        </div>
        blade;
    }
}
