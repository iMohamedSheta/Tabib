<?php

namespace App\Models;

use App\Services\Organization\OrganizationSetupService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int                                                          $id
 * @property string                                                       $billing_code
 * @property string                                                       $name
 * @property string|null                                                  $logo
 * @property \Illuminate\Support\Carbon|null                              $created_at
 * @property \Illuminate\Support\Carbon|null                              $updated_at
 * @property \Illuminate\Database\Eloquent\Collection<int, ClinicAdmin>   $clinicAdmins
 * @property int|null                                                     $clinic_admins_count
 * @property \Illuminate\Database\Eloquent\Collection<int, ClinicService> $clinicServices
 * @property int|null                                                     $clinic_services_count
 * @property \Illuminate\Database\Eloquent\Collection<int, Clinic>        $clinics
 * @property int|null                                                     $clinics_count
 * @property \Illuminate\Database\Eloquent\Collection<int, User>          $users
 * @property int|null                                                     $users_count
 *
 * @method static \Database\Factories\OrganizationFactory                    factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereBillingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
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

    public function clinicAdmins()
    {
        return $this->hasMany(ClinicAdmin::class, 'organization_id', 'id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'organization_id', 'id');
    }

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
}
