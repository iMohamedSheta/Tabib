<?php

namespace App\Models;

use App\Enums\Message\MessageTypeEnum;
use App\Models\Scopes\OrganizationScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

#[ScopedBy(OrganizationScope::class)]
class Prompt extends Model
{
    use HasFactory;

    protected $guarded = [];

    #[\Override]
    protected static function booted()
    {
        self::creating(function ($prompt): void {
            $prompt->organization_id = Auth::user()->organization_id;
        });
    }

    public function messages()
    {
        return $this->morphMany(Message::class, 'model');
    }

    public static function list(int $limit = 50): array
    {
        return self::latest()->take($limit)->pluck('name', 'id')->toArray();
    }

    public function getAiContextAttribute(): array
    {
        return $this->messages->map(fn($message): array => [
            'type' => match ($message->type) {
                MessageTypeEnum::ANSWER->value => 'ai',
                MessageTypeEnum::QUESTION->value => 'user',
                default => 'system',
            },
            'message' => $message->message,
        ])->toArray();
    }
}
