<?php

namespace App\Enums\Ai;

enum AiModelEnum: string
{
    // Google pro
    case GEMINI_1_5_PRO = 'gemini-1.5-pro'; // [2 RPM, 1500 RPD] IO_PAID [2.50$, 10$]
    case GEMINI_1_5_FLASH = 'gemini-1.5-flash'; // [15 RPM, 1500 RPD] IO_PAID [0.15$, 0.60$]
    case GEMINI_1_5_FLASH_8B = 'gemini-1.5-flash-8b'; // [15 RPM, 1500 RPD] IO_PAID [0.075$, 0.30$]

    // Google Preview
    case GEMINI_2_0_FLASH_EXP = 'gemini-2.0-flash-exp'; // [10 RPM, 1500 RPD] FREE
    case GEMINI_EXP_1206 = 'gemini-exp-1206'; // unknown
    case GEMINI_2_0_FLASH_THINKING_EXP_01_21 = 'gemini-2.0-flash-thinking-exp-01-21'; // [10 RPM, 1500 RPD] FREE
    case LEARNLM_1_5_PRO_EXPERIMENTAL = 'learnlm-1.5-pro-experimental'; // unknown

    // Google Gamma
    case GEMMA_2_2B_IT = 'gemma-2-2b-it';
    case GEMMA_2_9B_IT = 'gemma-2-9b-it';
    case GEMMA_2_27B_IT = 'gemma-2-27b-it';

    public const MODELSLIST = [
        'gemini-2.0-flash-exp',
        'gemini-exp-1206',
        'gemini-2.0-flash-thinking-exp-01-21',
        'learnlm-1.5-pro-experimental',

        'gemini-1.5-pro',
        'gemini-1.5-flash',
        'gemini-1.5-flash-8b',

        'gemma-2-2b-it',
        'gemma-2-9b-it',
        'gemma-2-27b-it',
    ];
}
