<?php

namespace App\Services\External\Ai\Embedding;

use App\Services\External\Translate\GoogleTranslatorService;

class PreprocessEmbeddedTextService implements \Stringable
{
    public function __construct(public string $text)
    {
    }

    public function clean(): self
    {
        // Normalize Unicode
        $this->text = \Normalizer::normalize($this->text, \Normalizer::FORM_C);

        // Remove Arabic diacritics (Harakat)
        preg_replace('/[\x{064B}-\x{065F}]/u', '', $this->text);

        // Remove special characters and punctuation, but keep letters, numbers, and spaces
        $this->text = preg_replace('/[^\p{L}\p{N}\s]/u', '', $this->text);

        // Trim extra spaces
        $this->text = preg_replace('/\s+/', ' ', trim((string) $this->text));

        return $this;
    }

    public function translate(string $targetLang = 'en'): self
    {
        $this->text = GoogleTranslatorService::translate($this->text, $targetLang);

        return $this;
    }

    public function __toString(): string
    {
        return $this->text;
    }
}
