<?php

use Illuminate\Support\Facades\Blade;

it('renders the spinner component', function () {
    $view = Blade::render('<x-spinners.t-spinner />');

    expect($view)->toContain('<div style="position: absolute;top:50vh;left:45vw">')
                  ->toContain('<li class="fa fa-spinner fa-2x  fa-spin-pulse" wire:loading></li>')
                  ->toContain('</div>');
});
