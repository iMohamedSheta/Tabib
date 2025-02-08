<?php

use App\Enums\Ai\PromptMessageEnum;

use function Pest\Faker\fake;


describe('PromptMessageEnum', function () {
    it('returns the correct prompt for WELCOME', function () {
        expect(PromptMessageEnum::WELCOME->prompt())->toBe('مرحبا! كيف يمكنني مساعدتك؟');
    });
});
