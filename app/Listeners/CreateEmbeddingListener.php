<?php

namespace App\Listeners;

use App\Events\Dispatch\CreateEmbeddingEvent;
use App\Models\Embedding;
use App\Services\External\Ai\Embedding\GenerateEmbeddingService;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateEmbeddingListener implements ShouldQueue
{
    public function __construct(protected GenerateEmbeddingService $embeddingService)
    {
    }

    public function handle(CreateEmbeddingEvent $event): void
    {
        $model = $event->model;

        // if there is a chuck then save the chunk for this specific model else get the embedding text from the model
        $text = $event->chunk ?? $model->getEmbeddingText();

        if ($text) {
            $embedding = $this->embeddingService->handle($text);

            Embedding::create([
                'embeddable_id' => $model->id,
                'embeddable_type' => $model::class,
                'key' => class_basename($model),
                'content' => $text,
                'embedding' => $this->embeddingService->use768Di($embedding),
                'embedding_1536' => $this->embeddingService->use1536Di($embedding),
                // 'sparse_vector' => $this->embeddingService->useSparseVector($embedding, 30522),
                'organization_id' => $model->organization_id,
            ]);
        }
    }
}
