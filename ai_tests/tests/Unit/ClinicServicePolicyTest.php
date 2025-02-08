<?php

use App\Models\ClinicService;
use App\Models\Organization;
use App\Models\User;
use App\Policies\ClinicServicePolicy;

use function Pest\Laravel\actingAs;

beforeEach(function (): void {
    $this->organization = Organization::factory()->create();
    $this->clinicService = ClinicService::factory()->create(['organization_id' => $this->organization->id]);
    $this->policy = new ClinicServicePolicy();
});

describe('view', function () {
    it('allows users within the same organization to view the ClinicService', function () {
        $user = User::factory()->create(['organization_id' => $this->organization->id]);
        actingAs($user);
        expect($this->policy->view($user, $this->clinicService))->toBeTrue();
    });

    it('denies users from different organizations to view the ClinicService', function () {
        $user = User::factory()->create();
        actingAs($user);
        expect($this->policy->view($user, $this->clinicService))->toBeFalse();
    });
});

describe('create', function () {
    it('allows clinic admins to create ClinicServices', function () {
        $user = User::factory()->clinicAdmin()->create(['organization_id' => $this->organization->id]);
        actingAs($user);
        expect($this->policy->create($user))->toBeTrue();
    });

    it('allows receptionists to create ClinicServices', function () {
        $user = User::factory()->receptionist()->create(['organization_id' => $this->organization->id]);
        actingAs($user);
        expect($this->policy->create($user))->toBeTrue();
    });

    it('denies other users from creating ClinicServices', function () {
        $user = User::factory()->create(['organization_id' => $this->organization->id]);
        actingAs($user);
        expect($this->policy->create($user))->toBeFalse();
    });
});

describe('update', function () {
    it('allows clinic admins in the same organization to update ClinicServices', function () {
        $user = User::factory()->clinicAdmin()->create(['organization_id' => $this->organization->id]);
        actingAs($user);
        expect($this->policy->update($user, $this->clinicService))->toBeTrue();
    });

    it('allows receptionists to update ClinicServices', function () {
        $user = User::factory()->receptionist()->create(['organization_id' => $this->organization->id]);
        actingAs($user);
        expect($this->policy->update($user, $this->clinicService))->toBeTrue();
    });

    it('denies update for clinic admins in different organizations', function () {
        $user = User::factory()->clinicAdmin()->create();
        actingAs($user);
        expect($this->policy->update($user, $this->clinicService))->toBeFalse();
    });

    it('denies other users from updating ClinicServices', function () {
        $user = User::factory()->create(['organization_id' => $this->organization->id]);
        actingAs($user);
        expect($this->policy->update($user, $this->clinicService))->toBeFalse();
    });
});

describe('delete', function () {
    it('allows clinic admins in the same organization to delete ClinicServices', function () {
        $user = User::factory()->clinicAdmin()->create(['organization_id' => $this->organization->id]);
        actingAs($user);
        expect($this->policy->delete($user, $this->clinicService))->toBeTrue();
    });

    it('allows receptionists to delete ClinicServices', function () {
        $user = User::factory()->receptionist()->create(['organization_id' => $this->organization->id]);
        actingAs($user);
        expect($this->policy->delete($user, $this->clinicService))->toBeTrue();
    });

    it('denies delete for clinic admins in different organizations', function () {
        $user = User::factory()->clinicAdmin()->create();
        actingAs($user);
        expect($this->policy->delete($user, $this->clinicService))->toBeFalse();
    });

    it('denies other users from deleting ClinicServices', function () {
        $user = User::factory()->create(['organization_id' => $this->organization->id]);
        actingAs($user);
        expect($this->policy->delete($user, $this->clinicService))->toBeFalse();
    });
});

describe('restore', function () {
    it('allows clinic admins in the same organization to restore ClinicServices', function () {
        $user = User::factory()->clinicAdmin()->create(['organization_id' => $this->organization->id]);
        actingAs($user);
        expect($this->policy->restore($user, $this->clinicService))->toBeTrue();
    });

    it('allows receptionists to restore ClinicServices', function () {
        $user = User::factory()->receptionist()->create(['organization_id' => $this->organization->id]);
        actingAs($user);
        expect($this->policy->restore($user, $this->clinicService))->toBeTrue();
    });

    it('denies restore for clinic admins in different organizations', function () {
        $user = User::factory()->clinicAdmin()->create();
        actingAs($user);
        expect($this->policy->restore($user, $this->clinicService))->toBeFalse();
    });

    it('denies other users from restoring ClinicServices', function () {
        $user = User::factory()->create(['organization_id' => $this->organization->id]);
        actingAs($user);
        expect($this->policy->restore($user, $this->clinicService))->toBeFalse();
    });
});

describe('forceDelete', function () {
    it('allows clinic admins in the same organization to force delete ClinicServices', function () {
        $user = User::factory()->clinicAdmin()->create(['organization_id' => $this->organization->id]);
        actingAs($user);
        expect($this->policy->forceDelete($user, $this->clinicService))->toBeTrue();
    });

    it('denies force delete for clinic admins in different organizations', function () {
        $user = User::factory()->clinicAdmin()->create();
        actingAs($user);
        expect($this->policy->forceDelete($user, $this->clinicService))->toBeFalse();
    });

    it('denies other users from force deleting ClinicServices', function () {
        $user = User::factory()->create(['organization_id' => $this->organization->id]);
        actingAs($user);
        expect($this->policy->forceDelete($user, $this->clinicService))->toBeFalse();
    });
});
