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
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property int                                                                                                                               $id
 * @property int|null                                                                                                                          $organization_id
 * @property string                                                                                                                            $first_name
 * @property string                                                                                                                            $last_name
 * @property string|null                                                                                                                       $username
 * @property string|null                                                                                                                       $email
 * @property string|null                                                                                                                       $password
 * @property string|null                                                                                                                       $two_factor_secret
 * @property string|null                                                                                                                       $two_factor_recovery_codes
 * @property string|null                                                                                                                       $two_factor_confirmed_at
 * @property int                                                                                                                               $is_active
 * @property string                                                                                                                            $role
 * @property int|null                                                                                                                          $role_id
 * @property string                                                                                                                            $last_connect
 * @property string|null                                                                                                                       $phone
 * @property string|null                                                                                                                       $other_phone
 * @property \Illuminate\Support\Carbon|null                                                                                                   $email_verified_at
 * @property string|null                                                                                                                       $profile_photo_path
 * @property string|null                                                                                                                       $oauth_id
 * @property string|null                                                                                                                       $oauth_provider
 * @property string|null                                                                                                                       $oauth_token
 * @property int|null                                                                                                                          $oauth_token_expires_in
 * @property string|null                                                                                                                       $oauth_scopes
 * @property string|null                                                                                                                       $remember_token
 * @property \Illuminate\Support\Carbon|null                                                                                                   $created_at
 * @property \Illuminate\Support\Carbon|null                                                                                                   $updated_at
 * @property ClinicAdmin|null                                                                                                                  $clinicAdmin
 * @property Doctor|null                                                                                                                       $doctor
 * @property Manager|null                                                                                                                      $manager
 * @property \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property int|null                                                                                                                          $media_count
 * @property \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification>                     $notifications
 * @property int|null                                                                                                                          $notifications_count
 * @property Organization|null                                                                                                                 $organization
 * @property Patient|null                                                                                                                      $patient
 * @property string                                                                                                                            $profile_photo_url
 * @property Receptionist|null                                                                                                                 $receptionist
 * @property \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken>                                               $tokens
 * @property int|null                                                                                                                          $tokens_count
 *
 * @method static \Database\Factories\UserFactory                    factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User likeIn(array $fields, $value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastConnect($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereOauthId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereOauthProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereOauthScopes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereOauthToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereOauthTokenExpiresIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereOtherPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereProfilePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUsername($value)
 *
 * @mixin \Eloquent
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
        // return $this->email == 'icrush15@yahoo.com';
        return Manager::class == $this->role;
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
            $query->{0 === $index ? 'where' : 'orWhere'}($field, 'LIKE', sprintf('%%%s%%', $value));
        }

        return $query;
    }
}
