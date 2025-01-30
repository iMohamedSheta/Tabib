<?php

namespace App\Enums\Message;

enum MessageTypeEnum: int
{
    case QUESTION = 1;
    case ANSWER = 2;

    public function label(): string
    {
        return match ($this) {
            self::QUESTION => 'سؤال',
            self::ANSWER => 'اجابة',
        };
    }
}
