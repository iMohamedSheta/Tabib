<?php

namespace App\Traits\Embeding;

use App\Events\Dispatch\CreateEmbeddingEvent;

trait HasEmbedding
{
    protected static function bootHasEmbedding()
    {
        static::created(function ($model): void {
            event(new CreateEmbeddingEvent($model));
        });
    }

    public function getEmbeddingText(): string
    {
        $data['type'] = class_basename(static::class);

        $data += $this->embeddedFields();

        // Filter out blank values
        $filteredData = array_filter($data, fn ($value): bool => !blank($value));

        // Convert to key-value string
        return strtolower(trim(implode(' & ', array_map(fn ($key, $value): string => "$key: $value", array_keys($filteredData), $filteredData))));
    }

    abstract protected function embeddedFields(): array;
}
