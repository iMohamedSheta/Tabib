<?php

namespace App\Services\External\Ai\Embedding;

use App\Enums\Ai\AiModelEnum;
use EchoLabs\Prism\Prism;
use Pgvector\Laravel\SparseVector;
use Pgvector\Laravel\Vector;

class GenerateEmbeddingService
{
    protected $dimension = 768;

    public function handle(string $text): array
    {
        $textPreProcessor = new PreprocessEmbeddedTextService($text);

        $translatedCleanedText = (string) $textPreProcessor->clean()->translate();

        [$modelKey, $model] = $this->model();

        $request = Prism::embeddings()
            ->using($modelKey, $model)
            ->fromInput($translatedCleanedText)
            ->generate();

        return $request->embeddings ?? [];
    }

    public function use768Di($embeddings): ?Vector
    {
        if (768 == $this->dimension) {
            return new Vector($embeddings);
        }

        return null;
    }

    public function useSparseVector($embeddings, $dimension = null): ?SparseVector
    {
        return new SparseVector($embeddings, $dimension);
    }

    public function use1536Di($embeddings): ?Vector
    {
        if (1536 == $this->dimension) {
            return $embeddings;
        }

        return null;
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
}
