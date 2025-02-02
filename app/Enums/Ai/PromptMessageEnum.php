<?php

namespace App\Enums\Ai;

enum PromptMessageEnum: int
{
    case WELCOME = 1;

    public function prompt(): string
    {
        return match ($this) {
            self::WELCOME => $this->getWelcomePrompt(),
        };
    }

    private function getWelcomePrompt(): string
    {
        return 'مرحبا! كيف يمكنني مساعدتك؟';
    }
}
