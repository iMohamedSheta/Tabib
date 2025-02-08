<?php

use App\Models\Doctor;
use App\Models\Organization;
use App\Models\User;
use App\Policies\DoctorPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $this->policy = new DoctorPolicy();
    $this->organization = Organization::factory()->create();
    $this->doctor = Doctor::factory()->create(['organization_id' => $this->organization->id]);
});

describe('view', function () {
    it('allows users in the same organization to view the doctor', function () {
        $user = User::factory()->create(['organization_id' => $this->organization->id]);
        expect($this->policy->view($user, $this->doctor))->toBeTrue();
    });

    it('denies users in different organizations from viewing the doctor', function () {
        $user = User::factory()->create();
        expect($this->policy->view($user, $this->doctor))->toBeFalse();
    });
});

describe('create', function () {
    it('allows clinic admins to create doctors', function () {
        $user = User::factory()->clinicAdmin()->create(['organization_id' => $this->organization->id]);
        expect($this->policy->create($user))->toBeTrue();
    });

    it('allows receptionists to create doctors', function () {
        $user = User::factory()->receptionist()->create(['organization_id' => $this->organization->id]);
        expect($this->policy->create($user))->toBeTrue();
    });

    it('denies other users from creating doctors', function () {
        $user = User::factory()->create(['organization_id' => $this->organization->id]);
        expect($this->policy->create($user))->toBeFalse();
    });
});

describe('update', function () {
    it('allows clinic admins in the same organization to update the doctor', function () {
        $user = User::factory()->clinicAdmin()->create(['organization_id' => $this->organization->id]);
        expect($this->policy->update($user, $this->doctor))->toBeTrue();
    });

    it('allows receptionists to update doctors', function () {
        $user = User::factory()->receptionist()->create(['organization_id' => $this->organization->id]);
        expect($this->policy->update($user, $this->doctor))->toBeTrue();
    });

    it('denies clinic admins in different organizations from updating the doctor', function () {
        $organization2 = Organization::factory()->create();
        $user = User::factory()->clinicAdmin()->create(['organization_id' => $organization2->id]);
        expect($this->policy->update($user, $this->doctor))->toBeFalse();
    });

    it('denies other users from updating the doctor', function () {
        $user = User::factory()->create(['organization_id' => $this->organization->id]);
        expect($this->policy->update($user, $this->doctor))->toBeFalse();
    });
});

describe('delete', function () {
    it('allows clinic admins in the same organization to delete the doctor', function () {
        $user = User::factory()->clinicAdmin()->create(['organization_id' => $this->organization->id]);
        expect($this->policy->delete($user, $this->doctor))->toBeTrue();
    });

    it('allows receptionists to delete doctors', function () {
        $user = User::factory()->receptionist()->create(['organization_id' => $this->organization->id]);
        expect($this->policy->delete($user, $this->doctor))->toBeTrue();
    });

    it('denies clinic admins in different organizations from deleting the doctor', function () {
        $organization2 = Organization::factory()->create();
        $user = User::factory()->clinicAdmin()->create(['organization_id' => $organization2->id]);
        expect($this->policy->delete($user, $this->doctor))->toBeFalse();
    });

    it('denies other users from deleting the doctor', function () {
        $user = User::factory()->create(['organization_id' => $this->organization->id]);
        expect($this->policy->delete($user, $this->doctor))->toBeFalse();
    });
});

describe('restore', function () {
    it('allows clinic admins in the same organization to restore the doctor', function () {
        $user = User::factory()->clinicAdmin()->create(['organization_id' => $this->organization->id]);
        expect($this->policy->restore($user, $this->doctor))->toBeTrue();
    });
    it('allows receptionists to restore doctors', function () {
        $user = User::factory()->receptionist()->create(['organization_id' => $this->organization->id]);
        expect($this->policy->restore($user, $this->doctor))->toBeTrue();
    });

    it('denies clinic admins in different organizations from restoring the doctor', function () {
        $organization2 = Organization::factory()->create();
        $user = User::factory()->clinicAdmin()->create(['organization_id' => $organization2->id]);
        expect($this->policy->restore($user, $this->doctor))->toBeFalse();
    });

    it('denies other users from restoring the doctor', function () {
        $user = User::factory()->create(['organization_id' => $this->organization->id]);
        expect($this->policy->restore($user, $this->doctor))->toBeFalse();
    });
});

describe('forceDelete', function () {
    it('allows clinic admins in the same organization to force delete the doctor', function () {
        $user = User::factory()->clinicAdmin()->create(['organization_id' => $this->organization->id]);
        expect($this->policy->forceDelete($user, $this->doctor))->toBeTrue();
    });

    it('denies clinic admins in different organizations from force deleting the doctor', function () {
        $organization2 = Organization::factory()->create();
        $user = User::factory()->clinicAdmin()->create(['organization_id' => $organization2->id]);
        expect($this->policy->forceDelete($user, $this->doctor))->toBeFalse();
    });

    it('denies other users from force deleting the doctor', function () {
        $user = User::factory()->create(['organization_id' => $this->organization->id]);
        expect($this->policy->forceDelete($user, $this->doctor))->toBeFalse();
    });
});
