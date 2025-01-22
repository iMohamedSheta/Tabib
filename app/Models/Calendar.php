<?php

namespace App\Models;

use App\Models\Scopes\OrganizationScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy(OrganizationScope::class)]
class Calendar extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function clinicServices()
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
}
