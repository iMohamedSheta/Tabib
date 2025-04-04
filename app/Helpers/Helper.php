<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class Helper
{
    public static function log(\Exception $exception): void
    {
        Log::error('Exception Occurred: ', [
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'timestamp' => now()->toDateTimeString(),
        ]);
    }

    public static function test()
    {
        return Cache::generateOrgScopedKey('sasasa', self::class);
    }
}
