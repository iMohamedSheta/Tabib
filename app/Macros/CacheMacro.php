<?php

declare(strict_types=1);

namespace App\Macros;

use App\Contracts\MacroInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CacheMacro implements MacroInterface
{
    public static function boot(): void
    {
        self::registerGenerateOrgScopedKey();
    }

    public static function register(): void
    {
    }

    /**
     * Registers a macro to generate an organization-scoped cache key.
     *
     * The key combines the class name, a custom key, and the current user's organization ID.
     *
     * @example Cache::generateOrgScopedKey('user', self::class)
     */
    public static function registerGenerateOrgScopedKey(): void
    {
        Cache::macro(
            'generateOrgScopedKey',
            fn (string $key, string $class): string => sprintf(
                '%s:%s:%s',
                strtolower(str_replace(['\\', '::'], ':', $class)),
                $key,
                'org_' . Auth::user()->organization_id
            )
        );
    }
}
