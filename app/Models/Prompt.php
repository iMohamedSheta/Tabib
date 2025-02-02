<?php

namespace App\Models;

use App\Enums\Message\MessageTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Prompt extends Model
{
    use HasFactory;

    protected $guarded = [];

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

    public function getAiContextAttribute(): array
    {
        return $this->messages->map(fn ($message) => [
            'type' => match ($message->type) {
                MessageTypeEnum::ANSWER->value => 'ai',
                MessageTypeEnum::QUESTION->value => 'user',
                default => 'system',
            },
            'message' => $message->message,
        ])->toArray();
    }
}
