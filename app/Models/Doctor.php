<?php

namespace App\Models;

use App\Contracts\UserRoleModelInterface;
use App\Models\Scopes\OrganizationScope;
use App\Traits\Embeding\HasEmbedding;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ScopedBy(OrganizationScope::class)]
class Doctor extends Model implements UserRoleModelInterface
{
    use HasFactory;
    use HasEmbedding;

    protected $guarded = [];

    #[\Override]
    protected static function booted()
    {
        self::deleting(function ($doctor): void {
            $doctor->user->delete();
        });
    }

    protected function getEmbeddingColumns(): array
    {
        return [
            'specialization',
            'license_number',
            'qualifications',
            'notes'
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class, 'clinic_id', 'id');
    }
}
