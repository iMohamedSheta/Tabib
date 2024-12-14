<?php

namespace App\Enums\User;

enum UserInfoEnum: String
{
    case MALE = 'male';
    case FEMALE = 'female';

    public static function genderLabel($value): string
    {
        return match ($value) {
            self::MALE->value => 'ذكر',
            self::FEMALE->value => 'انثى',
        };
    }
}
