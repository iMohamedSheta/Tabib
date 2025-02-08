<?php

use App\Enums\Invoice\InvoiceStatusEnum;

uses(Tests\TestCase::class)->in('Unit');

describe('InvoiceStatusEnum', function () {
    it('can match an enum instance by its value', function () {
        expect(InvoiceStatusEnum::match(1))->toBe(InvoiceStatusEnum::PENDING);
        expect(InvoiceStatusEnum::match(2))->toBe(InvoiceStatusEnum::PAID);
        expect(InvoiceStatusEnum::match(3))->toBe(InvoiceStatusEnum::CANCELED);
    });

    it('throws an exception for invalid enum value', function () {
        expect(function () { InvoiceStatusEnum::match(4); })->toThrow(
            InvalidArgumentException::class,
            'Invalid value for InvoiceStatusEnum: 4'
        );
    });

    it('returns the correct label for each status', function () {
        expect(InvoiceStatusEnum::PENDING->label())->toBe('قيد الانتظار');
        expect(InvoiceStatusEnum::PAID->label())->toBe('مدفوعة');
        expect(InvoiceStatusEnum::CANCELED->label())->toBe('تم الإلغاء');
    });

    it('returns the correct icon for each status', function () {
        expect(InvoiceStatusEnum::PENDING->icon())->toBe('🕒');
        expect(InvoiceStatusEnum::PAID->icon())->toBe('✅');
        expect(InvoiceStatusEnum::CANCELED->icon())->toBe('❌');
    });
});
