<?php

namespace App\Models;

use App\Extractors\FileTextExtractor;
use App\Models\Scopes\OrganizationScope;
use App\Traits\Embeding\HasEmbeddingChunks;
use App\Traits\Models\Media\HasMediaUrls;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\Models\Media as MediaLibraryModel;

#[ScopedBy(OrganizationScope::class)]
class Media extends MediaLibraryModel
{
    use HasFactory;
    use HasMediaUrls;
    use HasEmbeddingChunks;

    protected $guarded = [];

    /**
     * The accessors to append to the model's array form.
     */
    protected $appends = [
        'url',
    ];

    #[\Override]
    protected static function booted()
    {
        self::creating(function ($media): void {
            $media->organization_id = Auth::user()->organization_id;
        });
    }

    public function embeddedChunks(): \Generator
    {
        yield from FileTextExtractor::extractChunks($this->getPath());
    }
}
