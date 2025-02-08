<?php

use App\Models\ClinicService;
use App\Models\Organization;

uses(Tests\TestCase::class);


describe('ClinicService', function () {
    it('can create a clinic service', function () {
        $clinicService = ClinicService::factory()->create();

        expect($clinicService)->toBeInstanceOf(ClinicService::class);
        $this->assertDatabaseHas('clinic_services', ['id' => $clinicService->id]);
    });

    describe('list', function () {
        it('returns an array of clinic services with id as key and name as value', function () {
            $organization = Organization::factory()->create();
            $clinicService1 = ClinicService::factory()->create(['organization_id' => $organization->id, 'name' => 'Service 1']);
            $clinicService2 = ClinicService::factory()->create(['organization_id' => $organization->id, 'name' => 'Service 2']);

            $expected = [
                $clinicService1->id => $clinicService1->name,
                $clinicService2->id => $clinicService2->name,
            ];

            $actual = ClinicService::list();

            expect($actual)->toBeArray();
            expect($actual)->toEqual($expected);
        });

        it('returns an empty array when no clinic services exist', function () {
            $actual = ClinicService::list();

            expect($actual)->toBeArray();
            expect($actual)->toBeEmpty();
        });
    });
});
