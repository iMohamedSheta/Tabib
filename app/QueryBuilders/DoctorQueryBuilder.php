<?php

namespace App\QueryBuilders;

use App\QueryBuilders\Base\QueryBuilderWrapper;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class DoctorQueryBuilder extends QueryBuilderWrapper
{
    public function getOrganizationDoctors(): static
    {
        $this->query
            ->select([
                'doctors.id as doctor_id',
                'doctors.specialization',
                'doctors.user_id',
                'doctors.created_at',
                'users.id',
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

    public function searchDoctors($search): static
    {
        $this->query->when($search, function ($query) use ($search): void {
            $query->where(function ($query) use ($search): void {
                $query->whereAny(['users.first_name', 'users.last_name', 'users.phone', 'users.other_phone', 'doctors.specialization'], 'LIKE', "%{$search}%")
                    ->orWhereConcat(['users.first_name', 'users.last_name'], $search);
            });
        });

        return $this;
    }

    protected function initializeQuery(): Builder
    {
        return DB::table('doctors');
    }
}
