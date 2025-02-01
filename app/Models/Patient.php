<?php

namespace App\Models;

use App\Models\Scopes\OrganizationScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy(OrganizationScope::class)]
class Patient extends Model
{
    use HasFactory;

    protected $guarded = [];

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

    protected static function booted()
    {
        self::deleting(function ($patient): void {
            $patient->user->delete();
        });
    }
}
