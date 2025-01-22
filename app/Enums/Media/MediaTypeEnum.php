<?php

namespace App\Enums\Media;

enum MediaTypeEnum: int
{
    case FILE = 1; // ملف
    case RADIOLOGY = 2; // اشعة

    public function label(): string
    {
        return match ($this) {
            self::FILE => 'ملف',
            self::RADIOLOGY => 'اشعة',
        };
    }
}
