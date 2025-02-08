<?php

use App\Enums\Media\MediaCollectionEnum;
use App\Enums\Media\MediaTypeEnum;
use App\Livewire\App\Patient\Includes\UploadAttachedFileModal;
use App\Models\Organization;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function (): void {
    Storage::fake('public');
    $this->organization = Organization::factory()->create();
    $this->user = User::factory()->create(['organization_id' => $this->organization->id]);
    $this->patient = Patient::factory()->create(['organization_id' => $this->organization->id, 'user_id' => $this->user->id]);
    $this->actingAs($this->user);
});

it('renders successfully', function (): void {
    Livewire::test(UploadAttachedFileModal::class, ['patient' => $this->patient])
        ->assertStatus(200);
});

it('allows authorized users to upload attached files', function (): void {
    Gate::define('create', function () {
        return true;
    });

    $file = UploadedFile::fake()->create('test.pdf', 500, 'application/pdf');

    Livewire::test(UploadAttachedFileModal::class, ['patient' => $this->patient])
        ->set('uploadedAttachedFile', $file)
        ->call('uploadAttachedFileAction')
        ->assertDispatched('uploaded-file', MediaTypeEnum::FILE);

    Storage::disk('public')->assertExists('media/' . $file->hashName());

    $this->assertDatabaseHas('media', [
        'model_type' => $this->patient->user::class,
        'model_id' => $this->patient->user->id,
        'collection_name' => MediaCollectionEnum::determineCollection($file->getMimeType())->value,
        'file_name' => $file->getClientOriginalName(),
    ]);
});

it('validates uploaded file', function (): void {
    Livewire::test(UploadAttachedFileModal::class, ['patient' => $this->patient])
        ->set('uploadedAttachedFile', null)
        ->call('uploadAttachedFileAction')
        ->assertHasErrors(['uploadedAttachedFile']);
});

it('disallows unauthorized users from uploading attached files', function (): void {
    Gate::define('create', function () {
        return false;
    });

    $file = UploadedFile::fake()->create('test.pdf', 500, 'application/pdf');

    Livewire::test(UploadAttachedFileModal::class, ['patient' => $this->patient])
        ->set('uploadedAttachedFile', $file)
        ->call('uploadAttachedFileAction')
        ->assertSee('غير مسموح لك باضافة الملف!');

    Storage::disk('public')->assertMissing('media/' . $file->hashName());

    $this->assertDatabaseMissing('media', [
        'model_type' => $this->patient->user::class,
        'model_id' => $this->patient->user->id,
        'file_name' => $file->getClientOriginalName(),
    ]);
});

it('handles exceptions during file upload', function (): void {
    Storage::fake('public');
    Gate::define('create', function () {
        return true;
    });

    $file = UploadedFile::fake()->create('test.pdf', 500, 'application/pdf');

    Storage::shouldReceive('disk')
        ->andThrow(new Exception('Simulated exception'));

    Livewire::test(UploadAttachedFileModal::class, ['patient' => $this->patient])
        ->set('uploadedAttachedFile', $file)
        ->call('uploadAttachedFileAction')
        ->assertSee(__('alerts.error'));
});
