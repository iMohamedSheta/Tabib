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
}
