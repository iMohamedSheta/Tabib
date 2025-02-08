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
        $columns = $this->getEmbeddingColumns();
        $data = [class_basename($this)];

        foreach ($columns as $column) {
            if (str_contains((string) $column, '.')) {
                [$relation, $attribute] = explode('.', (string) $column, 2);
                $value = optional($this->$relation)->$attribute;
            } else {
                $value = $this->$column;
            }

            if (!empty($value)) {
                $label = str_replace('.', ' ', ucfirst(str_replace('_', ' ', $column)));
                $data[] = "$label: $value";
            }
        }

        return implode(', ', $data); // Use a separator for clarity
    }

    abstract protected function getEmbeddingColumns(): array;
}
