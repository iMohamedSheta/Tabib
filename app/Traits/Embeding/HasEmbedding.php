<?php

namespace App\Traits\Embeding;

use App\Events\Dispatch\EmbeddingCreated;

trait HasEmbedding
{
    protected static function bootHasEmbedding()
    {
        static::created(function ($model): void {
            event(new EmbeddingCreated($model));
        });
    }

    public function getEmbeddingText(): string
    {
        $data = $this->embeddedFields();

        // Filter out empty or null values
        $filteredData = array_filter($data, fn ($value): bool => !empty($value) && ' ' !== $value);

        // Convert to key-value string
        return strtolower(trim(implode(' & ', array_map(fn ($key, $value): string => "$key: $value", array_keys($filteredData), $filteredData))));
    }

    abstract protected function embeddedFields(): array;
}
