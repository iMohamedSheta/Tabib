<?php

use App\Enums\Invoice\InvoiceTypeEnum;

it('can get the correct Arabic label for each invoice type', function () {
    expect(InvoiceTypeEnum::PATIENT_APPOINTMENT->label())->toBe('فاتورة موعد مريض');
    expect(InvoiceTypeEnum::LAB_TEST->label())->toBe('فاتورة فحص مخبري');
    expect(InvoiceTypeEnum::IMAGING->label())->toBe('فاتورة خدمة تصوير');
    expect(InvoiceTypeEnum::PROCEDURE->label())->toBe('فاتورة إجراء طبي');
    expect(InvoiceTypeEnum::MEDICATION->label())->toBe('فاتورة أدوية');
    expect(InvoiceTypeEnum::ANNUAL_PACKAGE->label())->toBe('فاتورة باقة سنوية');
    expect(InvoiceTypeEnum::OTHER->label())->toBe('فاتورة أخرى');
});

it('can get the correct Font Awesome icon for each invoice type', function () {
    expect(InvoiceTypeEnum::PATIENT_APPOINTMENT->icon())->toBe('fas fa-user-md');
    expect(InvoiceTypeEnum::LAB_TEST->icon())->toBe('fas fa-vial');
    expect(InvoiceTypeEnum::IMAGING->icon())->toBe('fas fa-x-ray');
    expect(InvoiceTypeEnum::PROCEDURE->icon())->toBe('fas fa-syringe');
    expect(InvoiceTypeEnum::MEDICATION->icon())->toBe('fas fa-pills');
    expect(InvoiceTypeEnum::ANNUAL_PACKAGE->icon())->toBe('fas fa-box-open');
    expect(InvoiceTypeEnum::OTHER->icon())->toBe('fas fa-file-invoice');
});
