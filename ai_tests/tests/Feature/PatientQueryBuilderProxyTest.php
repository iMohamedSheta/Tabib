<?php

use App\Models\Organization;
use App\Models\Patient;
use App\Proxy\QueryBuilders\PatientQueryBuilderProxy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);


beforeEach(function (): void {
    $this->organization = Organization::factory()->create();
    Patient::factory(20)->create(['organization_id' => $this->organization->id]);
    $this->actingAs($this->organization->owner);
});


describe('searchPatients', function () {
    it('returns a collection of patients matching the search term', function () {
        $searchTerm = Patient::first()->first_name;
        $results = PatientQueryBuilderProxy::searchPatients($searchTerm);
        expect($results)->toBeInstanceOf(Illuminate\Support\Collection::class);
        expect($results)->each(fn ($patient) => expect($patient->first_name)->toContain($searchTerm));
    });

    it('returns an empty collection if no patients match the search term', function () {
        $results = PatientQueryBuilderProxy::searchPatients('nonexistentname');
        expect($results)->toBeInstanceOf(Illuminate\Support\Collection::class);
        expect($results)->toBeEmpty();
    });

    it('limits the results to a maximum of 5 patients', function () {
        $searchTerm = substr(Patient::first()->first_name, 0, 2);
        $results = PatientQueryBuilderProxy::searchPatients($searchTerm);
        expect($results->count())->toBeLessThanOrEqual(5);
    });
});


describe('getPatientsForTable', function () {
    it('returns a paginated list of patients for the organization', function () {
        $perPage = 10;
        $page = 1;
        $results = PatientQueryBuilderProxy::getPatientsForTable($perPage, $page);
        expect($results)->toBeInstanceOf(Illuminate\Contracts\Pagination\LengthAwarePaginator::class);
        expect($results->perPage())->toBe($perPage);
        expect($results->currentPage())->toBe($page);
        expect($results->total())->toBe(20);
    });

    it('returns a paginated list of patients matching the search term', function () {
        $searchTerm = Patient::first()->first_name;
        $perPage = 10;
        $page = 1;

        $results = PatientQueryBuilderProxy::getPatientsForTable($perPage, $page, $searchTerm);

        expect($results)->toBeInstanceOf(Illuminate\Contracts\Pagination\LengthAwarePaginator::class);
        expect($results->perPage())->toBe($perPage);
        expect($results->currentPage())->toBe($page);
        expect($results->items())->each(fn ($patient) => expect($patient->first_name)->toContain($searchTerm));
    });

    it('returns an empty paginated list if no patients match the search term', function () {
        $searchTerm = 'nonexistentname';
        $perPage = 10;
        $page = 1;
        $results = PatientQueryBuilderProxy::getPatientsForTable($perPage, $page, $searchTerm);
        expect($results)->toBeInstanceOf(Illuminate\Contracts\Pagination\LengthAwarePaginator::class);
        expect($results->items())->toBeEmpty();
    });
});
