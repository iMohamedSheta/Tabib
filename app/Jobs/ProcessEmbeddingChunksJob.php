<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Queue\Queueable;

class ProcessEmbeddingChunksJob implements ShouldQueue
{
    use Queueable;

    public function __construct(public Model $model)
    {
    }

    public function handle(): void
    {
        $this->model->processEmbeddingChunks();
    }
}
