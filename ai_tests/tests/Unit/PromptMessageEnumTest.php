<?php

use App\Enums\Ai\PromptMessageEnum;

describe('PromptMessageEnum', function () {
    it('returns the correct prompt for WELCOME', function () {
        expect(PromptMessageEnum::WELCOME->prompt())->toBe('مرحبا! كيف يمكنني مساعدتك؟');
    });
});
