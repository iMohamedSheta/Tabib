<?php

namespace App\Services\External\Ai\Embedding;

use App\Enums\Ai\AiModelEnum;
use EchoLabs\Prism\Prism;
use Pgvector\Laravel\Vector;

class GenerateEmbeddingService
{
    protected $dimension = 768;

    public function handle(string $text): array
    {
        $cleanText = $this->preprocessText($text);

        [$modelKey, $model] = $this->model();

        $request = Prism::embeddings()
            ->using($modelKey, $model)
            ->fromInput($cleanText)
            ->generate();

        return $request->embeddings ?? [];
    }

    private function model(): array
    {
        $usingModels = [
            'gemini' => AiModelEnum::TEXT_EMBEDDING_004->value,
            'custom.gemini_1' => AiModelEnum::TEXT_EMBEDDING_004->value,
        ];
        $modelKey = array_rand($usingModels);

        return [$modelKey, $usingModels[$modelKey]];
    }

    public function use768Di($embeddings): ?Vector
    {
        if (768 == $this->dimension) {
            return new Vector($embeddings);
        }

        return null;
    }

    public function use1536Di($embeddings): ?Vector
    {
        if (1536 == $this->dimension) {
            return $embeddings;
        }

        return null;
    }

    private function preprocessText(string $text): string
    {
        // Normalize Unicode
        $text = \Normalizer::normalize($text, \Normalizer::FORM_C);

        // Remove Arabic diacritics (Harakat)
        $text = preg_replace('/[\x{064B}-\x{065F}]/u', '', $text);

        // Remove special characters and punctuation (keep Arabic, numbers, spaces)
        $text = preg_replace('/[^\p{Arabic}\p{N}\s]/u', '', $text);

        // Convert to lowercase
        $text = mb_strtolower($text, 'UTF-8');

        // Trim extra spaces
        $text = preg_replace('/\s+/', ' ', trim($text));

        return $text;
    }
}
