<?php

use App\Enums\User\UserInfoEnum;

it('can get the correct gender label for male', function () {
    expect(UserInfoEnum::genderLabel(UserInfoEnum::MALE->value))->toBe('ذكر');
});

it('can get the correct gender label for female', function () {
    expect(UserInfoEnum::genderLabel(UserInfoEnum::FEMALE->value))->toBe('انثى');
});

it('returns a default gender label if value not found', function () {
    expect(UserInfoEnum::genderLabel('other'))->toBe('ذكر');
});

it('can get the correct label for male enum', function () {
    expect(UserInfoEnum::MALE->label())->toBe('ذكر');
});

it('can get the correct label for female enum', function () {
    expect(UserInfoEnum::FEMALE->label())->toBe('انثى');
});
