<?php

use App\Livewire\App\Doctor\Includes\UpdateDoctorModal;
use App\Models\Clinic;
use App\Models\ClinicAdmin;
use App\Models\Doctor;
use Livewire\Livewire;

beforeEach(function (): void {
    $clinic = Clinic::factory()->create();

    $clinics = [$clinic->id => $clinic->name];

    $doctor = Doctor::factory()->create([
        'clinic_id' => $clinic->id,
    ]);

    $this->clinicId = $clinic->id;

    $this->clinicAdmin = ClinicAdmin::factory()->create(['clinic_id' => $this->clinicId]);
    $this->mountingData = ['clinics' => $clinics, 'doctor' => $doctor];

    $this->actingAs($this->clinicAdmin->user);
});

it('renders successfully', function (): void {
    Livewire::test(UpdateDoctorModal::class, $this->mountingData)
        ->assertStatus(200);
});
