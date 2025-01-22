<?php

namespace App\Enums\Invoice;

enum InvoiceTypeEnum: int
{
    case PATIENT_APPOINTMENT = 1; // Invoice for patient consultations or follow-ups
    case LAB_TEST = 2;           // Invoice for laboratory or diagnostic tests
    case IMAGING = 3;            // Invoice for imaging services (e.g., X-ray, MRI, CT scan)
    case PROCEDURE = 4;          // Invoice for medical or surgical procedures
    case MEDICATION = 5;         // Invoice for prescribed or dispensed medications
    case ANNUAL_PACKAGE = 6;     // Invoice for annual health or subscription packages
    case OTHER = 7;              // Miscellaneous or custom invoices

    /**
     * Get a human-readable label in Arabic for each type.
     */
    public function label(): string
    {
        return match ($this) {
            self::PATIENT_APPOINTMENT => 'فاتورة موعد مريض',
            self::LAB_TEST => 'فاتورة فحص مخبري',
            self::IMAGING => 'فاتورة خدمة تصوير',
            self::PROCEDURE => 'فاتورة إجراء طبي',
            self::MEDICATION => 'فاتورة أدوية',
            self::ANNUAL_PACKAGE => 'فاتورة باقة سنوية',
            self::OTHER => 'فاتورة أخرى',
        };
    }

    /**
     * Get a Font Awesome icon for each type.
     */
    public function icon(): string
    {
        return match ($this) {
            self::PATIENT_APPOINTMENT => 'fas fa-user-md',
            self::LAB_TEST => 'fas fa-vial',
            self::IMAGING => 'fas fa-x-ray',
            self::PROCEDURE => 'fas fa-syringe',
            self::MEDICATION => 'fas fa-pills',
            self::ANNUAL_PACKAGE => 'fas fa-box-open',
            self::OTHER => 'fas fa-file-invoice',
        };
    }
}
