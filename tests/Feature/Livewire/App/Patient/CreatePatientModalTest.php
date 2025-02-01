<?php

use App\Livewire\App\Patient\Includes\CreatePatientModal;
use App\Models\Clinic;
use App\Models\ClinicAdmin;
use App\Models\Organization;
use App\Models\Patient;
use App\Models\User;
use Livewire\Livewire;

describe('CreatePatientModal [Livewire-Component]', function () {
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
		Livewire::test(CreatePatientModal::class, $this->mountingData)
			->assertStatus(200);
	});

	it('validates the input correctly', function (): void {
		Livewire::test(CreatePatientModal::class, $this->mountingData)
			->set('first_name', '')
			->set('last_name', '')
			->set('age', '')
			->set('phone', '')
			->set('gender', '')
			->call('addPatientAction')
			->assertHasErrors(['first_name', 'last_name', 'age', 'phone', 'gender']);
	});

	it('adds a patient successfully', function (): void {
		Livewire::test(CreatePatientModal::class, $this->mountingData)
			->set('first_name', 'John')
			->set('last_name', 'Doe')
			->set('age', 30)
			->set('phone', '01092322465')
			->set('gender', 'male')
			->set('clinic_id', $this->clinicId)
			->call('addPatientAction')
			->assertHasNoErrors()
			->assertDispatched('added');

		$this->assertDatabaseHas('users', [
			'first_name' => 'John',
			'last_name' => 'Doe',
			'phone' => '01092322465',
			'role' => Patient::class,
		]);

		$user = User::where('first_name', 'John')->first();
		$this->assertNotNull($user, 'User should exist in the database.');

		$patient = Patient::where('user_id', $user->id)->first();
		$this->assertNotNull($patient, 'Patient should exist in the database.');
		$this->assertEquals($this->organization->id, $patient->organization_id);
	});
});
