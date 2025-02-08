<?php

use App\Models\Organization;
use App\Services\Internal\Organization\OrganizationSetupService;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;

beforeEach(function (): void {
    $this->organization = Organization::factory()->create();
});

describe('OrganizationSetupService', function () {
    it('can setup an organization with default clinic services', function () {
        OrganizationSetupService::setup($this->organization);

        assertDatabaseCount('clinic_services', 3);

        assertDatabaseHas('clinic_services', [
            'name' => 'كشف',
            'price' => 250,
            'color' => '#f56565',
            'organization_id' => $this->organization->id,
        ]);

        assertDatabaseHas('clinic_services', [
            'name' => 'اعادة كشف',
            'price' => 250,
            'color' => '#009688',
            'organization_id' => $this->organization->id,
        ]);

        assertDatabaseHas('clinic_services', [
            'name' => 'متابعة عملية',
            'price' => 200,
            'color' => '#5A67D8',
            'organization_id' => $this->organization->id,
        ]);
    });
});
