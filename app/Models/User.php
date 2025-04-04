<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\Models\User\HasCustomDefaultProfilePhoto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property string|null $profile_photo_url
 */
class User extends Authenticatable implements HasMedia
{
    use HasApiTokens;
    use HasCustomDefaultProfilePhoto, HasProfilePhoto {
        HasCustomDefaultProfilePhoto::profilePhotoUrl insteadof HasProfilePhoto;
    }
    use HasFactory;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
        'fullname',
    ];

    public function role(): MorphTo
    {
        return $this->morphTo();
    }

    public function getFullnameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function isClinicAdmin(): bool
    {
        return ClinicAdmin::class == $this->role;
    }

    public function isDoctor(): bool
    {
        return Doctor::class == $this->role;
    }

    public function isPatient(): bool
    {
        return Patient::class == $this->role;
    }

    public function isReceptionist(): bool
    {
        return Receptionist::class == $this->role;
    }

    public function isManager(): bool
    {
        return Manager::class == $this->role;
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function clinicAdmin()
    {
        return $this->hasOne(ClinicAdmin::class, 'user_id', 'id');
    }

    public function doctor()
    {
        return $this->hasOne(Doctor::class, 'user_id', 'id');
    }

    public function patient()
    {
        return $this->hasOne(Patient::class, 'user_id', 'id');
    }

    public function receptionist()
    {
        return $this->hasOne(Receptionist::class, 'user_id', 'id');
    }

    public function manager()
    {
        return $this->hasOne(Manager::class, 'user_id', 'id');
    }

    public function scopeLikeIn($query, array $fields, $value)
    {
        $value = trim((string) $value);

        foreach ($fields as $index => $field) {
            $query->{0 === $index ? 'where' : 'orWhere'}($field, 'LIKE', sprintf('%%%s%%', $value));
        }

        return $query;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
