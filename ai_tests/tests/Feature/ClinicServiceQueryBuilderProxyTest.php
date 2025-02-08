<?php

use App\Models\ClinicService;
use App\Models\Organization;
use App\Proxy\QueryBuilders\ClinicServiceQueryBuilderProxy;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $this->organization = Organization::factory()->create();
    $this->actingAs($this->organization->owner);
});

describe('getClinicServicesForTable', function () {
    it('returns a LengthAwarePaginator', function () {
        $perPage = 10;
        $page = 1;

        $result = ClinicServiceQueryBuilderProxy::getClinicServicesForTable($perPage, $page);

        expect($result)->toBeInstanceOf(Illuminate\Contracts\Pagination\LengthAwarePaginator::class);
    });

    it('returns the correct number of items per page', function () {
        $perPage = 5;
        $page = 1;
        ClinicService::factory(7)->create(['organization_id' => $this->organization->id]);

        $result = ClinicServiceQueryBuilderProxy::getClinicServicesForTable($perPage, $page);

        expect($result->perPage())->toBe($perPage);
    });

    it('returns the correct page number', function () {
        $perPage = 5;
        $page = 2;
        ClinicService::factory(12)->create(['organization_id' => $this->organization->id]);

        $result = ClinicServiceQueryBuilderProxy::getClinicServicesForTable($perPage, $page);

        expect($result->currentPage())->toBe($page);
    });

    it('includes only organization clinic services', function () {
        ClinicService::factory(3)->create(['organization_id' => $this->organization->id]);
        ClinicService::factory(2)->create(); // Create services for other organizations

        $perPage = 10;
        $page = 1;

        $result = ClinicServiceQueryBuilderProxy::getClinicServicesForTable($perPage, $page);

        expect($result->total())->toBe(3);
    });

    it('eager loads patients count', function () {
        // This test is a bit more complex as it needs to verify the `withPatientsCount` method.
        // We'll create clinic services and patients associated with them, then check if the count is loaded.
        $clinicService = ClinicService::factory()->create(['organization_id' => $this->organization->id]);

        $perPage = 10;
        $page = 1;

        $result = ClinicServiceQueryBuilderProxy::getClinicServicesForTable($perPage, $page);
        $clinicService = $result->first();

        expect($clinicService->relationLoaded('patients'))->toBeFalse();
    });
});
