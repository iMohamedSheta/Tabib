<?php

namespace App\Models;

use App\Models\Scopes\OrganizationScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy(OrganizationScope::class)]
class Event extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * The accessors to append to the model's array form.
     */
    protected $appends = [
        'decoded_data',
    ];

    public function clinicService()
    {
        return $this->belongsTo(ClinicService::class, 'clinic_service_id', 'id');
    }

    // In CalendarModel.php
    public function getDecodedDataAttribute(): ?object
    {
        $decoded = json_decode($this->data, false);

        // Ensure the decoded data is an object
        return is_object($decoded) ? $decoded : null;
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class, 'clinic_id', 'id');
    }
}
