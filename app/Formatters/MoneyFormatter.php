<?php

namespace App\Formatters;

class MoneyFormatter
{
    public static function format($amount): string
    {
        return number_format($amount, 2) . ' جنيه مصري';
    }
}
