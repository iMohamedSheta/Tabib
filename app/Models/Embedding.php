<?php

namespace App\Models;

use App\Models\Scopes\OrganizationScope;
use App\Services\External\Ai\Embedding\GenerateEmbeddingService;
use App\Services\External\Ai\Embedding\PreprocessEmbeddedTextService;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    public function scopeSemanticSearch(Builder $builder, Vector $embedding, int $maxCount = 10, ?int $minLength = null, ?float $minThreshold = null): array
    {
        return $builder->selectRaw('*, (embedding <#> ?) * -1 AS similarity', [$embedding])
            ->when($minLength, function (Builder &$builder) use ($minLength): void {
                $builder->whereRaw('length(content) >= ?', [$minLength]);
            })
            ->when($minThreshold, function (Builder &$builder) use ($embedding, $minThreshold): void {
                $builder->whereRaw('(embedding <#> ?) * -1 > ?', [$embedding, $minThreshold]);
            })
            ->orderByRaw('embedding <#> ?', [$embedding])
            ->take($maxCount)
            ->pluck('content', 'id')
            ->toArray();
    }

    public function scopeKeywordSearch(Builder  &$builder, string $search, int $limit = 5): array
    {
        $searchString = '%' . implode('%', array_map('trim', explode(' ', $search))) . '%';

        return $builder->where('content', 'LIKE', $searchString)
            ->limit($limit)
            ->pluck('content', 'id')
            ->toArray();
    }

    public static function search(string $message, int $chunksLimit = 5, bool $keywordSearch = false, int $keywordResultsLimit = 5): string
    {
        $messagePreProcessor = new PreprocessEmbeddedTextService($message);
        $translatedCleanedMessage = (string) $messagePreProcessor->clean()->translate();

        $messageVector = (new GenerateEmbeddingService())->handle($translatedCleanedMessage);

        $semanticSearchResults = Embedding::semanticSearch(new Vector($messageVector), $chunksLimit);

        $keywordSearchResults = $keywordSearch
            ? Embedding::keywordSearch($message, $keywordResultsLimit)
            : [];

        $i = 1;

        return implode(', ', array_map(function (string $item) use (&$i): string {
            return ($i++) . '. ' . $item;
        }, array_unique([...$semanticSearchResults, ...$keywordSearchResults])));
    }
}
