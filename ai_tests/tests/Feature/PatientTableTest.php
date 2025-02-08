<?php

use App\Actions\Patient\DeletePatientAction;
use App\Livewire\App\Patient\PatientTable;
use App\Models\Clinic;
use App\Models\Organization;
use App\Models\Patient;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

beforeEach(function (): void {
    $this->organization = Organization::factory()->create();

    $this->user = User::factory()->create([
        'organization_id' => $this->organization->id,
    ]);

    actingAs($this->user);

    $this->clinic = Clinic::factory()->create([
        'organization_id' => $this->organization->id,
    ]);

    $this->patient = Patient::factory()->create([
        'organization_id' => $this->organization->id,
        'clinic_id' => $this->clinic->id,
    ]);
});

it('renders successfully', function (): void {
    Livewire::test(PatientTable::class)
        ->assertOk();
});

it('can get patients for table', function (): void {
    $patients = Patient::factory(3)->create(['organization_id' => $this->organization->id, 'clinic_id' => $this->clinic->id]);

    $component = Livewire::test(PatientTable::class)
        ->set('search', '');

    $patientsData = $component->instance()->getPatients();

    expect($patientsData->total())->toBeGreaterThanOrEqual(1);
});

it('can get clinics', function (): void {
    $component = Livewire::test(PatientTable::class);
    $clinics = $component->instance()->getClinics();

    expect($clinics)->toBeArray();
    expect($clinics)->toHaveKey($this->clinic->id);
    expect($clinics[$this->clinic->id])->toBe($this->clinic->name);
});

it('can delete a patient successfully', function (): void {
    $patient = Patient::factory()->create(['organization_id' => $this->organization->id, 'clinic_id' => $this->clinic->id]);

    Livewire::test(PatientTable::class)
        ->call('deletePatientAction', $patient->id)
        ->assertDispatched('deleted');

    $this->assertDatabaseMissing('patients', ['id' => $patient->id]);
});

it('displays error message when deleting a patient fails', function (): void {
    $patient = Patient::factory()->create(['organization_id' => $this->organization->id, 'clinic_id' => $this->clinic->id]);

    $action = Mockery::mock(DeletePatientAction::class);
    $action->shouldReceive('handle')->once()->andThrow(new Exception('Failed to delete patient'));

    $this->app->bind(DeletePatientAction::class, function () use ($action) {
        return $action;
    });

    Livewire::test(PatientTable::class)
        ->call('deletePatientAction', $patient->id);

    $this->assertDatabaseHas('patients', ['id' => $patient->id]);
});
