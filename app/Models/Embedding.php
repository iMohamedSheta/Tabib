<?php

namespace App\Models;

use App\Models\Scopes\OrganizationScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Pgvector\Laravel\HasNeighbors;
use Pgvector\Laravel\Vector;

#[ScopedBy(OrganizationScope::class)]
class Embedding extends Model
{
    use HasFactory;
    use HasNeighbors;

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

    public function scopeSearchSimilar(Builder $builder, Vector $embedding, int $maxCount = 10, int $minLength = 50, float $minThreshold = 0.5)
    {
        return $this->selectRaw('*, (embedding <#> ?) * -1 AS similarity', [$embedding])
            ->whereRaw('length(content) >= ?', [$minLength])
            ->whereRaw('(embedding <#> ?) * -1 > ?', [$embedding, $minThreshold])
            ->orderByRaw('embedding <#> ?', [$embedding])
            ->take($maxCount)
            ->pluck('content', 'id')
            ->toArray();
    }
}
