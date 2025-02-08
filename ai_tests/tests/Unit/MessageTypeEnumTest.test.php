<?php

use App\Enums\Message\MessageTypeEnum;

it('can get the correct label for QUESTION', function () {
    expect(MessageTypeEnum::QUESTION->label())->toBe('سؤال');
});

it('can get the correct label for ANSWER', function () {
    expect(MessageTypeEnum::ANSWER->label())->toBe('اجابة');
});
