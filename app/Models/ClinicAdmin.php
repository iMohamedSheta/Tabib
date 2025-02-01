<?php

namespace App\Models;

use App\Contracts\UserRoleModelInterface;
use App\Models\Scopes\OrganizationScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy(OrganizationScope::class)]
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

            $clinicAdmin->user->delete();
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
