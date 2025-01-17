<?php

namespace App\Formatters;

class DataSizeFormatter
{
    public static function size(int $bytes, int $decimals = 2): string
    {
        // $sizes = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $sizes = ['بايت', 'كيلو بايت', 'ميجا بايت', 'جيجا بايت', 'تيرا بايت', 'PB', 'EB', 'ZB', 'YB'];
        $factor = $bytes > 0 ? floor(log($bytes, 1024)) : 0;
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . ' ' . $sizes[$factor];
    }
}
