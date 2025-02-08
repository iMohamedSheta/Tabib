<?php

use App\Livewire\App\ClinicService\Includes\InfoClinicServiceModal;
use Livewire\Livewire;


beforeEach(function (): void {
    $this->clinicServiceData = [
        'id' => 1,
        'name' => 'Test Service',
        'description' => 'Test Description',
        'price' => 100,
        'duration' => 60,
    ];
});

it('renders successfully', function (): void {
    Livewire::test(InfoClinicServiceModal::class, ['clinicService' => $this->clinicServiceData])
        ->assertStatus(200);
});

it('passes the clinic service data to the view', function (): void {
    Livewire::test(InfoClinicServiceModal::class, ['clinicService' => $this->clinicServiceData])
        ->assertSet('clinicService', $this->clinicServiceData);
});

