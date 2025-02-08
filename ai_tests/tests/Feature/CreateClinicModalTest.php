<?php

use App\Livewire\App\Clinic\Includes\CreateClinicModal;
use Livewire\Livewire;


it('renders successfully', function () {
    Livewire::test(CreateClinicModal::class)
        ->assertStatus(200);
});

it('should call addClinicAction and return addClinic string', function () {
    $component = Livewire::test(CreateClinicModal::class);

    $result = $component->call('addClinicAction');

    expect($result)->toBe('addClinic');
});