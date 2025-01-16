<?php

namespace App\Models;

use App\Models\Scopes\OrganizationScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy(OrganizationScope::class)]
/**
 * 
 *
 * @property int $id
 * @property int|null $organization_id
 * @property int $level
 * @property string $code
 * @property string $name
 * @property int $type
 * @property string $status
 * @property int $plan_id
 * @property string|null $location
 * @property string|null $lease_expired_at
 * @property string|null $lease_started_at
 * @property int|null $sub_clinic_admin_id
 * @property int|null $parent_clinic_id
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Organization|null $organization
 * @property-read Clinic|null $parentClinic
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Clinic> $subClinics
 * @property-read int|null $sub_clinics_count
 * @method static \Database\Factories\ClinicFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clinic newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clinic newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clinic query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clinic whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clinic whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clinic whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clinic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clinic whereLeaseExpiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clinic whereLeaseStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clinic whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clinic whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clinic whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clinic whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clinic whereParentClinicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clinic wherePlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clinic whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clinic whereSubClinicAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clinic whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clinic whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Clinic extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function subClinics()
    {
        return $this->hasMany(self::class, 'parent_clinic_id', 'id');
    }

    public function parentClinic()
    {
        return $this->belongsTo(self::class, 'parent_clinic_id', 'id');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public static function list(): array
    {
        return self::pluck('name', 'id')->toArray();
    }
}
