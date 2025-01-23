<?php

namespace App\Formatters;

class MoneyFormatter
{
    public static function format(?float $amount): string
    {
        if (is_null($amount)) {
            $amount = 0;
        }

        return number_format($amount, 2) . ' جنيه مصري';
    }
}
