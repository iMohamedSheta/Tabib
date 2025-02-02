<?php

namespace App\Models;

use App\Services\Internal\Organization\OrganizationSetupService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        self::created(function ($organization): void {
            OrganizationSetupService::setup($organization);
        });
    }

    public function clinics()
    {
        return $this->hasMany(Clinic::class, 'organization_id', 'id');
    }

    public function clinicServices()
    {
        return $this->hasMany(ClinicService::class, 'organization_id', 'id');
    }

    public function clinicAdmins()
    {
        return $this->hasMany(ClinicAdmin::class, 'organization_id', 'id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'organization_id', 'id');
    }

    public function patients()
    {
        return $this->hasMany(Patient::class, 'organization_id', 'id');
    }
}
