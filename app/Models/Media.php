<?php

namespace App\Models;

use App\Traits\Models\Media\HasMediaUrls;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\Models\Media as MediaLibraryModel;

class Media extends MediaLibraryModel
{
    use HasFactory;
    use HasMediaUrls;

    protected $guarded = [];

    /**
     * The accessors to append to the model's array form.
     */
    protected $appends = [
        'url',
    ];

    protected static function booted()
    {
        self::creating(function ($media): void {
            $media->organization_id = Auth::user()->organization_id;
        });
    }
}
