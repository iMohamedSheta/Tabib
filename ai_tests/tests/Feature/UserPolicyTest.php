<?php

use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->policy = new UserPolicy();
    $this->actorUser = User::factory()->create();
    $this->targetUser = User::factory()->create();
});

describe('UserPolicy', function () {
    describe('viewAny', function () {
        it('allows clinic admins to view any users', function () {
            $this->actorUser->role = 'App\\Models\\ClinicAdmin';
            $this->actorUser->save();
            expect($this->policy->viewAny($this->actorUser))->toBeTrue();
        });

        it('denies non-clinic admins from viewing any users', function () {
            expect($this->policy->viewAny($this->actorUser))->toBeFalse();
        });
    });

    describe('view', function () {
        it('allows clinic admins in the same organization to view a user', function () {
            $this->actorUser->role = 'App\\Models\\ClinicAdmin';
            $this->actorUser->organization_id = 1;
            $this->actorUser->save();

            $this->targetUser->organization_id = 1;
            $this->targetUser->save();
            expect($this->policy->view($this->actorUser, $this->targetUser))->toBeTrue();
        });

        it('denies clinic admins in different organizations from viewing a user', function () {
            $this->actorUser->role = 'App\\Models\\ClinicAdmin';
            $this->actorUser->organization_id = 1;
            $this->actorUser->save();

            $this->targetUser->organization_id = 2;
            $this->targetUser->save();
            expect($this->policy->view($this->actorUser, $this->targetUser))->toBeFalse();
        });

        it('denies non-clinic admins from viewing a user', function () {
            $this->actorUser->organization_id = 1;
            $this->actorUser->save();

            $this->targetUser->organization_id = 1;
            $this->targetUser->save();

            expect($this->policy->view($this->actorUser, $this->targetUser))->toBeFalse();
        });
    });

    describe('create', function () {
        it('allows clinic admins to create users', function () {
            $this->actorUser->role = 'App\\Models\\ClinicAdmin';
            $this->actorUser->save();
            expect($this->policy->create($this->actorUser))->toBeTrue();
        });

        it('denies non-clinic admins from creating users', function () {
            expect($this->policy->create($this->actorUser))->toBeFalse();
        });
    });

    describe('update', function () {
        it('allows clinic admins in the same organization to update a user', function () {
            $this->actorUser->role = 'App\\Models\\ClinicAdmin';
            $this->actorUser->organization_id = 1;
            $this->actorUser->save();

            $this->targetUser->organization_id = 1;
            $this->targetUser->save();

            expect($this->policy->update($this->actorUser, $this->targetUser))->toBeTrue();
        });

        it('denies clinic admins in different organizations from updating a user', function () {
            $this->actorUser->role = 'App\\Models\\ClinicAdmin';
            $this->actorUser->organization_id = 1;
            $this->actorUser->save();

            $this->targetUser->organization_id = 2;
            $this->targetUser->save();
            expect($this->policy->update($this->actorUser, $this->targetUser))->toBeFalse();
        });

        it('denies non-clinic admins from updating a user', function () {
            $this->actorUser->organization_id = 1;
            $this->actorUser->save();

            $this->targetUser->organization_id = 1;
            $this->targetUser->save();
            expect($this->policy->update($this->actorUser, $this->targetUser))->toBeFalse();
        });
    });

    describe('delete', function () {
        it('allows clinic admins in the same organization to delete a user', function () {
            $this->actorUser->role = 'App\\Models\\ClinicAdmin';
            $this->actorUser->organization_id = 1;
            $this->actorUser->save();

            $this->targetUser->organization_id = 1;
            $this->targetUser->save();
            expect($this->policy->delete($this->actorUser, $this->targetUser))->toBeTrue();
        });

        it('denies clinic admins in different organizations from deleting a user', function () {
            $this->actorUser->role = 'App\\Models\\ClinicAdmin';
            $this->actorUser->organization_id = 1;
            $this->actorUser->save();

            $this->targetUser->organization_id = 2;
            $this->targetUser->save();
            expect($this->policy->delete($this->actorUser, $this->targetUser))->toBeFalse();
        });

        it('denies non-clinic admins from deleting a user', function () {
            $this->actorUser->organization_id = 1;
            $this->actorUser->save();

            $this->targetUser->organization_id = 1;
            $this->targetUser->save();
            expect($this->policy->delete($this->actorUser, $this->targetUser))->toBeFalse();
        });
    });

    describe('restore', function () {
        it('allows clinic admins in the same organization to restore a user', function () {
            $this->actorUser->role = 'App\\Models\\ClinicAdmin';
            $this->actorUser->organization_id = 1;
            $this->actorUser->save();

            $this->targetUser->organization_id = 1;
            $this->targetUser->save();
            expect($this->policy->restore($this->actorUser, $this->targetUser))->toBeTrue();
        });

        it('denies clinic admins in different organizations from restoring a user', function () {
            $this->actorUser->role = 'App\\Models\\ClinicAdmin';
            $this->actorUser->organization_id = 1;
            $this->actorUser->save();

            $this->targetUser->organization_id = 2;
            $this->targetUser->save();
            expect($this->policy->restore($this->actorUser, $this->targetUser))->toBeFalse();
        });

        it('denies non-clinic admins from restoring a user', function () {
            $this->actorUser->organization_id = 1;
            $this->actorUser->save();

            $this->targetUser->organization_id = 1;
            $this->targetUser->save();
            expect($this->policy->restore($this->actorUser, $this->targetUser))->toBeFalse();
        });
    });

    describe('forceDelete', function () {
        it('allows clinic admins in the same organization to force delete a user', function () {
            $this->actorUser->role = 'App\\Models\\ClinicAdmin';
            $this->actorUser->organization_id = 1;
            $this->actorUser->save();

            $this->targetUser->organization_id = 1;
            $this->targetUser->save();
            expect($this->policy->forceDelete($this->actorUser, $this->targetUser))->toBeTrue();
        });

        it('denies clinic admins in different organizations from force deleting a user', function () {
            $this->actorUser->role = 'App\\Models\\ClinicAdmin';
            $this->actorUser->organization_id = 1;
            $this->actorUser->save();

            $this->targetUser->organization_id = 2;
            $this->targetUser->save();
            expect($this->policy->forceDelete($this->actorUser, $this->targetUser))->toBeFalse();
        });

        it('denies non-clinic admins from force deleting a user', function () {
            $this->actorUser->organization_id = 1;
            $this->actorUser->save();

            $this->targetUser->organization_id = 1;
            $this->targetUser->save();
            expect($this->policy->forceDelete($this->actorUser, $this->targetUser))->toBeFalse();
        });
    });

    describe('deleteAttachedFile', function () {
        it('allows clinic admins in the same organization to delete attached files', function () {
            $this->actorUser->role = 'App\\Models\\ClinicAdmin';
            $this->actorUser->organization_id = 1;
            $this->actorUser->save();

            $this->targetUser->organization_id = 1;
            $this->targetUser->save();
            expect($this->policy->deleteAttachedFile($this->actorUser, $this->targetUser))->toBeTrue();
        });

        it('denies clinic admins in different organizations from deleting attached files', function () {
            $this->actorUser->role = 'App\\Models\\ClinicAdmin';
            $this->actorUser->organization_id = 1;
            $this->actorUser->save();

            $this->targetUser->organization_id = 2;
            $this->targetUser->save();
            expect($this->policy->deleteAttachedFile($this->actorUser, $this->targetUser))->toBeFalse();
        });

        it('denies non-clinic admins from deleting attached files', function () {
            $this->actorUser->organization_id = 1;
            $this->actorUser->save();

            $this->targetUser->organization_id = 1;
            $this->targetUser->save();
            expect($this->policy->deleteAttachedFile($this->actorUser, $this->targetUser))->toBeFalse();
        });
    });
});
