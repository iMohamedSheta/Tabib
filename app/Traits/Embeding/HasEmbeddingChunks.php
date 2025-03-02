<?php

namespace App\Traits\Embeding;

use App\Events\Dispatch\CreateEmbeddingEvent;
use App\Jobs\ProcessEmbeddingChunksJob;

trait HasEmbeddingChunks
{
    protected static function bootHasEmbeddingChunks()
    {
        static::created(function ($model): void {
            ProcessEmbeddingChunksJob::dispatch($model);
        });
    }

    public function processEmbeddingChunks(): void
    {
        foreach ($this->embeddedChunks() as $chunk) {
            CreateEmbeddingEvent::dispatch($this, $this->generateEmbeddingChunkText($chunk));
        }
    }

    public function generateEmbeddingChunkText($chunk): string
    {
        $data['type'] = class_basename(static::class);

        $data['content'] = is_iterable($chunk) ? implode(' ', iterator_to_array($chunk)) : (string) $chunk;

        $text = strtolower(trim(implode(' & ', array_map(fn($key, $value): string => "$key: $value", array_keys($data), $data))));

        return mb_convert_encoding($text, 'UTF-8', 'UTF-8'); // Cleaned Text
    }

    abstract protected function embeddedChunks(): \Generator;
}
