<?php

use App\Livewire\App\Doctor\Includes\CreateDoctorModal;
use App\Models\Clinic;
use App\Models\ClinicAdmin;
use App\Models\User;
use App\Models\Doctor;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create(['role' => ClinicAdmin::class]);

    $clinic = Clinic::factory()->create();
    $this->clinics = [$clinic->id => $clinic->name];
    $this->mountingData = ['clinics' => $this->clinics];
    $this->clinicId = $clinic->id;
    $this->clinicAdmin = ClinicAdmin::factory()->create(['clinic_id' => $this->clinicId, 'user_id' => $this->user->id]);
    $this->actingAs($this->clinicAdmin->user);
});

it('mounts with the first clinic selected', function () {
    Livewire::test(CreateDoctorModal::class, $this->mountingData)
        ->assertSet('clinic_id', $this->clinicId);
});

it('renders successfully with localized content', function () {
    Livewire::test(CreateDoctorModal::class, $this->mountingData)
        ->assertSee('اضافة طبيب')
        ->assertSet('clinic_id', $this->clinicId);
});

it('validates the input correctly', function () {

    Livewire::test(CreateDoctorModal::class, $this->mountingData)
        ->set('username', '')
        ->set('password', '')
        ->set('first_name', '')
        ->set('last_name', '')
        ->set('specialization', '')
        ->set('phone', '')
        ->set('clinic_id', '')
        ->call('addDoctorAction')
        ->assertHasErrors(['username', 'password', 'first_name', 'last_name', 'specialization', 'phone', 'clinic_id']);

    });

it('adds a doctor successfully', function ()
{
    Livewire::test(CreateDoctorModal::class, $this->mountingData)
        ->set('username', 'johndoe')
        ->set('password', 'password123')
        ->set('specialization', 'Cardiology')
        ->set('clinic_id', $this->clinicId)
        ->set('first_name', 'John')
        ->set('last_name', 'Doe')
        ->set('phone', '01092322465')
        ->call('addDoctorAction')
        ->assertHasNoErrors()
        ->assertDispatched('added');

    $this->assertDatabaseHas('users', [
        'username' => 'johndoe',
        'first_name' => 'John',
        'last_name' => 'Doe',
        'phone' => '01092322465',
        'role' => Doctor::class,
    ]);

    $user = User::where('username', 'johndoe')->first();
    $this->assertNotNull($user, 'User should exist in the database.');

    $doctor = Doctor::where('user_id', $user->id)->first();
    $this->assertNotNull($doctor, 'Doctor should exist in the database.');

    $this->assertEquals($this->clinicId, $doctor->clinic_id);
});
