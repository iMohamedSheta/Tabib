<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Pgvector\Laravel\Vector;

class Embedding extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'embedding' => Vector::class,
        'embedding_768' => Vector::class,
    ];

    public function embeddable()
    {
        return $this->morphTo();
    }

    public function wordSearch(string $search): void
    {
        // Cosine Similarity which is great for searching for similar words.
        $this->orderByRaw('embedding <=> ?', [new Vector($search)]);
    }
}
