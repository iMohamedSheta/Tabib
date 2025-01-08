<?php

namespace App\Enums\User;

enum UserInfoEnum: String
{
    case MALE = 'male';
    case FEMALE = 'female';

    public static function genderLabel(string $value): string
    {
        return match ($value) {
            self::MALE->value => 'ذكر',
            self::FEMALE->value => 'انثى',
            default => 'ذكر',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::MALE => 'ذكر',
            self::FEMALE => 'انثى',
        };
    }
}
