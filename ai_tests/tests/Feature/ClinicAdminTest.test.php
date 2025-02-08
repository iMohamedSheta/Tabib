<?php

use App\Models\Clinic;
use App\Models\ClinicAdmin;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function (): void {
    $this->organization = Organization::factory()->create();
    $this->user = User::factory()->create(['organization_id' => $this->organization->id]);
    $this->clinicAdmin = ClinicAdmin::factory()->create(['user_id' => $this->user->id, 'organization_id' => $this->organization->id]);
});

describe('ClinicAdmin Model', function () {
    it('can create a clinic admin', function () {
        $clinicAdmin = ClinicAdmin::factory()->create();
        expect($clinicAdmin)->toBeInstanceOf(ClinicAdmin::class);
    });

    it('belongs to a user', function () {
        $user = User::factory()->create(['organization_id' => $this->organization->id]);
        $clinicAdmin = ClinicAdmin::factory()->create(['user_id' => $user->id, 'organization_id' => $this->organization->id]);

        expect($clinicAdmin->user)->toBeInstanceOf(User::class);
        expect($clinicAdmin->user->id)->toBe($user->id);
    });

    it('can have a clinic', function () {
        $clinic = Clinic::factory()->create(['organization_id' => $this->organization->id]);
        $clinicAdmin = ClinicAdmin::factory()->create(['clinic_id' => $clinic->id, 'user_id' => $this->user->id, 'organization_id' => $this->organization->id]);

        expect($clinicAdmin->clinic)->toBeInstanceOf(Clinic::class);
        expect($clinicAdmin->clinic->id)->toBe($clinic->id);
    });

    it('can have sub clinics', function () {
        $clinicAdmin = ClinicAdmin::factory()->create(['user_id' => $this->user->id, 'organization_id' => $this->organization->id]);
        $clinic1 = Clinic::factory()->create(['sub_clinic_admin_id' => $clinicAdmin->id, 'organization_id' => $this->organization->id]);
        $clinic2 = Clinic::factory()->create(['sub_clinic_admin_id' => $clinicAdmin->id, 'organization_id' => $this->organization->id]);

        expect($clinicAdmin->subClinics)->toHaveCount(2);
        expect($clinicAdmin->subClinics->first())->toBeInstanceOf(Clinic::class);
        expect($clinicAdmin->subClinics->first()->id)->toBe($clinic1->id);
    });

    it('deletes the user when deleting the clinic admin', function () {
        $user = User::factory()->create(['organization_id' => $this->organization->id]);
        $clinicAdmin = ClinicAdmin::factory()->create(['user_id' => $user->id, 'organization_id' => $this->organization->id]);

        $clinicAdmin->delete();

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    });

    it('deletes the clinic when deleting the super admin and has clinic', function () {
        $clinic = Clinic::factory()->create(['organization_id' => $this->organization->id]);
        $user = User::factory()->create(['organization_id' => $this->organization->id]);
        $clinicAdmin = ClinicAdmin::factory()->create(['type' => ClinicAdmin::TYPE_SUPER_ADMIN, 'clinic_id' => $clinic->id, 'user_id' => $user->id, 'organization_id' => $this->organization->id]);

        $clinicAdmin->delete();

        $this->assertDatabaseMissing('clinics', ['id' => $clinic->id]);
    });
});
