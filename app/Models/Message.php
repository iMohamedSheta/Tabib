<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Auth;

class Message extends Model
{
    use HasFactory;

    protected $guarded = [];

    #[\Override]
    protected static function booted()
    {
        self::creating(function ($message): void {
            $message->organization_id = Auth::user()->organization_id;
        });
    }

    public function model(): MorphTo
    {
        return $this->morphTo();
    }
}
