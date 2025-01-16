<?php

namespace App\Models;

use App\Contracts\UserRoleModelInterface;
use App\Models\Scopes\OrganizationScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ScopedBy(OrganizationScope::class)]
/**
 * 
 *
 * @property int $id
 * @property int|null $organization_id
 * @property int $user_id
 * @property string $specialization
 * @property string|null $license_number
 * @property string|null $qualifications
 * @property string|null $clinics
 * @property string|null $available_days
 * @property string|null $start_time
 * @property string|null $end_time
 * @property string|null $telehealth_phone
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Clinic|null $clinic
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\DoctorFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereAvailableDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereClinics($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereLicenseNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereQualifications($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereSpecialization($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereTelehealthPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereUserId($value)
 * @mixin \Eloquent
 */
class Doctor extends Model implements UserRoleModelInterface
{
    use HasFactory;

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class, 'clinic_id', 'id');
    }
}
