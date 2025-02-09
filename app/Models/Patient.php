<?php

namespace App\Models;

use App\Models\Scopes\OrganizationScope;
use App\Traits\Embeding\HasEmbedding;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property User $user
 *
 * @method \Illuminate\Database\Eloquent\Relations\BelongsTo user()
 * @method fireModelEvent()
 */
#[ScopedBy(OrganizationScope::class)]
class Patient extends Model
{
    use HasFactory;
    use HasEmbedding;

    protected $guarded = [];

    #[\Override]
    protected static function booted()
    {
        self::deleting(function ($patient): void {
            $patient->user->delete();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class, 'clinic_id', 'id');
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'patient_id', 'id');
    }

    public function invoices()
    {
        return $this->morphMany(Invoice::class, 'model');
    }

    protected function embeddedFields(): array
    {
        return [
            'name' => trim("{$this->user->first_name} {$this->user->last_name}"),
            'gender' => $this->gender,
            'birth_date' => $this->birth_date,
            'nationality' => $this->nationality,
            'address' => $this->address,
            'marital_status' => $this->marital_status,
            'family_medical_history' => $this->family_medical_history,
            'chronic_diseases' => $this->chronic_diseases,
            'blood_type' => $this->blood_type,
            'allergies' => $this->allergies,
            'occupation' => $this->occupation,
        ];
    }
}
