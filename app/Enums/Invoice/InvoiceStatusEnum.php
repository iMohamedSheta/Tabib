<?php

namespace App\Enums\Invoice;

enum InvoiceStatusEnum: int
{
    case PENDING = 1;
    case PAID = 2;
    case CANCELED = 3;

    /**
     * Retrieve an enum instance by its value.
     */
    public static function match(int $enumValue): static
    {
        return match ($enumValue) {
            self::PENDING->value => self::PENDING,
            self::PAID->value => self::PAID,
            self::CANCELED->value => self::CANCELED,
            default => throw new \InvalidArgumentException("Invalid value for InvoiceStatusEnum: $enumValue"),
        };
    }

    /**
     * Get the human-readable label for each status.
     */
    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'قيد الانتظار',
            self::PAID => 'مدفوعة',
            self::CANCELED => 'تم الإلغاء',
        };
    }

    /**
     * Get the icon for each status.
     */
    public function icon(): string
    {
        return match ($this) {
            self::PENDING => '🕒', // Clock emoji for pending
            self::PAID => '✅',   // Check mark for paid
            self::CANCELED => '❌', // Cross mark for canceled
        };
    }
}
