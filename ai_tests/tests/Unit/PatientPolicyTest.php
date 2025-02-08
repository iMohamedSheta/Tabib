<?php

use App\Models\Patient;
use App\Models\User;
use App\Policies\PatientPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $this->policy = new PatientPolicy();
    $this->patient = Patient::factory()->create();
});

describe('view', function (): void {
    it('allows users in the same organization to view the patient', function (): void {
        $user = User::factory()->create(['organization_id' => $this->patient->organization_id]);
        expect($this->policy->view($user, $this->patient))->toBeTrue();
    });

    it('denies users in different organizations from viewing the patient', function (): void {
        $user = User::factory()->create(['organization_id' => fake()->uuid()]);
        expect($this->policy->view($user, $this->patient))->toBeFalse();
    });
});

describe('create', function (): void {
    it('allows clinic admins to create patients', function (): void {
        $user = User::factory()->clinicAdmin()->create();
        expect($this->policy->create($user))->toBeTrue();
    });

    it('allows receptionists to create patients', function (): void {
        $user = User::factory()->receptionist()->create();
        expect($this->policy->create($user))->toBeTrue();
    });

    it('allows doctors to create patients', function (): void {
        $user = User::factory()->doctor()->create();
        expect($this->policy->create($user))->toBeTrue();
    });

    it('denies other users from creating patients', function (): void {
        $user = User::factory()->create();
        expect($this->policy->create($user))->toBeFalse();
    });
});

describe('update', function (): void {
    it('allows clinic admins in the same organization to update patients', function (): void {
        $user = User::factory()->clinicAdmin()->create(['organization_id' => $this->patient->organization_id]);
        expect($this->policy->update($user, $this->patient))->toBeTrue();
    });

    it('allows receptionists to update patients', function (): void {
        $user = User::factory()->receptionist()->create(['organization_id' => $this->patient->organization_id]);
        expect($this->policy->update($user, $this->patient))->toBeTrue();
    });

    it('allows doctors to update patients', function (): void {
        $user = User::factory()->doctor()->create(['organization_id' => $this->patient->organization_id]);
        expect($this->policy->update($user, $this->patient))->toBeTrue();
    });

    it('denies clinic admins in different organizations from updating patients', function (): void {
        $user = User::factory()->clinicAdmin()->create(['organization_id' => fake()->uuid()]);
        expect($this->policy->update($user, $this->patient))->toBeFalse();
    });

    it('denies other users from updating patients', function (): void {
        $user = User::factory()->create(['organization_id' => $this->patient->organization_id]);
        expect($this->policy->update($user, $this->patient))->toBeFalse();
    });
});

describe('delete', function (): void {
    it('allows clinic admins in the same organization to delete patients', function (): void {
        $user = User::factory()->clinicAdmin()->create(['organization_id' => $this->patient->organization_id]);
        expect($this->policy->delete($user, $this->patient))->toBeTrue();
    });

    it('allows receptionists to delete patients', function (): void {
        $user = User::factory()->receptionist()->create(['organization_id' => $this->patient->organization_id]);
        expect($this->policy->delete($user, $this->patient))->toBeTrue();
    });

    it('denies other users from deleting patients', function (): void {
        $user = User::factory()->create(['organization_id' => $this->patient->organization_id]);
        expect($this->policy->delete($user, $this->patient))->toBeFalse();
    });
});

describe('restore', function (): void {
    it('allows clinic admins in the same organization to restore patients', function (): void {
        $user = User::factory()->clinicAdmin()->create(['organization_id' => $this->patient->organization_id]);
        expect($this->policy->restore($user, $this->patient))->toBeTrue();
    });

    it('allows receptionists to restore patients', function (): void {
        $user = User::factory()->receptionist()->create(['organization_id' => $this->patient->organization_id]);
        expect($this->policy->restore($user, $this->patient))->toBeTrue();
    });

    it('denies other users from restoring patients', function (): void {
        $user = User::factory()->create(['organization_id' => $this->patient->organization_id]);
        expect($this->policy->restore($user, $this->patient))->toBeFalse();
    });
});

describe('forceDelete', function (): void {
    it('allows clinic admins in the same organization to force delete patients', function (): void {
        $user = User::factory()->clinicAdmin()->create(['organization_id' => $this->patient->organization_id]);
        expect($this->policy->forceDelete($user, $this->patient))->toBeTrue();
    });

    it('denies other users from force deleting patients', function (): void {
        $user = User::factory()->create(['organization_id' => $this->patient->organization_id]);
        expect($this->policy->forceDelete($user, $this->patient))->toBeFalse();
    });
});
