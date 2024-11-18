<?php

namespace App\Proxy\Query\Complicated;

use App\Proxy\Query\Complicated\base\QueryProxy;
use App\Proxy\Query\Complicated\Scopes\OrganizationScope;
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

    public function organizations()
    {
        $this->query->join('organizations', 'doctors.organization_id', '=', 'organizations.id');
        return $this;
    }

    public static function getDoctors(
        array $relations = ['users', 'organizations'],
        array $select =
        [
            'doctors.id',
            'doctors.specialization',
            'doctors.user_id',
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
            'organizations.id as organization_id',
            'organizations.name as organization_name',
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
        $this->data->getCollection()->transform(function($doctor) {
            $doctor->fullname = $doctor->first_name . ' ' . $doctor->last_name;
            $doctor->profile_photo_url = GetProfilePhotoUrlService::handle($doctor->profile_photo_path, $doctor->username, $doctor->first_name);
        });
    }

    public function globalScopes(): array
    {
        return [
            OrganizationScope::class
        ];
    }

}
