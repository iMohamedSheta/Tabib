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
 * @property string $puid
 * @property int $user_id
 * @property int $clinic_id
 * @property int $age
 * @property string $birth_date
 * @property string $gender
 * @property int|null $nationality
 * @property string|null $address
 * @property string|null $allergies
 * @property string|null $notes
 * @property string|null $family_medical_history
 * @property string|null $chronic_diseases
 * @property string|null $national_card_id
 * @property string|null $blood_type
 * @property int|null $height
 * @property string|null $marital_status
 * @property string|null $occupation
 * @property string|null $insurance_number
 * @property string|null $insurance_provider
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Clinic|null $clinic
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereAllergies($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereBloodType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereChronicDiseases($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereClinicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereFamilyMedicalHistory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereInsuranceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereInsuranceProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereMaritalStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereNationalCardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereNationality($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereOccupation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient wherePuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereUserId($value)
 * @mixin \Eloquent
 */
class Patient extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class, 'clinic_id', 'id');
    }
}
