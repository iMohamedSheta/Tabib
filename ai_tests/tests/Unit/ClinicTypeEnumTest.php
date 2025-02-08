<?php

use App\Enums\Clinic\ClinicTypeEnum;

it('can get clinic type labels', function () {
    $labels = ClinicTypeEnum::getClinicTypeLabels();

    expect($labels)->toBeArray();
    expect($labels)->not()->toBeEmpty();
    expect($labels)->toHaveKey(ClinicTypeEnum::DENTISTRY->value);
    expect($labels)->toHaveKey(ClinicTypeEnum::INTERNAL_MEDICINE->value);
    expect($labels)->toHaveKey(ClinicTypeEnum::DERMATOLOGY->value);
    expect($labels)->toHaveKey(ClinicTypeEnum::OPHTHALMOLOGY->value);
    expect($labels)->toHaveKey(ClinicTypeEnum::ENT->value);
    expect($labels)->toHaveKey(ClinicTypeEnum::OBSTETRICS_GYNECOLOGY->value);
    expect($labels)->toHaveKey(ClinicTypeEnum::CARDIOLOGY->value);
    expect($labels)->toHaveKey(ClinicTypeEnum::ORTHOPEDICS->value);
    expect($labels)->toHaveKey(ClinicTypeEnum::UROLOGY->value);
    expect($labels)->toHaveKey(ClinicTypeEnum::OTHERS->value);

    expect($labels[ClinicTypeEnum::DENTISTRY->value])->toBe('عيادات الأسنان');
    expect($labels[ClinicTypeEnum::INTERNAL_MEDICINE->value])->toBe('عيادات الأمراض الباطنية');
    expect($labels[ClinicTypeEnum::DERMATOLOGY->value])->toBe('عيادة الجلدية');
    expect($labels[ClinicTypeEnum::OPHTHALMOLOGY->value])->toBe('عيادة العيون');
    expect($labels[ClinicTypeEnum::ENT->value])->toBe('عيادات الأنف والأذن والحنجرة');
    expect($labels[ClinicTypeEnum::OBSTETRICS_GYNECOLOGY->value])->toBe('عيادة النساء والولادة');
    expect($labels[ClinicTypeEnum::CARDIOLOGY->value])->toBe('عيادة القلب');
    expect($labels[ClinicTypeEnum::ORTHOPEDICS->value])->toBe('عيادة العظام');
    expect($labels[ClinicTypeEnum::UROLOGY->value])->toBe('عيادة المسالك');
    expect($labels[ClinicTypeEnum::OTHERS->value])->toBe('عيادة أخرى');
});

it('can match clinic type label', function () {
    expect(ClinicTypeEnum::matchClinicTypeLabel(ClinicTypeEnum::DENTISTRY->value))->toBe('عيادات الأسنان');
    expect(ClinicTypeEnum::matchClinicTypeLabel(ClinicTypeEnum::INTERNAL_MEDICINE->value))->toBe('عيادات الأمراض الباطنية');
    expect(ClinicTypeEnum::matchClinicTypeLabel(ClinicTypeEnum::DERMATOLOGY->value))->toBe('عيادة الجلدية');
    expect(ClinicTypeEnum::matchClinicTypeLabel(ClinicTypeEnum::OPHTHALMOLOGY->value))->toBe('عيادة العيون');
    expect(ClinicTypeEnum::matchClinicTypeLabel(ClinicTypeEnum::ENT->value))->toBe('عيادات الأنف والأذن والحنجرة');
    expect(ClinicTypeEnum::matchClinicTypeLabel(ClinicTypeEnum::OBSTETRICS_GYNECOLOGY->value))->toBe('عيادة النساء والولادة');
    expect(ClinicTypeEnum::matchClinicTypeLabel(ClinicTypeEnum::CARDIOLOGY->value))->toBe('عيادة القلب');
    expect(ClinicTypeEnum::matchClinicTypeLabel(ClinicTypeEnum::ORTHOPEDICS->value))->toBe('عيادة العظام');
    expect(ClinicTypeEnum::matchClinicTypeLabel(ClinicTypeEnum::UROLOGY->value))->toBe('عيادة المسالك');
    expect(ClinicTypeEnum::matchClinicTypeLabel(ClinicTypeEnum::OTHERS->value))->toBe('عيادة أخرى');
});

it('returns "عيادة اخري" for unmatched clinic types', function () {
    expect(ClinicTypeEnum::matchClinicTypeLabel(999))->toBe('عيادة اخري');
});
