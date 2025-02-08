<?php

use App\Enums\User\UserRoleEnum;
use App\Models\ClinicAdmin;
use App\Models\Doctor;
use App\Models\Manager;
use Illuminate\Support\Facades\Auth;

beforeEach(function () {
    $this->mockAuthUser = function ($role) {
        $user = new stdClass();
        $user->role = $role;
        Auth::shouldReceive('user')->andReturn($user);

        return $user;
    };
});

describe('authRedirectRouteBasedOnType', function () {
    it('returns the correct route for MANAGER', function () {
        $user = ($this->mockAuthUser)(Manager::class);

        expect(UserRoleEnum::authRedirectRouteBasedOnType())->toBe(route('app.admin.dashboard'));
    });

    it('returns the correct route for CLINIC_ADMIN', function () {
        $user = ($this->mockAuthUser)(ClinicAdmin::class);

        expect(UserRoleEnum::authRedirectRouteBasedOnType())->toBe(route('app.admin.clinic.index'));
    });

    it('returns the correct route for DOCTOR', function () {
        $user = ($this->mockAuthUser)(Doctor::class);

        expect(UserRoleEnum::authRedirectRouteBasedOnType())->toBe(route('app.admin.dashboard'));
    });

    it('returns the default route if role is not recognized', function () {
        $user = ($this->mockAuthUser)('UnknownRole');

        expect(UserRoleEnum::authRedirectRouteBasedOnType())->toBe(route('app.admin.clinic.index'));
    });
});

describe('getAuthPrefix', function () {
    it('returns the correct prefix for MANAGER', function () {
        $user = ($this->mockAuthUser)(Manager::class);

        expect(UserRoleEnum::getAuthPrefix())->toBe('manager');
    });

    it('returns the correct prefix for CLINIC_ADMIN', function () {
        $user = ($this->mockAuthUser)(ClinicAdmin::class);

        expect(UserRoleEnum::getAuthPrefix())->toBe('admin');
    });

    it('returns the correct prefix for DOCTOR', function () {
        $user = ($this->mockAuthUser)(Doctor::class);

        expect(UserRoleEnum::getAuthPrefix())->toBe('doctor');
    });

    it('returns the default prefix if role is not recognized', function () {
        $user = ($this->mockAuthUser)('UnknownRole');

        expect(UserRoleEnum::getAuthPrefix())->toBe('unknown');
    });
});

describe('label', function () {
    it('returns the correct label for MANAGER', function () {
        expect(UserRoleEnum::MANAGER->label())->toBe('مدير النظام');
    });

    it('returns the correct label for CLINIC_ADMIN', function () {
        expect(UserRoleEnum::CLINIC_ADMIN->label())->toBe('مدير العيادات');
    });

    it('returns the correct label for DOCTOR', function () {
        expect(UserRoleEnum::DOCTOR->label())->toBe('طبيب');
    });
});
