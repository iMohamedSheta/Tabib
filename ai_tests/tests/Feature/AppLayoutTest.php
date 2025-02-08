<?php

use App\View\Components\AppLayout;
use Illuminate\Support\Facades\View;

it('renders the app layout view', function () {
    View::shouldReceive('make')
        ->once() // Expect the view to be rendered once
        ->with('layouts.app') // Expect the 'layouts.app' view to be rendered
        ->andReturn(Mockery::mock(Illuminate\Contracts\View\View::class)); // Return a mock view

    $component = new AppLayout();

    $component->render();
});
