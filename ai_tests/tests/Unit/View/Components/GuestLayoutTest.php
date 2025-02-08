<?php

use App\View\Components\GuestLayout;
use Illuminate\View\View;

it('can render the guest layout view', function () {
    $guestLayout = new GuestLayout();

    expect($guestLayout->render())
        ->toBeInstanceOf(View::class)
        ->toHaveName('layouts.guest');
});
