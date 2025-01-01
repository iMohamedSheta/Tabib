<?php

namespace App\Enums\Helpers;

enum HelperEnum: string
{
    case NOT_AVAILABLE = 'not_available';
    case UNKNOWN = 'unknown';

    public function label(): string
    {
        return match ($this) {
            self::NOT_AVAILABLE => __('helpers.helper.not_available'),
            self::UNKNOWN => __('helpers.helper.unknown'),
        };
    }
}
