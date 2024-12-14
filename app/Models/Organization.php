<?php

namespace App\Models;

use App\Services\Organization\OrganizationSetupService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function clinics()
    {
        return $this->hasMany(Clinic::class, 'organization_id', 'id');
    }

    public function clinicServices()
    {
        return $this->hasMany(ClinicService::class, 'organization_id', 'id');
    }

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        self::created(function ($organization) {
            OrganizationSetupService::setup($organization);
        });
    }
}
