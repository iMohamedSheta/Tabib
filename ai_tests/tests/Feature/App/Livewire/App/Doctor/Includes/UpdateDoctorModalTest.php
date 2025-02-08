<?php

use App\Livewire\App\Doctor\Includes\UpdateDoctorModal;
use App\Models\Clinic;
use App\Models\ClinicAdmin;
use App\Models\Doctor;
use App\Models\Organization;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

beforeEach(function (): void {
    $this->organization = Organization::factory()->create();

    $this->user = User::factory()->create([
        'organization_id' => $this->organization->id,
        'role' => ClinicAdmin::class,
    ]);

    $clinic = Clinic::factory()->create([
        'organization_id' => $this->organization->id,
    ]);

    $this->clinics = [$clinic->id => $clinic->name];

    $this->clinicId = $clinic->id;

    $this->clinicAdmin = ClinicAdmin::factory()->create([
        'organization_id' => $this->organization->id,
        'user_id' => $this->user->id,
    ]);

    actingAs($this->user);

    $this->doctorUser = User::factory()->create(['organization_id' => $this->organization->id, 'role' => Doctor::class]);
    $this->doctor = Doctor::factory()->create(['organization_id' => $this->organization->id, 'user_id' => $this->doctorUser->id]);

    $this->mountingData = [
        'doctor' => $this->doctor,
        'clinics' => $this->clinics,
    ];
});

it('renders successfully', function (): void {
    Livewire::test(UpdateDoctorModal::class, $this->mountingData)
        ->assertOk();
});

it('mounts data correctly', function (): void {
    Livewire::test(UpdateDoctorModal::class, $this->mountingData)
        ->assertSet('clinics', $this->clinics)
        ->assertSet('username', $this->doctor->username)
        ->assertSet('first_name', $this->doctor->first_name)
        ->assertSet('last_name', $this->doctor->last_name)
        ->assertSet('specialization', $this->doctor->specialization)
        ->assertSet('organization_id', $this->doctor->organization_id)
        ->assertSet('phone', $this->doctor->phone)
        ->assertSet('other_phone', $this->doctor->other_phone);
});

it('updates a doctor successfully', function (): void {
    Livewire::test(UpdateDoctorModal::class, $this->mountingData)
        ->set('username', 'newusername')
        ->set('first_name', 'newfirstname')
        ->set('last_name', 'newlastname')
        ->set('specialization', 'newspecialization')
        ->set('phone', '1234567890')
        ->call('updateDoctorAction')
        ->assertDispatched('updated');

    $this->assertDatabaseHas('users', [
        'id' => $this->doctor->user_id,
        'username' => 'newusername',
        'first_name' => 'newfirstname',
        'last_name' => 'newlastname',
        'phone' => '1234567890',
    ]);

    $this->assertDatabaseHas('doctors', [
        'id' => $this->doctor->id,
        'specialization' => 'newspecialization',
    ]);
});

it('shows error message on failure', function (): void {
    $user = User::factory()->create(['organization_id' => $this->organization->id, 'role' => ClinicAdmin::class]);
    actingAs($user);

    Livewire::test(UpdateDoctorModal::class, $this->mountingData)
        ->set('username', 'newusername')
        ->set('first_name', 'newfirstname')
        ->set('last_name', 'newlastname')
        ->set('specialization', 'newspecialization')
        ->set('phone', '1234567890')
        ->call('updateDoctorAction');
});

it('validates the input correctly', function (): void {
    Livewire::test(UpdateDoctorModal::class, $this->mountingData)
        ->set('username', '')
        ->set('first_name', '')
        ->set('last_name', '')
        ->set('specialization', '')
        ->set('phone', '')
        ->call('updateDoctorAction')
        ->assertHasErrors(['username', 'first_name', 'last_name', 'specialization', 'phone']);
});
