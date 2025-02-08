<?php

use App\Models\Clinic;
use App\Models\ClinicService;
use App\Models\Doctor;
use App\Models\Event;
use App\Models\Organization;
use App\Models\Patient;
use App\Models\User;

use function Pest\Laravel\actingAs;

uses()->group('event');

beforeEach(function (): void {
    $this->organization = Organization::factory()->create();

    // Create a ClinicAdmin user for the organization
    $this->user = User::factory()->create([
        'organization_id' => $this->organization->id,
    ]);

    actingAs($this->user);

    $this->clinic = Clinic::factory()->create(['organization_id' => $this->organization->id]);
    $this->clinicService = ClinicService::factory()->create(['clinic_id' => $this->clinic->id]);
    $this->doctor = Doctor::factory()->create(['organization_id' => $this->organization->id]);
    $this->patient = Patient::factory()->create(['organization_id' => $this->organization->id]);

});

describe('Event Model', function () {
    it('can create an event', function () {
        $event = Event::create([
            'clinic_service_id' => $this->clinicService->id,
            'doctor_id' => $this->doctor->id,
            'patient_id' => $this->patient->id,
            'clinic_id' => $this->clinic->id,
            'data' => json_encode(['test' => 'data']),
            'organization_id' => $this->organization->id,
        ]);

        expect($event)->toBeInstanceOf(Event::class);
        expect($event->clinicService)->toBeInstanceOf(ClinicService::class);
        expect($event->doctor)->toBeInstanceOf(Doctor::class);
        expect($event->patient)->toBeInstanceOf(Patient::class);
        expect($event->clinic)->toBeInstanceOf(Clinic::class);
        expect($event->decoded_data)->toBeObject();
        expect($event->decoded_data->test)->toBe('data');

        $this->assertDatabaseHas('events', [
            'clinic_service_id' => $this->clinicService->id,
            'doctor_id' => $this->doctor->id,
            'patient_id' => $this->patient->id,
            'clinic_id' => $this->clinic->id,
            'data' => json_encode(['test' => 'data']),
            'organization_id' => $this->organization->id,
        ]);
    });

    it('has correct relations', function () {
        $event = Event::factory()->create([
            'clinic_service_id' => $this->clinicService->id,
            'doctor_id' => $this->doctor->id,
            'patient_id' => $this->patient->id,
            'clinic_id' => $this->clinic->id,
            'data' => json_encode(['test' => 'data']),
            'organization_id' => $this->organization->id,
        ]);

        expect($event->clinicService)->toBeInstanceOf(ClinicService::class);
        expect($event->doctor)->toBeInstanceOf(Doctor::class);
        expect($event->patient)->toBeInstanceOf(Patient::class);
        expect($event->clinic)->toBeInstanceOf(Clinic::class);
    });

    it('can decode data attribute to object', function () {
        $event = Event::factory()->create(['data' => json_encode(['key' => 'value']), 'organization_id' => $this->organization->id]);

        expect($event->getDecodedDataAttribute())->toBeObject();
        expect($event->getDecodedDataAttribute()->key)->toBe('value');
    });

    it('returns null when data attribute is not valid json', function () {
        $event = Event::factory()->create(['data' => 'invalid json', 'organization_id' => $this->organization->id]);

        expect($event->getDecodedDataAttribute())->toBeNull();
    });
});
