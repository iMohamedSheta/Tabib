<?php

use App\Enums\Clinic\ClinicLevelEnum;

it('can return clinic level labels', function () {
    $labels = ClinicLevelEnum::getClinicLevelLabels();

    expect($labels)->toBeArray();
    expect($labels)->toHaveKey(ClinicLevelEnum::PRIMARY->value);
    expect($labels)->toHaveKey(ClinicLevelEnum::SECONDARY->value);
    expect($labels[ClinicLevelEnum::PRIMARY->value])->toBe('عيادة الرئيسية');
    expect($labels[ClinicLevelEnum::SECONDARY->value])->toBe('عيادة الفرعية');
});

it('can match clinic level label', function () {
    expect(ClinicLevelEnum::matchClinicLevelLabel(ClinicLevelEnum::PRIMARY->value))->toBe('عيادة الرئيسية');
    expect(ClinicLevelEnum::matchClinicLevelLabel(ClinicLevelEnum::SECONDARY->value))->toBe('عيادة الفرعية');
    expect(ClinicLevelEnum::matchClinicLevelLabel(3))->toBe('عيادة اخري');
});

it('has a default value of PRIMARY', function () {
    expect(ClinicLevelEnum::DEFAULT)->toBe(ClinicLevelEnum::PRIMARY->value);
});
