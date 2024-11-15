<?php

use App\Livewire\App\Calendar\Includes\UpdateEventModal;
use Livewire\Livewire;


beforeEach(function () {

    $this->mountingData = [];

});

it('mounts with the first clinic selected', function () {
    Livewire::test(UpdateEventModal::class, $this->mountingData)
        ->assertStatus(200);
});
