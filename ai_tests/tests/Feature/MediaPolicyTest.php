<?php

use App\Models\Media;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $this->organization = Organization::factory()->create();
    $this->user = User::factory()->create(['organization_id' => $this->organization->id]);
    $this->media = Media::factory()->create(['organization_id' => $this->organization->id]);
});

describe('MediaPolicy', function () {
    describe('viewAny', function () {
        it('allows clinic admins to view any media', function () {
            $this->user->role = 'App\Models\ClinicAdmin';
            $this->user->save();

            expect($this->user->can('viewAny', Media::class))->toBeTrue();
        });

        it('denies non-clinic admins to view any media', function () {
            expect($this->user->can('viewAny', Media::class))->toBeFalse();
        });
    });

    describe('view', function () {
        it('allows media owners to view the media', function () {
            $this->user->role = 'App\Models\ClinicAdmin';
            $this->user->save();

            expect($this->user->can('view', $this->media))->toBeTrue();
        });

        it('denies non-media owners to view the media', function () {
            expect($this->user->can('view', $this->media))->toBeFalse();
        });

        it('denies viewing if organization id does not match', function () {
            $this->user->role = 'App\Models\ClinicAdmin';
            $this->user->save();
            $media = Media::factory()->create();

            expect($this->user->can('view', $media))->toBeFalse();
        });
    });

    describe('create', function () {
        it('allows clinic admins to create media', function () {
            $this->user->role = 'App\Models\ClinicAdmin';
            $this->user->save();

            expect($this->user->can('create', Media::class))->toBeTrue();
        });

        it('denies non-clinic admins to create media', function () {
            expect($this->user->can('create', Media::class))->toBeFalse();
        });
    });

    describe('update', function () {
        it('allows media owners to update the media', function () {
            $this->user->role = 'App\Models\ClinicAdmin';
            $this->user->save();

            expect($this->user->can('update', $this->media))->toBeTrue();
        });

        it('denies non-media owners to update the media', function () {
            expect($this->user->can('update', $this->media))->toBeFalse();
        });
    });

    describe('delete', function () {
        it('allows media owners to delete the media', function () {
            $this->user->role = 'App\Models\ClinicAdmin';
            $this->user->save();

            expect($this->user->can('delete', $this->media))->toBeTrue();
        });

        it('denies non-media owners to delete the media', function () {
            expect($this->user->can('delete', $this->media))->toBeFalse();
        });
    });

    describe('restore', function () {
        it('allows media owners to restore the media', function () {
            $this->user->role = 'App\Models\ClinicAdmin';
            $this->user->save();

            expect($this->user->can('restore', $this->media))->toBeTrue();
        });

        it('denies non-media owners to restore the media', function () {
            expect($this->user->can('restore', $this->media))->toBeFalse();
        });
    });

    describe('forceDelete', function () {
        it('allows media owners to force delete the media', function () {
            $this->user->role = 'App\Models\ClinicAdmin';
            $this->user->save();

            expect($this->user->can('forceDelete', $this->media))->toBeTrue();
        });

        it('denies non-media owners to force delete the media', function () {
            expect($this->user->can('forceDelete', $this->media))->toBeFalse();
        });
    });
});
