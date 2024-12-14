<?php

namespace App\Enums\Exceptions;

enum ExceptionCodeEnum: int
{
    case TEST_EXCEPTION = 000_00;

    case AUTHORIZE_ERROR = 401_00;

    public function getStatusCode(): int
    {
        $value = $this->value;

        return match(true) {
            $value >= 400_01 && $value <= 401_00  => 401, // Authorization error
            default => 500,
        };
    }
    public function getMessage(): string
    {
        $key = "exceptions.{$this->value}.message";
        $translation = __($key);
        if ($key === $translation) {
            return "Error code: {$this->value} - No additional message provided";
        }
        return $translation;
    }
    public function getDescription(): string
    {
        $key = "exceptions.{$this->value}.description";
        $translation = __($key);
        if ($key === $translation) {
            return "Error code: {$this->value} - No additional description provided";
        }
        return $translation;
    }
    public function getLink(): string
    {
        return route('docs.exceptions', [
            'code' => $this->value,
        ]);
    }

}
