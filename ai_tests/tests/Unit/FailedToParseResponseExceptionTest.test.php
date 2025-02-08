<?php

use App\Exceptions\FailedToParseResponseException;

it('can be instantiated', function () {
    $exception = new FailedToParseResponseException();
    expect($exception)->toBeInstanceOf(FailedToParseResponseException::class);
});

