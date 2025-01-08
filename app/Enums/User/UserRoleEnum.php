<?php

namespace App\Enums\User;

use App\Models\ClinicAdmin;
use App\Models\Doctor;
use App\Models\Manager;
use Illuminate\Support\Facades\Auth;

enum UserRoleEnum: String
{
    case MANAGER = Manager::class;
    case CLINIC_ADMIN = ClinicAdmin::class;
    case DOCTOR = Doctor::class;

    public const DEFAULT = self::CLINIC_ADMIN->value;

    public static function authRedirectRouteBasedOnType(): string
    {
        $role = Auth::user()->role;

        return match ($role) {
            self::MANAGER->value => route('app.admin.dashboard'),
            self::CLINIC_ADMIN->value => route('app.admin.clinic.index'),
            self::DOCTOR->value => route('app.admin.dashboard'),
            default => route('app.admin.clinic.index'),
        };
    }

    // Work as route and view prefix
    public static function getAuthPrefix(): string
    {
        $role = Auth::user()->role;

        return match ($role) {
            self::MANAGER->value => 'manager',
            self::CLINIC_ADMIN->value => 'admin',
            self::DOCTOR->value => 'doctor',
            default => 'unknown',
        };
    }
}
