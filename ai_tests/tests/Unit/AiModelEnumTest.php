<?php

use App\Enums\Ai\AiModelEnum;

it('can list all available models', function () {
    $models = AiModelEnum::MODELSLIST;
    expect($models)->toBeArray();
    expect($models)->not()->toBeEmpty();
});

it('has valid enum values', function () {
    $cases = AiModelEnum::cases();

    foreach ($cases as $case) {
        expect($case)->toBeInstanceOf(AiModelEnum::class);
        expect($case->value)->toBeString();
    }
});

it('contains the expected models', function () {
    expect(AiModelEnum::GEMINI_1_5_PRO->value)->toBe('gemini-1.5-pro');
    expect(AiModelEnum::GEMINI_1_5_FLASH->value)->toBe('gemini-1.5-flash');
    expect(AiModelEnum::GEMINI_1_5_FLASH_8B->value)->toBe('gemini-1.5-flash-8b');
    expect(AiModelEnum::GEMINI_2_0_FLASH_EXP->value)->toBe('gemini-2.0-flash-exp');
    expect(AiModelEnum::GEMINI_EXP_1206->value)->toBe('gemini-exp-1206');
    expect(AiModelEnum::GEMINI_2_0_FLASH_THINKING_EXP_01_21->value)->toBe('gemini-2.0-flash-thinking-exp-01-21');
    expect(AiModelEnum::LEARNLM_1_5_PRO_EXPERIMENTAL->value)->toBe('learnlm-1.5-pro-experimental');
    expect(AiModelEnum::GEMMA_2_2B_IT->value)->toBe('gemma-2-2b-it');
    expect(AiModelEnum::GEMMA_2_9B_IT->value)->toBe('gemma-2-9b-it');
    expect(AiModelEnum::GEMMA_2_27B_IT->value)->toBe('gemma-2-27b-it');
    expect(AiModelEnum::DEEPSEEK_R1_7B->value)->toBe('Deepseek-R1:7B');
});
