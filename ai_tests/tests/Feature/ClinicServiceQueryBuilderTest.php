<?php

use App\Models\ClinicService;
use App\Models\Event;
use App\Models\Organization;
use App\QueryBuilders\ClinicServiceQueryBuilder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function (): void {
    $this->organization = Organization::factory()->create();
    $this->clinicService = ClinicService::factory()->create(['organization_id' => $this->organization->id]);

    // Create some events associated with the clinic service.
    Event::factory(3)->create(['clinic_service_id' => $this->clinicService->id]);

    // Create an event for another clinic service to ensure the count is correct.
    $anotherClinicService = ClinicService::factory()->create(['organization_id' => $this->organization->id]);
    Event::factory()->create(['clinic_service_id' => $anotherClinicService->id]);

    $this->queryBuilder = new ClinicServiceQueryBuilder();
});

describe('ClinicServiceQueryBuilder', function (): void {
    it('can get clinic services for the same organization', function (): void {
        $anotherOrganization = Organization::factory()->create();
        ClinicService::factory()->create(['organization_id' => $anotherOrganization->id]);

        $results = $this->queryBuilder->getOrganizationClinicServices()->get();

        expect($results)->toHaveCount(2);
        expect($results->pluck('organization_id')->unique()->toArray())->toEqual([$this->organization->id]);
    });

    it('can get clinic services with patients count', function (): void {
        $results = $this->queryBuilder->withPatientsCount()->get();

        expect($results)->toHaveCount(2);

        $clinicService = $results->firstWhere('id', $this->clinicService->id);
        expect($clinicService->patients_count)->toBe(3);
    });
});
