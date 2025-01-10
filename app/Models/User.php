<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\User\HasCustomDefaultProfilePhoto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasCustomDefaultProfilePhoto, HasProfilePhoto {
        HasCustomDefaultProfilePhoto::profilePhotoUrl insteadof HasProfilePhoto;
    }
    use HasFactory;
    use Notifiable;
    use TwoFactorAuthenticatable;

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
    ];

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

    public function isClinicAdmin(): bool
    {
        return $this->role == ClinicAdmin::class;
    }

    public function isDoctor(): bool
    {
        return $this->role == Doctor::class;
    }

    public function isPatient(): bool
    {
        return $this->role == Patient::class;
    }

    public function isReceptionist(): bool
    {
        return $this->role == Receptionist::class;
    }

    public function isManager(): bool
    {
        // return $this->email == 'icrush15@yahoo.com';
        return $this->role == Manager::class;
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function user()
    {
        switch ($this->role) {
            case ClinicAdmin::class:
                return $this->clinicAdmin();
            case Doctor::class:
                return $this->doctor();
            default:
                return $this;
        }
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
            $query->{$index === 0 ? 'where' : 'orWhere'}($field, 'LIKE', sprintf('%%%s%%', $value));
        }

        return $query;
    }
}
