<?php

use App\Livewire\App\Calendar\Includes\UpdateEventModal;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->mountingData = [];
});

it('mounts with the first clinic selected', function (): void {
    Livewire::test(UpdateEventModal::class, $this->mountingData)
        ->assertStatus(200);
});
