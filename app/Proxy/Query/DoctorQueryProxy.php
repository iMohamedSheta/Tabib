<?php

namespace App\Proxy\Query;

use App\Proxy\Query\Scopes\ClinicIdScope;
use App\Services\User\GetProfilePhotoUrlService;
use Illuminate\Support\Facades\DB;

class DoctorQueryProxy extends QueryProxy
{
    protected function __construct()
    {
        parent::__construct(DB::table('doctors'));
    }

    public function users()
    {
        $this->query->join('users', 'doctors.user_id', '=', 'users.id');
        return $this;
    }

    public function clinics()
    {
        $this->query->join('clinics', 'doctors.clinic_id', '=', 'clinics.id');
        return $this;
    }

    public static function getDoctors(
        array $relations = ['users', 'clinics'],
        array $select =
        [
            'doctors.id',
            'doctors.specialization',
            'doctors.user_id',
            'doctors.clinic_id',
            'doctors.biography',
            'doctors.created_at',
            'users.id as user_id',
            'users.first_name',
            'users.last_name',
            'users.username',
            'users.password',
            'users.email',
            'users.is_active',
            'users.role',
            'users.role_id',
            'users.last_connect',
            'users.profile_photo_path',
            'users.phone',
            'users.other_phone',
            'clinics.id as clinic_id',
            'clinics.name as clinic_name'
        ],
        bool $allowCache = false,
        int $cacheTTL = null,
        array $globalScopes = null
    ) {
        return self::Instance()
            ->cacheKey('clinic_doctors')
            ->allowCache($allowCache, $cacheTTL)
            ->withRelations($relations)
            ->applyGlobalScopes($globalScopes)
            ->select($select);
    }


    public function postProcessor(): void
    {
        $this->data->each(function ($doctor) {
            $doctor->fullname = $doctor->first_name . ' ' . $doctor->last_name;
            $doctor->profile_photo_url = GetProfilePhotoUrlService::handle($doctor->profile_photo_path, $doctor->username, $doctor->first_name);
        });
    }

    public function globalScopes(): array
    {
        return [
            ClinicIdScope::class
        ];
    }

}
