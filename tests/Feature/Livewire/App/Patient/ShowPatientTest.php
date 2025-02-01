<?php

use App\Livewire\App\Patient\ShowPatient;
use App\Models\Clinic;
use App\Models\ClinicAdmin;
use App\Models\Organization;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;

use function Pest\Laravel\assertDatabaseHas;

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
		'clinic_id' => $this->clinicId
	]);

	$this->actingAs($this->user);

	$file = UploadedFile::fake()->create('test.pdf', 100, 'application/pdf');

	$this->media = $this->patient->user->addMedia($file->getRealPath())
		->toMediaCollection('files');

	// Create a ClinicAdmin model linked to the created user
	$this->clinicAdmin = ClinicAdmin::factory()->create([
		'organization_id' => $this->organization->id,
		'user_id' => $this->user->id,
	]);
});

it('renders successfully', function (): void {
	Livewire::test(ShowPatient::class, ['patient' => $this->patient])
		->assertStatus(200);
});

it('can delete a media file', function (): void {
	assertDatabaseHas('media', [
		'id' => $this->media->id,
	]);

	Livewire::test(ShowPatient::class, ['patient' => $this->patient])
		->call('deleteMediaAction', $this->media->id)
		->assertDispatched('deleted');

	$this->assertDatabaseMissing('media', ['id' => $this->media->id]);
});
