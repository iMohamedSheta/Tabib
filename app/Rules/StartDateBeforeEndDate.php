<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ValidationRule;

class StartDateBeforeEndDate implements ValidationRule
{
    public function __construct(public $endDateAttribute) {}

    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        if ($this->endDateAttribute && $value > $this->endDateAttribute) {
            $fail('تاريخ البداية يجب ان يكون قبل تاريخ النهاية');
        }
    }
}
