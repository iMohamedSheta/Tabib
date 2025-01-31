<?php

use App\Livewire\App\ClinicService\Includes\InfoClinicServiceModal;
use App\Models\ClinicService;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->clinicService = ClinicService::factory()->create();
});

it('renders successfully', function (): void {
    Livewire::test(InfoClinicServiceModal::class, ['clinicService' => $this->clinicService])
    ->assertStatus(200);
});

it('displays clinic service information', function (): void {
    Livewire::test(InfoClinicServiceModal::class, ['clinicService' => $this->clinicService])
    ->assertSee($this->clinicService->name)
    ->assertSee($this->clinicService->description);
});
