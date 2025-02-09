<?php

namespace App\Models;

use App\Contracts\UserRoleModelInterface;
use App\Models\Scopes\OrganizationScope;
use App\Traits\Embeding\HasEmbedding;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property User $user
 */
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class, 'clinic_id', 'id');
    }

    protected function embeddedFields(): array
    {
        return [
            'name' => trim("{$this->user->first_name} {$this->user->last_name}"),
            'specialization' => $this->specialization,
            'license_number' => $this->license_number,
            'qualifications' => $this->qualifications,
            'notes' => $this->notes,
        ];
    }
}
