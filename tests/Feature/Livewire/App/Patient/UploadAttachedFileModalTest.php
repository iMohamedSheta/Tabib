<?php

use App\Enums\Media\MediaTypeEnum;
use App\Livewire\App\Patient\Includes\UploadAttachedFileModal;
use App\Models\ClinicAdmin;
use App\Models\Organization;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;

beforeEach(function (): void {
	$this->organization = Organization::factory()->create();

	// Create a ClinicAdmin user for the organization
	$this->user = User::factory()->create([
		'organization_id' => $this->organization->id,
		'role' => ClinicAdmin::class,
	]);

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
	Livewire::test(UploadAttachedFileModal::class, ['patient' => $this->patient])
		->assertStatus(200);
});

it('validates the uploaded file', function (): void {
	Livewire::test(UploadAttachedFileModal::class, ['patient' => $this->patient])
		->set('uploadedAttachedFile', '')
		->call('uploadAttachedFileAction')
		->assertHasErrors(['uploadedAttachedFile']);
});

it('uploads a file successfully', function (): void {
	$file = UploadedFile::fake()->createWithContent('test.txt', 'Dummy text content')->mimeType('text/plain');

	Livewire::test(UploadAttachedFileModal::class, ['patient' => $this->patient])
		->set('uploadedAttachedFile', $file)
		->call('uploadAttachedFileAction')
		->assertHasNoErrors()
		->assertDispatched('uploaded-file');

	expect($this->patient->user->media()->count())->toBe(1);

	$media = $this->patient->user->media()->first();

	expect($media->media_type)->toBe(MediaTypeEnum::FILE->value);
	expect($media->mime_type)->toBe('text/plain');
});
