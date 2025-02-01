<?php

use App\Livewire\App\Patient\PatientTable;
use App\Models\Clinic;
use App\Models\ClinicAdmin;
use App\Models\Organization;
use App\Models\Patient;
use App\Models\User;
use Livewire\Livewire;

describe('PatientTable [Livewire-Component]', function () {

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

		$this->clinicId = $clinic->id;

		// Create a patient for the organization
		$this->patientUser = User::factory()->create([
			'organization_id' => $this->organization->id,
		]);

		$this->patient = Patient::factory()->create([
			'organization_id' => $this->organization->id,
			'user_id' => $this->patientUser->id,
		]);

		// Create a ClinicAdmin model linked to the created user
		$this->clinicAdmin = ClinicAdmin::factory()->create([
			'organization_id' => $this->organization->id,
			'user_id' => $this->user->id,
		]);

		$this->actingAs($this->user);
	});

	it('renders successfully', function (): void {
		Livewire::test(PatientTable::class)
			->assertStatus(200);
	});

	it('can delete a patient', function (): void {
		Livewire::test(PatientTable::class)
			->call('deletePatientAction', $this->patient->id)
			->assertHasNoErrors()
			->assertDispatched('deleted');

		$this->assertDatabaseMissing('users', ['id' => $this->patient->user_id]);
		$this->assertDatabaseMissing('patients', ['id' => $this->patient->id]);
	});
});
