<?php

namespace App\Models;

use App\Contracts\UserRoleModelInterface;
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
 * @property int $user_id
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Clinic|null $clinic
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Clinic> $subClinics
 * @property-read int|null $sub_clinics_count
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\ClinicAdminFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicAdmin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicAdmin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicAdmin query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicAdmin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicAdmin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicAdmin whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicAdmin whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicAdmin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicAdmin whereUserId($value)
 * @mixin \Eloquent
 */
class ClinicAdmin extends Model implements UserRoleModelInterface
{
    use HasFactory;

    public const TYPE_SUPER_ADMIN = 'super_admin';

    public const TYPE_ADMIN = 'admin';

    protected $guarded = [];

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        self::deleting(function ($clinicAdmin): void {
            // Check when deleting main admin if he have clinic and delete it with all the other info
            if (self::TYPE_SUPER_ADMIN == $clinicAdmin->type && $clinicAdmin->clinic) {
                $clinicAdmin->clinic->delete();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class, 'clinic_id', 'id');
    }

    public function subClinics()
    {
        return $this->hasMany(Clinic::class, 'sub_clinic_admin_id', 'id');
    }
}
