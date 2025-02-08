<?php

use App\Livewire\App\Doctor\Includes\CreateDoctorModal;
use App\Models\Clinic;
use App\Models\ClinicAdmin;
use App\Models\Doctor;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function (): void {
    $this->organization = Organization::factory()->create();

    // Create a ClinicAdmin user for the organization
    $this->user = User::factory()->create([
        'organization_id' => $this->organization->id,
        'role' => ClinicAdmin::class,
    ]);

    // Create a clinic for the organization
    $clinic = Clinic::factory()->create([
        'organization_id' => $this->organization->id,
    ]);

    $this->clinics = [$clinic->id => $clinic->name];
    $this->mountingData = ['clinics' => $this->clinics];

    $this->clinicId = $clinic->id;

    // Create a ClinicAdmin model linked to the created user
    $this->clinicAdmin = ClinicAdmin::factory()->create([
        'organization_id' => $this->organization->id,
        'user_id' => $this->user->id,
    ]);

    $this->actingAs($this->user);
});

it('renders successfully with localized content', function (): void {
    Livewire::test(CreateDoctorModal::class, $this->mountingData)
        ->assertSee('اضافة طبيب');
});

it('validates the input correctly', function (): void {
    Livewire::test(CreateDoctorModal::class, $this->mountingData)
        ->set('username', '')
        ->set('password', '')
        ->set('first_name', '')
        ->set('last_name', '')
        ->set('specialization', '')
        ->set('phone', '')
        ->set('clinic_ids', '')
        ->call('addDoctorAction')
        ->assertHasErrors(['username', 'password', 'first_name', 'last_name', 'specialization', 'phone']);
});

it('adds a doctor successfully', function (): void {
    Storage::fake('avatars');

    $file = UploadedFile::fake()->image('avatar.jpg');

    Livewire::test(CreateDoctorModal::class, $this->mountingData)
        ->set('username', 'johndoe')
        ->set('password', 'password123')
        ->set('specialization', 'Cardiology')
        ->set('clinic_ids', [$this->clinicId])
        ->set('first_name', 'John')
        ->set('last_name', 'Doe')
        ->set('phone', '01092322465')
        ->set('photo', $file)
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

    $this->assertEquals($this->organization->id, $doctor->organization_id);

    Storage::disk('avatars')->assertExists($user->photo);
});
