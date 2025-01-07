<?php

use App\Livewire\App\Doctor\Includes\UpdateDoctorModal;
use App\Models\Clinic;
use App\Models\ClinicAdmin;
use App\Models\Doctor;
use App\Models\Organization;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->organization = Organization::factory()->create();

    // Create a ClinicAdmin user for the organization
    $this->user = User::factory()->create([
        'organization_id' => $this->organization->id,
        'role' => ClinicAdmin::class,
    ]);

    // Create a clinic for the organization
    $this->clinic = Clinic::factory()->create([
        'organization_id' => $this->organization->id,
    ]);

    // Create a Doctor model linked to the created user
    $this->doctor = Doctor::factory()->create([
        'organization_id' => $this->organization->id,
        'user_id' => $this->user->id,
    ]);

    $this->clinics = [$this->clinic->id => $this->clinic->name];

    $this->clinicId = $this->clinic->id;

    $this->mountingData = ['doctor' => $this->doctor, 'clinics' => $this->clinics];

    $this->actingAs($this->user);
});

it('renders successfully', function (): void {
    Livewire::test(UpdateDoctorModal::class, $this->mountingData)
        ->assertStatus(200);
});
