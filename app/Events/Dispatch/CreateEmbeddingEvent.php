<?php

namespace App\Events\Dispatch;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreateEmbeddingEvent
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(public Model $model)
    {
    }
}
