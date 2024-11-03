<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class Helper
{
    public static function log(\Exception $e)
    {
        Log::error('Exception Occurred: ', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'timestamp' => now()->toDateTimeString(),
        ]);
    }
}
