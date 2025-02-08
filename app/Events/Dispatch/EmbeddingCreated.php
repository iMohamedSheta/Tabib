<?php

namespace App\Events\Dispatch;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EmbeddingCreated
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(public $model)
    {
    }
}
