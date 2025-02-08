<?php

namespace App\Listeners;

use App\Events\Dispatch\EmbeddingCreated;
use App\Models\Embedding;
use App\Services\External\Ai\Embedding\GenerateEmbeddingService;
use Illuminate\Contracts\Queue\ShouldQueue;

class GenerateEmbedding implements ShouldQueue
{
    public function __construct(protected GenerateEmbeddingService $embeddingService)
    {
    }

    public function handle(EmbeddingCreated $event): void
    {
        log_dev(var_export($event, true)); // Better logging

        $model = $event->model;
        $text = $model->getEmbeddingText(); // Ensure this method returns meaningful text.

        if ($text) {
            $embedding = $this->embeddingService->handle($text);

            Embedding::create([
                'embeddable_id' => $model->id,
                'embeddable_type' => $model::class,
                'key' => class_basename($model), // More readable key
                'content' => $text,
                'embedding' => $this->embeddingService->use768Di($embedding),
                'embedding_1536' => $this->embeddingService->use1536Di($embedding),
                'organization_id' => $model->organization_id,
            ]);
        }
    }
}
