<?php

namespace App\Contracts;


interface MacroInterface
{
    public static function boot(): void;
    public static function register(): void;
}
