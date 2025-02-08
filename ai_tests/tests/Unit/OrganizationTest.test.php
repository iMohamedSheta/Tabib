<?php

use App\Models\Clinic;
use App\Models\ClinicAdmin;
use App\Models\ClinicService;
use App\Models\Organization;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('Organization Model', function () {
    it('has many clinics', function () {
        $organization = Organization::factory()->create();
        $clinics = Clinic::factory()->count(3)->create(['organization_id' => $organization->id]);

        expect($organization->clinics)->toHaveCount(3);
        expect($organization->clinics->first())->toBeInstanceOf(Clinic::class);
        expect($organization->clinics->first()->organization_id)->toBe($organization->id);
    });

    it('has many clinic services', function () {
        $organization = Organization::factory()->create();
        $clinicServices = ClinicService::factory()->count(2)->create(['organization_id' => $organization->id]);

        expect($organization->clinicServices)->toHaveCount(2);
        expect($organization->clinicServices->first())->toBeInstanceOf(ClinicService::class);
        expect($organization->clinicServices->first()->organization_id)->toBe($organization->id);
    });

    it('has many clinic admins', function () {
        $organization = Organization::factory()->create();
        $clinicAdmins = ClinicAdmin::factory()->count(4)->create(['organization_id' => $organization->id]);

        expect($organization->clinicAdmins)->toHaveCount(4);
        expect($organization->clinicAdmins->first())->toBeInstanceOf(ClinicAdmin::class);
        expect($organization->clinicAdmins->first()->organization_id)->toBe($organization->id);
    });

    it('has many users', function () {
        $organization = Organization::factory()->create();
        $users = User::factory()->count(5)->create(['organization_id' => $organization->id]);

        expect($organization->users)->toHaveCount(5);
        expect($organization->users->first())->toBeInstanceOf(User::class);
        expect($organization->users->first()->organization_id)->toBe($organization->id);
    });

    it('has many patients', function () {
        $organization = Organization::factory()->create();
        $patients = Patient::factory()->count(6)->create(['organization_id' => $organization->id]);

        expect($organization->patients)->toHaveCount(6);
        expect($organization->patients->first())->toBeInstanceOf(Patient::class);
        expect($organization->patients->first()->organization_id)->toBe($organization->id);
    });
});
