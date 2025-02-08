<?php

use App\Models\Clinic;
use App\Models\Organization;

use function Pest\Faker\fake;

uses(\Tests\TestCase::class)->in('Unit');


describe('Clinic Model', function () {
    it('can create a clinic', function () {
        $organization = Organization::factory()->create();
        $clinic = Clinic::create([
            'name' => 'Test Clinic',
            'organization_id' => $organization->id,
        ]);

        expect($clinic)->toBeInstanceOf(Clinic::class);
        expect($clinic->name)->toBe('Test Clinic');
        expect($clinic->organization_id)->toBe($organization->id);
    });

    it('can retrieve a list of clinics', function () {
        $organization = Organization::factory()->create();
        $clinic1 = Clinic::factory()->create(['organization_id' => $organization->id]);
        $clinic2 = Clinic::factory()->create(['organization_id' => $organization->id]);

        $clinicList = Clinic::list();

        expect($clinicList)->toBeArray();
        expect($clinicList)->toHaveKey($clinic1->id);
        expect($clinicList)->toHaveKey($clinic2->id);
        expect($clinicList[$clinic1->id])->toBe($clinic1->name);
        expect($clinicList[$clinic2->id])->toBe($clinic2->name);
    });

    it('has a subClinics relationship', function () {
        $organization = Organization::factory()->create();
        $parentClinic = Clinic::factory()->create(['organization_id' => $organization->id]);
        $subClinic = Clinic::factory()->create(['organization_id' => $organization->id, 'parent_clinic_id' => $parentClinic->id]);

        expect($parentClinic->subClinics()->first())->toBeInstanceOf(Clinic::class);
        expect($parentClinic->subClinics()->first()->id)->toBe($subClinic->id);
    });

    it('has a parentClinic relationship', function () {
        $organization = Organization::factory()->create();
        $parentClinic = Clinic::factory()->create(['organization_id' => $organization->id]);
        $subClinic = Clinic::factory()->create(['organization_id' => $organization->id, 'parent_clinic_id' => $parentClinic->id]);

        expect($subClinic->parentClinic())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class);
        expect($subClinic->parentClinic()->first())->toBeInstanceOf(Clinic::class);
        expect($subClinic->parentClinic()->first()->id)->toBe($parentClinic->id);
    });

    it('has an organization relationship', function () {
        $organization = Organization::factory()->create();
        $clinic = Clinic::factory()->create(['organization_id' => $organization->id]);

        expect($clinic->organization())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class);
        expect($clinic->organization()->first())->toBeInstanceOf(Organization::class);
        expect($clinic->organization()->first()->id)->toBe($organization->id);
    });
});
