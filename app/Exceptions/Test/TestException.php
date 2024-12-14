<?php

namespace App\Exceptions\Test;

use App\Enums\Exceptions\ExceptionCodeEnum;
use App\Exceptions\Base\InternalException;

class TestException extends InternalException
{
    public static function exception() {
        return static::new(
            code: ExceptionCodeEnum::TEST_EXCEPTION,
            // message: 'This is a test exception',
            // description: 'This is a test exception',
        );
    }
}
