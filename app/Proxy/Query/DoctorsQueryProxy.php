<?php

namespace App\Proxy\Query;

use App\Proxy\Query\Base\QueryProxy;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class DoctorsQueryProxy extends QueryProxy
{

    protected function initializeQuery(): Builder
    {
        return DB::table('doctors');
    }

    public function getOrganizationDoctors()
    {
        $this->query
            ->select([
                'doctors.id',
                'doctors.specialization',
                'doctors.user_id',
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
            ])
            ->sameOrganization()
            ->join('users', 'doctors.user_id', '=', 'users.id')
            ->join('organizations', 'doctors.organization_id', '=', 'organizations.id')
            ->latest('doctors.created_at');

        return $this;
    }
}
